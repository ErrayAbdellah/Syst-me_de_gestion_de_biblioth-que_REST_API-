<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    // protected $hidden =['pivot'];
    public function collection(){
        return $this->belongsTo(Collection::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}
