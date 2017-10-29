<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttributes extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
