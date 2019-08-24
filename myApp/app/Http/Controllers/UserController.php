<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\HelperManager as Common;
use App\Classes\UserManager;
use App\Classes\VerifyUserManager;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * @bodyParam username string required User Unique UserName
     * @bodyParam email string required User Email
     * @bodyParam password string required User Password
     * @bodyParam first_name string required User First Name
     * @bodyParam last_name string required User Last Name
     * @bodyParam activation_code string  User Activation Code
     * @bodyParam external_id string  User External Id
     * @bodyParam metadata json  User Meta data [{"title":"Tapas"}, {"url" : "https://www.yahoo.com/"}]
     * @bodyParam timezone string  User timezone
     * @response 200 {
        "status": "success",
        "message": "User Registered Successfully! An email activation link have been sent at your email address",
        "data": {
            "token_type": "Bearer",
            "expires_in": 31622400,
            "access_token": "string",
            "refresh_token": "string"
        }
     }
     * @response 422 {
            "status": "error",
            "message": "The given data was invalid.",
            "errors": {
                "email": [
                    "The Email field is required."
                ],
                "username": [
                    "The Username field is required."
                ],
                "first_name": [
                    "The First Name field is required."
                ],
                "last_name": [
                    "The Last Name field is required."
                ],
                "password": [
                    "The Password field is required."
                ]
            }
        }
     * @response 404 {
        "status": "error",
        "message": "404 Not Found"
    }
    */

    public function register(Request $req)
    {
        $req->validate([
    		'email'	=> 'required|email:rfc,dns',
    		'username'	=> 'required|unique:users,username',    		
    		'first_name'	=> 'required',
    		'last_name'	=> 'required',
    		'metadata'	=> 'json',
            'password'	=> UserManager::getPasswordRules(), //fetch config password rules
            ''
            ]);            
        //    dd(json_decode($req->metadata, true));
        return Usermanager::create($req);
        
    }

    public function loggedInUser(Request $req)
    {
        return $req->user();
    }
    
    /**
     * @bodyParam  email string required User Email
     * @bodyParam password string required User Password
     * 
    * @response {
     * "status":"success",
     * "message":"User Login Successfully!",
     * "data":{
     *  "user":{
     *      "id":1,
     *      "name":"string",
     *      "email":"string",
     *      "username":"string",
     *      "first_name":"string",
     *      "last_name":"string",
     *      "timezone":"string",
     *      "phone":"string",
     *      "dob":"string",
     *      "activation_code":"string",
     *      "external_id":"string",
     *      "metadata":"string",
     *      "email_verified_at":"string",
     *      "status":"integer",
     *      "created_at":"datetime",
     *      "updated_at":"datetime"
     *   },
     *   "auth":{
     *      "token_type":"Bearer",
     *      "expires_in":"timestamp",
     *      "access_token":"string",
     *      "refresh_token":"string"
     *   }
     * }
     * }
    * @response 404 {
        "status": "error",
        "message": "404 Not Found"
    }   
    * @response 422 {
        "status": "error",
        "message": "The given data was invalid.",
        "errors": {
            "email": [
                "The Email field is required."
            ],
            "password": [
                "The Password field is required."
            ]
        }
    }   
    */
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        return UserManager::login($request);
    }

    /**  
     * @bodyParam  refresh_token string required Provide refresh token
     * @response 200 {
         "status": "success",
         "message": "Auth Token Refreshed Successfully!",
         "data": {
             "auth": {
                 "token_type": "Bearer",
                 "expires_in": "timestamp",
                 "access_token": "string",
                 "refresh_token": "string"
             }
         }
     }
      * @response 200 {
          "status": "error",
        "message": "The refresh token is invalid."
     }
    * @response 401 {
        "status": "error",
        "message": "Unauthenticated"
    }
    * @response 404 {
        "status": "error",
        "message": "404 Not Found"
    }
    */
    public function refreshToken(Request $request) {
        $validated = $request->validate([
                'refresh_token'=>'required',
            ]);  
        
        $response = Common::refreshToken(request('refresh_token'));      
        
        $isError = (object)json_decode((string) $response->getBody(), true);
        if(isset($isError->error) and $isError->error  == 'invalid_request'){ //if found error for new token
            return Common::response('error',__('auth')['invalid_refresh_token']);            
        }
        return Common::response('success',__('auth')['token_refresh_success'] , array('auth' => json_decode((string) $response->getBody(), true)));
    }

    public function all(){
        $all = User::all();
        return response(['users' => $all]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password'=>'required',
            'cpassword' => 'required|same:password'
        ]);

        $return = UserManager::resetPassword($request->id, $request->password);
        return response(['status' => $return->status, 'message' => $return->message]);
    }
    
    /**
     * @response 401 {
        "status": "error",
        "message": "Unauthenticated"
    }
    * @response 404 {
        "status": "error",
        "message": "404 Not Found"
    }
     * @response 200 {
        "status": "success",
        "message": "Logout Successfully"
    }
    */

    public function logout(Request $request)
    {
        return UserManager::logout($request);
    }

    public function verifyUser($token)
    {
        echo VerifyUserManager::verifyToken($token);        
    }












    /*** Just for Testing will remove later***/
    public function add()
    {
    	$a = new User();
		$a->name = 'Test';    	
		$a->email = 'test@test.com';    	
		$a->password = bcrypt(123);    	
		$a->remember_token = '123';    	
		$a->save();
    }

    public function test()
    {
        dump(UserManager::find_meta_where(51, 'title'));
    }

    public function createInRelationship()
    {
        $u = UserManager::find(19);
        UserManager::createMeta($u,
        [
            [
                'name' => 'new test fro controllr',
                'content' => 'new test fro controllr',
                'meta_type' => 'App\Models\User'
           ]
        ]);
        dump($u);
        //dump($u->meta);
    }
    /*** Just for Testing will remove later***/
}
