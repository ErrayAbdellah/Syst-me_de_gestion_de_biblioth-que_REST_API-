<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    //
    public function roleChange(Request $request,$id){
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string',
        ]);
        

        try{
            $user->role_id = $request->name;
           $user->update();
            return response()->json(['data'=>$request->name]);
        }catch(Exception $e){
            return response()->json(['error'=>$e]);

        }
    }


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
        // $role = User::with(['role'])->find($user->id);
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

    public function destroy($id)
    {
        Book::find($id)->delete();
       
        return response()->json([
            'success'=>'Book has been delete',
        ], 201);
    }
}
