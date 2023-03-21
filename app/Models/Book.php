<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'auteur',
        'isbn',
        'Nombre_page',
        'place',
        'date_publication',
        'status',
        'user_id',
        'genre_id',
        'collection_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // protected $hidden =['pivot'];
    public function collection(){
        return $this->belongsTo(Collection::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}
