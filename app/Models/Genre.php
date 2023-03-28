<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];


    // protected $hidden =['pivot'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function genre(){
        return $this->hasMany(Genre::class);
    }
}
