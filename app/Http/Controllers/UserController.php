<?php

// User Controller code... Could use the built in Laravel stuff, but like to customize.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use \App\User;
use Validator;
use Auth;


class UserController extends Controller
{

    // HTTP get endpoint to get the login view
    public function getLogin()
    {
        return view('login');
    }


    // HTTP post endpoint to submit login credentials
    public function postLogin()
    {
        // Get the rules / validator for validating the login input form
        $validator = $this->getLoginFormValidator();

        // Make sure valid login input was specified
        if ($validator->fails()) {

            // Invalid login details specified, redirect back to the login view with error message
            return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            // Valid login form input was specified, so let's try to login now and return the result
            return $this->login(Input::get('email'), Input::get('password'));
        }
    }


    // Returns a validator object for login input fields
    private function getLoginFormValidator()
    {
        return Validator::make(Input::all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }


    // HTTP get endpoint to get the login view
    public function getRegistration()
    {
        return view('register');
    }


    // HTTP post endpoint to submit user registration form field values
    public function postRegistration()
    {
        // Get the rules / validator for validating the registration input form
        $validator = $this->getRegistrationFormValidator();

        // Make sure valid registration form input values were specified
        if ($validator->fails()) {

            // Invalid registration form field values specified, so redirect back with error message.
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Make sure there isn't a user with the specified Email already in the system.
        if (! User::userExists(Input::get('email'))) {

            // Great! Email doesn't exist, so we can create a new user.
            $user = User::createNewUser(Input::get('first_name'), Input::get('last_name'), Input::get('email'), Input::get('password'));
   
            // Go ahead and log the new user in.
            return $this->login(Input::get('email'), Input::get('password'));

        } else {

            // User already exists... Redirect back to the registration form with an error message
            return redirect('/register')
                        ->withErrors(['Email (' . Input::get('email') . ') is already registered'])
                        ->withInput();
        }

    }


    // Returns the rules / validator for validating the registration input form
    private function getRegistrationFormValidator()
    {
        return Validator::make(Input::all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }


    // Attempt a login with a specified Email address and password
    private function login($email, $password)
    {
        // Try logging in with the specified email and password
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/dashboard');
        } else {

            // Failed to login, so redirect back to the login form with an error message
            return redirect('/login')
                        ->withErrors(['Invalid Login!'])
                        ->withInput();
        }      
    }


    // HTTP get endpoint for logging out of the application
    public function getLogout()
    {
        // Log the current user out and redirect back to the login view.
        Auth::logout(); 
        return redirect('/login');   
    }

}
