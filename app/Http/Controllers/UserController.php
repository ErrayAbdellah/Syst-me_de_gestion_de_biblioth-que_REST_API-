<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = Book::with(['collection','genre'])->get();
        return response()->json([$user]);
    }
    
    public function show($request)
    {        
        $user = Book::with('collection','genre')->whereHas('genre',function($query)use($request){
            // $query->whereHas('genre',function($query)use($request){
                $query->where('name','like','%'.$request.'%');
            // }
            })->get();
        return response()->json([$user]);

    }

}
