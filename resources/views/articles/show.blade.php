@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="{{ (Auth::user()->is_author) ? 'col-md-8' : 'col-md-9 mx-auto' }}">
            <div class="card">
                <img class="card-img-top" src="{{ Storage::url($article->image) }}" alt="Card image cap">
                <div class="card-header" >
                    {{-- <img src="{{ Storage::url($article->image) }}" class="img-fluid" width="100%" alt=""> --}}
                    <h5>{{ $article->title }}</h5>
                </div>
                <div class="card-body">
                    <h5>Tags: </h5>
                    @foreach (explode(',', $article->tags) as $tag)
                        <span class="badge badge-primary">{{ $tag }}</span>
                    @endforeach
                    <div class="text-right">
                        <p>{{ $article->owner->name }}</p>
                        <i>{{ $article->created_at }}</i>
                    </div>
                    <div class="content py-3">
                        {!! $article->description !!}
                    </div>
                    <hr>
                    <div class="comment-block">
                        <div class="comments">
                            <h5>Comments : {{ count($article->comments) }}</h5>
                            @forelse ($article->comments as $comment)
                            <ul class="list-unstyled">
                                <li class="media">
                                <img src="/img/user.png" width="50px" alt="">
                                <div class="media-body ml-3">
                                      <h5 class="mt-0 mb-1">{{ $comment->commented_by->name }} <i>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</i> </h5>
                                    {{ $comment->comment }}
                                  </div>
                                </li>

                              </ul>
                            @empty
                                Be a first person to comment
                            @endforelse
                        </div>
                        <hr>
                        <form action="/comment/store" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea id="comment" class="form-control" name="comment" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <button class="btn btn-primary" type="submit">Comment</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @if (Auth::user()->is_author)

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Image</h5>

                    <form action="/upload/article-image/{{ $article->id }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="custom-file mb-3">
                               <input id="image" class="custom-file-input" type="file" name="image">
                               <label for="image" class="custom-file-label">Image</label>
                           </div>
                           @error('image')
                               <small class="form-text text-dager">{{ $message }}</small>
                           @enderror

                           <button class="btn btn-primary" type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
