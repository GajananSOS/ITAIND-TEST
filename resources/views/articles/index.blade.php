@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    @if (!auth()->user()->is_author)

                    <a href="{{ route('articles.create') }}" class="btn btn-primary float-right">Add New</a>
                    @endif
                    <h5>Articles : {{ $articles->total() }}</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">

                        <form class="form-inline" method="get" action="/search-post">
                            <div class="form-group">
                                <label for="search">Search by Name</label>
                                <input id="search" class="form-control" type="text" name="search" placeholder="type editor name">
                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    @php
                        $x = 1;
                    @endphp
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Sr. No</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Tags</th>
                                <th>Created By</th>
                                @if (!auth()->user()->is_author)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                            <tr>
                                <td>{{ $x++ }}</td>
                                <td>
                                    <img src="{{ Storage::url($article->image) }}" alt="" width="50px">
                                </td>
                                <td><a href="{{ route('articles.show', $article->id) }}">{{ Str::limit($article->title, 50, '...') }}</a></td>

                                <td>
                                    @foreach (explode(',', $article->tags) as $tag)
                                    <span class="badge badge-primary">{{ $tag }}</span>
                                @endforeach
                                </td>
                                <td>{{ $article->owner->name }}</td>
                                <td>
                                    @if (auth()->user()->id == $article->created_by)
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info btn-sm">Edit</a>
                                    <a href="{{ route('article.delete', $article->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
