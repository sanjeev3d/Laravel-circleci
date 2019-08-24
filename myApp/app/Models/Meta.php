<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';
    protected $fillable = [
        'name', 'content', 'meta_id', 'meta_type', 
        'status'
    ];

    public function meta()
    {
        return $this->morphTo();
    }
}
