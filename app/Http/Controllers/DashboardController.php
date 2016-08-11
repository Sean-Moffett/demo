<?php

// Dashboard Controller Code

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use \App\User;      // User model
use \App\Petition;  // Petition model
use \App\Signature; // Signature model

use Auth;
use Hash;
use Redirect;
use Validator;  
use DB;
use Image;


class DashboardController extends Controller
{

    // Class constructor / regulate access to dashboard
    public function __construct()
    {
        // Deny access to dashboard if a current active user has not authenticated
        if (! Auth::check()) {
            // Send the user to the login view
            Redirect::to('/login')->send();
        }
    }


    // Show the dashboard view with relevant data
    public function getDashboard()
    {
        // Retrieve all petitions for the current user (public or private);
        $auth_user_petitions = Petition::getPetitionsWithSignatureCount(Auth::user()->id, false);
        
        // Retrieve all other public petitions from other users.
        $other_petitions      = Petition::getPetitionsWithSignatureCount(Auth::user()->id, true);
        
        // Return the dashboard view
        return view('dashboard', ['auth_user_petitions' => $auth_user_petitions, 
                                    'other_petitions'   => $other_petitions
                                 ]);
    }


    // HTTP get method endpoint to get the view used to create or edit a petition
    public function getEditPetition($id = null)
    {
        // Retrieve the petition record for the specified id if specified
        $petition = $id ? Petition::find($id) : null;

        // Return the petition edit / create view
        return view('petition-edit')->with(compact('petition'));
    }


    // HTTP post method endpoint used to submit a new or edited petition
    public function postEditPetition($id = null)
    {

        // Get the rules / validator for validating the petition input form
        $validator = $this->getPetitionEditFormValidator();

        // Make sure valid input was specified
        if ($validator->fails()) {

            // Invalid input specified... Send users back to the edit page with error message
            return redirect('/petition/edit')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            // Retrieve existing petition by id or instantiate a new petition model
            $petition = $id ? Petition::find($id) : new Petition();

            // Prime the petition model members / fields
            $petition->user_id          = Auth::user()->id;
            $petition->recipient_name   = Input::get('recipient_name');
            $petition->recipient_email  = Input::get('recipient_email');
            $petition->title            = Input::get('title');
            $petition->summary          = Input::get('summary');
            $petition->body             = Input::get('body');
            $petition->thanks_msg       = Input::get('thanks_msg');
            $petition->private          = Input::get('private') ? 1 : 0;

            // Only update the image file if a new one was specified to prevent overwrites on edits
            if (Input::hasFile('image')) {
                // Generate a file name based on a time hash and concatenate the original file name with extension
                $filename =  md5(time()) . '.' . Input::file('image')->getClientOriginalExtension();
                
                // Set the picture path member of the petition model
                $petition->picture_path = $filename ;

                // Move the image from temporary storage to the public accessible path
                $image = Input::file('image');
                $image->move(public_path(), $filename);
            }
            
            // Save the new petition record
            $petition->save();

            // Direct user back to the dashboard view
            return $this->getDashboard();
        }
    }   


    // Returns a validator object for petition input fields
    private function getPetitionEditFormValidator()
    {
        return Validator::make(Input::all(), [
            'recipient_name'  => 'required',
            'recipient_email' => 'required|email',
            'title'           => 'required',
            'summary'         => 'required',
            'body'            => 'required',
            'thanks_msg'      => 'required'
        ]);
    }

    // HTTP get method endpoint to get the view used to facilitate the signing of a petition
    public function getSignPetition($id)
    {
        // Get logged in user 
        $user = Auth::user();

        // Get the petition record if a valid id was specified.
        $petition = $id ? Petition::find($id) : null;

        // Make sure we have a petition model object in hand
        if ($petition) {

            // See if this petition was already signed by the current user. Can't sign twice; that's cheating
            if (Signature::userAlreadySignedPetiton($petition->id, $user->id)) {
                // Can't sign a petition again, redirect back to the dashboard with an error message
                return redirect('/dashboard')->withErrors(['You have already signed this petition.']);
            } else {
                // Petition signed
                return view('sign-petition')->with(compact('petition'));
            }

        } else {
            return redirect('/dashboard');     
        }        
    }


    // HTTP post method endpoint to facilitate signing of a petition
    public function postSignPetition($id)
    {

        // Get logged in user model / object
        $user = Auth::user()->id;

        // Get the rules / validator for validating the signature input form
        $validator = $this->getSignaturePetitionFormValidator();

        // Make sure valid input was specified
        if ($validator->fails()) {

            // Redirect back to the petition signing view with specified input value errors
            return redirect('/petition/sign/$id')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            // Retrieve the petition model / record by the specified id
            $petition = ($id) ? Petition::find($id) : null;

            // Make sure we have a petition model object / record
            if($petition) {

                // Create a new signature model, prime fields and save
                $signature                = new Signature();
                $signature->petition_id   = $id; 
                $signature->user_id       = $user->id;
                $signature->signature     = Input::get('signature');
                $signature->phone         = Input::get('phone');
                $signature->save();

                // Send confirmatin Email to petition signer. Would normally use a mail queue for this.
                User::sendThanksPetitionEmail($user, $petition);

                // Show the custom thanks view for the current petition.
                return view('thanks')->with(compact('petition')); 

            } else {
                // No go... Send user back to the dashboard
                return redirect('/dashboard');    
            }

        }
    }

    // Returns a validator object for petition signature input fields
    private function getSignaturePetitionFormValidator()
    {
        return Validator::make(Input::all(), [
            'signature' => 'required',
            'phone' => 'required'
        ]);
    }


    // HTTP get method endpoint to facilitate signing of a petition
    public function deletePetition($id)
    {
            // Get the petition model / record for the specified id
            $petition = $id ? Petition::find($id) : null;

            // Make sure the petition belongs to the current user... Would normally add an "are you sure" dialog here...
            if($petition && $petition->user_id == Auth::user()->id) {
                $petition->delete();
            } 

            // Redirect user back to the dashboard
            return redirect('/dashboard');    
    }


    // HTTP end point to get petition details
    public function getPetitionDetails($id)
    {
        // Get the petition model / record for the specified id
        $petition = $id ? Petition::find($id) : null;

        if($petition) {

            // Get signatures for the petition
            $signatures = Signature::getSignaturesByPetitionId($petition->id);

            // Return a view of the petition details with the associated signatures... Would normally add paging here...
            return view('view-petition')->with(compact('petition'))->with(compact('signatures') );
        }

        // Invalid petition id specified, so just redirect back to the dashboard.
        return redirect('/dashboard');
          
    }

}
