<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $with = ['user'];

    protected $fillable = [
        'title',
        'user_id',
        'status',
        'deadline',
    ];

    public function user()
    {
      return $this->belongsTo('App\Models\User');
    }


}
