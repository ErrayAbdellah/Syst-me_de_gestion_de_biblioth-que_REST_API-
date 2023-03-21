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
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];


    // protected $hidden =['pivot'];

    public function book(){
        return $this->hasMany(Book::class);
    }
}
