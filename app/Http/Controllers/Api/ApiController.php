<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            return response()->json(['token' => $token, 'user' => Auth::user()], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    public function index()
    {
        $articles = Article::with(['owner', 'comments'])->get();

        return response(['success' => true, 'articles' => $articles]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'tags' => 'required',
            // 'image' => 'nullable|image',
            'description' => 'nullable',
            'status' => 'nullable'
        ]);

        $userId = Auth::user()->id;

        $article = Article::create(array_merge($request->all(), ['created_by' => $userId]));

        return response([
            'success' => true,
            'article' => $article,
            'message' => 'article stored....'
        ]);
    }

    public function getArticle($id)
    {
        $article = Article::with(['owner', 'comments'])->where('id', $id)->firstOrFail();

        return response([
            'success' => true,
            'article' => $article,
            'message' => 'article fetched....'
        ]);
    }
}
