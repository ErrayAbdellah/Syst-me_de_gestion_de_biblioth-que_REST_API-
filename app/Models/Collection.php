<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    // protected $hidden =['pivot'];

    public function article(){
        return $this->hasMany(Livre::class);
    }
}
