<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordSecurity extends Model
{
    protected $guarded = [];

    public static function create($data) {        
        $model = new PasswordSecurity;
        is_array($data) ? $model->fill($data) : $model->fill((array) $data);    
        return $model->save() ? $model : false;
    }

    public static function updateData($id, $data)
    {        
        if($model = PasswordSecurity::find($id)){
            is_array($data) ? $model->fill($data) : $model->fill((array)$data);        
            return $model->save() ? $model : false;
        }else{
            return 'notfound';
        }
    }

    public static function deletePasswordSecurity($id) {
        $model = PasswordSecurity::find($id);
        return $model->delete();
    }

    /*** Relations ***/
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    /*** Relations ***/
}
