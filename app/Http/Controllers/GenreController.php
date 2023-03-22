<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $request->validate([
            'name' => 'required|string',
        ]);

        $data = [];
        $user = JWTAuth::user();

        $data = [
            'name' => $request->name,
            'user_id' => $user->id,
        ];

        
        // return response()->json(['message'=>JWTAuth::user()->id,]);
        try{
            Genre::create($data);
            return response()->json(['message'=>'successfully added genre']);
        }catch(Exception $e){
            return response()->json([$e]);
        }
        // return response()->json(['data'=>$data]);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $genre = Genre::find($id);
        $request->validate([
            'name' => 'required|string',
        ]);

        

        $data = [
            'name' => $request->name,
        ];
        try{
            $genre->update($data);
            return response()->json([
                'success'=>'Genre has been update',
                'data' => ['genre' => $genre]
            ], 201);
        }catch(Exception $e){
            return response()->json(['error'=>$e]);
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
        try{
            Genre::find($id)->delete();
            return response()->json([
                'success'=>'genre has been delete',
            ], 201);
        }catch(Exception $e){
            return response()->json(['error'=>$e]);
        }
        
    }
}
