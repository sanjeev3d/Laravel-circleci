<?php

namespace App\Classes;

use App\Models\User as UserModel;
use App\Classes\HelperManager as Common;
use App\Models\VerifyUser;
use App\Models\PasswordSecurity;
use App\Models\OauthAccessToken;
use Carbon\Carbon;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\LoginController;
use Lcobucci\JWT\Parser;

class UserManager
{
    public static function find($id)
    {        
        return UserModel::find($id);
    }

    public static function create($req)
    {
        $sendEmail = true;
        if($req->metadata){
            $metadata = json_decode($req->metadata, true);
            //$req = (object)$req->except(['metadata']);
            $req->request->remove('metadata');
            
        }
        //dd($req->all());

        if(env('OPEN_REGISTRATION_ALLOWED') == false && !isset($req->activation_code))
        {
            return Common::response('error', __('auth')['open_reg_deny_no_activation_code']);
        }
        
        if(isset($req->activation_code)){
            if(self::isEmailUnique($req->email, $req->activation_code) > 1)//For Existing User
            {
                return self::getEmailValidationErrorMessage();//structured error msg
            }

            $exist = UserModel::isUserExistByActivationCode($req->activation_code);//check & get user for activation code
            if($exist){
                $data = $req->all();                
                $data['password'] = bcrypt($req->password);
                if($req->dob && $req->dob != '') $data['dob'] = Carbon::parse($req->dob)->format('Y-m-d');
                $user = UserModel::updateData($exist, $data);  //Update existing User   
                if($exist->email == $req->email) $sendEmail = false;
            }else{
                return Common::response('error', __('auth')['invalid_activation_code']);
            }
        }else{
            if(self::isEmailUnique($req->email) > 0) //For New User
            {
                //dd(self::getEmailValidationErrorMessage());
                return self::getEmailValidationErrorMessage();//structured error msg
            }
            if($req->dob && $req->dob != '') 
                $req->merge(['dob' => Carbon::parse($req->dob)->format('Y-m-d')]);
            $req->merge(['name' => $req->first_name .' '.$req->last_name]);
            $user = UserModel::create($req->all());//Create New user

        }
        
        self::SetPasswordSecurity($user);//set password expiry after fixed duration
        self::metaUpdateOrCreate($user, $metadata);
        self::VerifyUser($user, $sendEmail); //insert verify token & sending email
    	$response = Common::login($req->email, $req->password); //Login passport

        return Common::response('success', 
        ($sendEmail == true) ? __('auth')['register_success_email_send'] : __('auth')['register_success']
        , json_decode((string) $response->getBody(),true) );
    }    

    public static function updateData($user, $data)
    {                
        return UserModel::updateData($user, $data);
    }

    public static function isUserExistByEmail($email)
    {
        return UserModel::isUserExistByEmail($email);
    }    

    public static function isEmailUnique($email, $code='')
    {
        if($code != '')
           return UserModel::where('email', $email)->where('activation_code', $code)->count();
        else
           return UserModel::where('email', $email)->count();
    }

    public static function getEmailValidationErrorMessage()
    {
        return response(['status' => 'error', 'message' => __('handler')['validation_exception'], 
                'errors' => [
                    'email' => [__('email_taken')]
                ]]);
    }

    public static function VerifyUser($user, $isSendEmail)
    {
        $verifyUser = VerifyUser::updateOrCreate(
            [ 'user_id' => $user->id ],
            [
                'user_id' => $user->id,
                'token' => str_random(40)
            ]
        );

        if(isset($user->activation_code) && $user->activation_code != ''){
            return VerifyUser::where('id', $verifyUser->id)->update(['verified' => 1]);
        }
        if($isSendEmail == true){ EmailController::VerifyMail($user); }
    }

    public static function SetPasswordSecurity($user)
    {
        $passwordSecurity = PasswordSecurity::create([
            'user_id' => $user->id,
            'password_expiry_days' => env('EXPIRE_PASSWORD_IN_DAYS', 90),
            'password_updated_at' => Carbon::now(),
        ]);
    }

    public static function resetPassword($id, $password)
    {
        $res = UserModel::updateData($id, ['password' => bcrypt($password)]);
        
        if($res == 'usernotfound'){
            return (object)array(
                'status' => 'error',
                'message' => __('auth')['user_not_found']
            );
        }elseif($res == true){
            return (object)array(
                'status' => 'error',
                'message' => __('auth')['password_change_success']
            );
        }elseif($res == false){
            return (object)array(
                'status' => 'error',
                'message' => __('auth')['password_change_failed']
            );
        }        
    }

