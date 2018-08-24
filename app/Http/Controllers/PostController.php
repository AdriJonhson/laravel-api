<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user'])->get();

        return response()->json(PostResource::collection($posts), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $user = User::find($data['user_id']);

        $data['user_id'] = $user['id'];

        $post = Post::create($data);

        return response()->json(['message' => 'Post cadastrado com sucesso.', 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if(!$post){
            return response()->json('Post não encontrado!', 400);
        }

        return response()->json($post, 200);
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
        $post = Post::find($id);

        if(!$post){
            return response()->json('Post não encontrado!', 400);
        }

        $post->update($request->all());

        return response()->json(['message' => 'Dados atualizados com sucesso'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json('Post não encontrado!', 400);
        }

        $post->delete();

        return response()->json(['message' => 'Dados deletados com sucesso!'], 200);
    }

    public function showComments($id)
    {
        $post = Post::with(['comments'])->get();

        return response()->json($post, 200);
    }
}
