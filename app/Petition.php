<?php

// Petition model class

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Petition extends Model
{
 
    // Handy dandy function to return petition records with an aggregate signature count.
    public static function getPetitionsWithSignatureCount($user_id, $get_other_public_petitions = false)
    {

        // When the get other public petitions is set, the query returns public petition 
        // records that do not belong to the specified user.
        $user_operator = $get_other_public_petitions ? "<>" : "=";

        $petitions = Petition::select('petitions.*', DB::raw('count(signatures.id) as signature_count'))
                                        ->leftJoin('signatures', 'petitions.id', '=', 'signatures.petition_id')
                                        ->groupBy('petitions.id')
                                        ->orderby('petitions.id', 'desc')
                                        ->where('petitions.user_id',  $user_operator, $user_id);

        // Make sure to return other petitions that public only
        if ($get_other_public_petitions) {
            $petitions->where('private', 0);
        }

        // Return the recordset
        return $petitions->get();
            
    }

}
