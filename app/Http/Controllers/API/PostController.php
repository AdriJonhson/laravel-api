<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'showComments']]);
    }

    public function index()
    {
        $posts = Post::with(['user'])->get();

        return response()->json(PostResource::collection($posts), 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $user = User::find($data['user_id']);

        $data['user_id'] = $user['id'];

        $post = Post::create($data);

        return response()->json(['message' => 'Post cadastrado com sucesso.', 'data' => $post], 201);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if(!$post){
            return response()->json('Post não encontrado!', 400);
        }

        return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json('Post não encontrado!', 400);
        }

        $post->update($request->all());

        return response()->json(['message' => 'Dados atualizados com sucesso'], 202);
    }

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
        $post = Post::where('id', $id)
                ->with('comments')
                ->get();

        return response()->json(CommentResource::collection($post), 200);
    }
}
