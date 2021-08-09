<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('articles.index')->with('message', 'Article added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::with(['owner', 'comments'])->where('id', $id)->firstOrFail();

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::where('id', $id)->firstOrFail();

        return view('articles.edit', compact('article'));
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
        $this->validate($request, [
            'title' => 'required',
            'tags' => 'required',
            // 'image' => 'nullable|image',
            'description' => 'nullable',
            'status' => 'nullable'
        ]);

        $article = Article::where('id', $id)->firstOrFail();

        $article->update($request->all());

        return redirect()->route('articles.index')->with('message', 'Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::where('id', $id)->firstOrFail();
        $article->delete();

        return redirect()->route('articles.index')->with('message', 'Article deleted successfully');
    }

    public function storeComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        $userId = auth()->user()->id;

        $comment = Comment::create([
            'comment' => $request->comment,
            'article_id' => $request->article_id,
            'comment_by' => $userId
        ]);

        return back()->with('message', 'thank you for comments');
    }

    public function storeImage(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg, jpeg',
        ]);

        $article = Article::findOrFail($id);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $img = $request->image;
            $filename = $img->getClientOriginalName();
            $imageUrl = Storage::putFileAs('/public/images', $request->file('image'), $filename);
        }

        $article->image = $imageUrl;
        $article->save();

        return back()->with('message', 'image upload successfully');
    }
}
