<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\UserManager;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use App\Http\Controllers\HelperController as Common;


class AdminController extends Controller
{
    
    /**
    * @response {
    *  "status": "success",
    *  "message": "string",
    *  "data":  {
        "id": "integer",
        "name": "string",
        "email": "string",
        "email_verified_at": "string",
        "created_at": "string [date-time]",
        "updated_at": "string [date-time]"
        }
    * }
    * @response 404 {
        "status": "error",
        "message": "404 Not Found"
    }   
    * @response 422 {
        "status": "error",
        "message": "Unauthenticated"
    }
    */
    public function loggedInUser(Request $req)
    {
        return Common::response('success','User Record!' , json_decode((string) $req->user(),true) );
    }
}

