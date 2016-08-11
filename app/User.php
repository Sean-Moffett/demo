<?php

// Petition model class

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Hash;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // Returns a boolean indicating if a user exists for the specified email.
    public static function userExists($email) 
    {
        return User::where('email', '=', $email)->exists();
    }


    // Email a petition signature confirmation message
    public static function sendThanksPetitionEmail(User $user, Petition $petition)
    {
            //Disable for now... Will bomb if Email settings are not configured..
            return;

            Mail::send('email-thanks', ['user' => $user, 'petition' => $petition], function ($m) use ($user) {
                $m->from('thanks@phone2action.com', 'Phone2Action');
                $m->to($user->email, $user->first_name)->subject('Thanks for signing a petition.');
            });
       
    }


    // Creates a new user with the specified user argument values
    public static function createNewUser($first_name, $last_name, $email, $password)
    {
        $user             = new User();
        $user->first_name = $first_name;
        $user->last_name  = $last_name;
        $user->email      = $email;

        // Have to hash the password to obfuscate it a bit in the database... Not super secure really, but good enough.
        $user->password   = Hash::make($password);

        $user->save();

        return $user;
    }

}