    public static function isPasswordExpired($user)
    {
        if(env('PASSWORD_EXPIRE_SECURITY', false) == false){
            return false;
        }
        $password_updated_at = $user->passwordSecurity->password_updated_at;
        $password_expiry_days = $user->passwordSecurity->password_expiry_days;
        $password_expiry_at = Carbon::parse($password_updated_at)->addDays($password_expiry_days);
        if($password_expiry_at->lessThan(Carbon::now())){ return true; }
    }

    public static function getPasswordRules()
    {
        $string = 'required';
        if(env('PASSWORD_VALIDATION_MIN') && env('PASSWORD_VALIDATION_MIN') != ''){ $string .= '|min:'.env('PASSWORD_VALIDATION_MIN'); }
        if(env('PASSWORD_VALIDATION_MAX') && env('PASSWORD_VALIDATION_MAX') != ''){ $string .= '|max:'.env('PASSWORD_VALIDATION_MAX'); }
        if(env('PASSWORD_VALIDATION_REGEX1') && env('PASSWORD_VALIDATION_REGEX1') != ''){ $string .= '|regex:/['.env('PASSWORD_VALIDATION_REGEX1').']/'; }
        if(env('PASSWORD_VALIDATION_REGEX2') && env('PASSWORD_VALIDATION_REGEX2') != ''){ $string .= '|regex:/['.env('PASSWORD_VALIDATION_REGEX2').']/'; }
        if(env('PASSWORD_VALIDATION_REGEX3') && env('PASSWORD_VALIDATION_REGEX3') != ''){ $string .= '|regex:/['.env('PASSWORD_VALIDATION_REGEX3').']/'; }
        if(env('PASSWORD_VALIDATION_REGEX4') && env('PASSWORD_VALIDATION_REGEX4') != ''){ $string .= '|regex:/['.env('PASSWORD_VALIDATION_REGEX4').']/'; }
        //dump($string);
        return $string;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /****** Login ******/
    public static function login($request)
    {
        $user = UserManager::isUserExistByEmail($request->email); //check if user exist for given email
        if(!$user){
            return response(['status'=>'error','message'=> __('auth')['user_not_found'] ]);
        }

        //if(Hash::check($request->password, $user->password)){
        //if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $login = new LoginController;
        $login->maxAttempts = (env('LOGIN_ATTEMPTS_BEFORE_LOCK') == 0) ? 1000 : env('LOGIN_ATTEMPTS_BEFORE_LOCK');
        $login->decayMinutes = env('PASSWORD_LOCK_TIME_IN_MINUTES'); 
        if($login->login($request)){
            unset($user->password);            
            if(UserManager::isPasswordExpired($user)) //check password security expire
            {
                return Common::response('error', __('auth')['password_expired']);
            }
            
            $response = Common::login($request->email, $request->password); //Passport login
            $data['user'] = $user;
            $data['auth'] = json_decode((string) $response->getBody(),true);
            return Common::response('success',__('auth')['login_success'] , $data);
        }else{
            return Common::response('error', __('auth')['password_not_match']);
        }
    }

    public static function logout($request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');        
        if($id != ''){
            OauthAccessToken::where('id', $id)->update([
                'revoked' => true
            ]);            
            return Common::response('success', __("auth")['logout_success']);
        }else{
            return Common::response('status' , __("auth")['logout_failed']);
        }
    }
    /****** Login ******/



























    /*** Meta ***/
    public static function find_meta_where($id, $search)
    {        
        $u = UserModel::where('id', $id);
        //find($id);        
        return $u->with([ 'meta' => function($query) use ($search) {
            $query->where('name', $search);
          }])->get()->toArray();
        //->where('name', 'author');
    }

    public static function find_meta($id)
    {        
        return UserModel::with('meta')->find($id);        
    }

    public static function createMeta($user, $data)
    {
        $user->meta()->createMany($data);
    }

    public static function metaUpdateOrCreate($user, $data, $where = [])
    {
        if(isset($data[0]) && !is_array($data[0])){
            $data[] = $data;
        }
        foreach($data as $index=>$item){
            $key = array_keys($item);
            $key = $key[0];
            //   dump($key);
            //   dump($item[$key]);
            //foreach($item as $index2=>$item2){
                // dump($index2);
                // dump($item2);
                $modalData = array(
                    'name' => $key,
                    'content' => $item[$key],
                );
                
            $user->meta()->updateOrCreate(['name' => $key], $modalData);
             //}
         }
         
    }
    /*** Meta ***/

}
