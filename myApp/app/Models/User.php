<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Models\Meta;

class User extends Authenticatable {

    use HasApiTokens, Notifiable;

    public function __construct() {
        parent::__construct();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name', 
        'timezone', 
        'phone', 
        'dob', 
        'activation_code', 
        'external_id', 
        'metadata', 
        'status', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function create($data) {
        $model = new User;
        is_array($data) ? $model->fill($data) : $model->fill((array) $data);
        $model->password = bcrypt($model->password);
        return $model->save() ? $model : false;
    }

    public static function updateData($user, $data)
    {
        if(is_object($user) and $model = $user){ //When user object
            is_array($data) ? $model->fill($data) : $model->fill((array)$data);        
            return $model->save() ? $model : false;
        }elseif($model = User::find($user)){ //When user id
            is_array($data) ? $model->fill($data) : $model->fill((array)$data);        
            return $model->save() ? $model : false;
        }else{
            return 'usernotfound';
        }
    }

    public static function isUserExistByActivationCode($code)
    {
        return User::where('activation_code', $code)->first();
    }

    public static function deleteUser($id) {
        $model = User::find($id);
        return $model->delete();
    }

    public static function isUserExistByEmail($email) {
        return User::where('email', $email)->first();
    }

    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public static function getPasswordSecurity($user){
        return $user->with('passwordSecurity');
    }

    public static function getMeta($user){
        return $user->with('meta');
    }

    /*** Relations ***/
    public function passwordSecurity(){
        return $this->hasOne('App\Models\PasswordSecurity');
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_user');
    }

    public function verifyUser() {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function meta()
    {
        return $this->morphMany(Meta::class, 'meta');
    }
    /*** Relations ***/


}
