<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'collection',
        'isbn',
        'publication_date',
        'number_of_pages',
        'location',
    ];

    // protected $hidden =['pivot'];
    public function collection(){
        return $this->belongsTo(Collection::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}
