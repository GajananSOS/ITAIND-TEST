@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Article Details</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('articles.update', $article->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" type="text" value="{{ $article->title }}" name="title" placeholder="Enter Name">
                            @error('title')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input id="tags" class="form-control" type="text" value="{{ $article->tags }}" name="tags" placeholder="comma saperated tags">
                            @error('tags')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select name="status" id="status" class="form-control" >
                                        <option value="" {{ ($article->status == '') ? 'selected' : '' }}>Select</option>
                                        <option value="New" {{ ($article->status == 'New') ? 'selected' : '' }}>New</option>
                                        <option value="Draft" {{ ($article->status == 'Draft') ? 'selected' : '' }}>Draft</option>
                                        <option value="Published" {{ ($article->status == 'Draft') ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description">{!! $article->description !!}</textarea>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'description' );
</script>
@endsection
