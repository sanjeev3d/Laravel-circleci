<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function getDataFoToken($token)
    {
        return VerifyUser::where('token', $token)->first();
    }

    /*** Relationship ***/
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
