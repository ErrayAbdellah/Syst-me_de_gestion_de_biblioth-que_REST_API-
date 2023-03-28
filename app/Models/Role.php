<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];




    // protected $hidden =['pivot'];

    public function user(){
        return $this->hasMany(User::class);
    }
}
