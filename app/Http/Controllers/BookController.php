<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware('isAdmin',['only'=>['update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Book::with(['collection','genre'])->get();
        return response()->json([$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = [];
        $request->validate([
            'title' => 'required|string',
            'auteur' => 'required|string',
            'isbn' => 'required|string',
            'Nombre_page' => 'required|string',
            'place' => 'required|string',
            'date_publication' => 'required|string',
            'status' => 'required|string',
            'genre_id' => 'required|string',
            'collection_id' => 'required|string',
        ]);
        $user = JWTAuth::user();
            $data =[
                'title'=>$request->title,
                'auteur'=>$request->auteur,
                'isbn'=>$request->isbn,
                'Nombre_page'=>$request->Nombre_page,
                'place'=>$request->place,
                'date_publication'=>$request->date_publication,
                'status'=>$request->status,
                'user_id'=>$user->id,
                'genre_id'=>$request->genre_id,
                'collection_id'=>$request->collection_id,
            ];

            try{
                Book::create($data);
            }catch(Exception $e){
                return response()->json(['error'=> $e->getMessage()]);
            }
            return response()->json(['message'=>'successfully added book']);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($request)
    {
        //
        $user = Book::with('collection','genre')->whereHas('genre',function($query)use($request){
            // $query->whereHas('genre',function($query)use($request){
                $query->where('name','like','%'.$request.'%');
            // }
            })->get();
        return response()->json([$user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $book =Book::find($id);
        $data = [];
        $request->validate([
            'title' => 'required|string',
            'auteur' => 'required|string',
            'isbn' => 'required|string',
            'Nombre_page' => 'required|string',
            'place' => 'required|string',
            'date_publication' => 'required|string',
            'status' => 'required|string',
            'genre_id' => 'required|string',
            'collection_id' => 'required|string',
        ]);
        $user = JWTAuth::user();
        if($book->user_id == $user->id){
            $data =[
                'title'=>$request->title,
                'auteur'=>$request->auteur,
                'Nombre_page'=>$request->Nombre_page,
                'place'=>$request->place,
                'date_publication'=>$request->date_publication,
                'status'=>$request->status,
                'genre_id'=>$request->genre_id,
                'collection_id'=>$request->collection_id,
            ];
            try{
                $book->update($data);
                return response()->json([
                    'success'=>'Book has been update',
                    'data' => ['book' => $book]
                ], 201);
            }catch(Exception $e){
                return response()->json(['error'=>$e->getMessage()]);
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)->delete();
       
        return response()->json([
            'success'=>'Book has been delete',
        ], 201);
    }
}
