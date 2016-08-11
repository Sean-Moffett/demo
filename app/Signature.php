<?php

// Petition Signature model class

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    // Returns a boolean value indicating if a user has already signed a petition
    public static function userAlreadySignedPetiton($petition_id, $user_id)
    {
        return Signature::where('petition_id', $petition_id)->where('user_id', $user_id)->exists();
    }

    // Returns signatures related to the specified petition id.
    public static function getSignaturesByPetitionId($petition_id)
    {
        return Signature::where('petition_id', $petition_id)->orderBy('petition_id', 'desc')->get();
    }

}
