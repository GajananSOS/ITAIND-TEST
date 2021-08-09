@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Add Article Details</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" type="text" value="{{ old('title') }}" name="title" placeholder="Enter Name">
                            @error('title')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input id="tags" class="form-control" type="text" value="{{ old('tags') }}" name="tags" placeholder="comma saperated tags">
                            @error('tags')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select name="status" id="status" class="form-control" >
                                        <option value="" {{ (old('status') == '') ? 'selected' : '' }}>Select</option>
                                        <option value="New" {{ (old('status') == 'New') ? 'selected' : '' }}>New</option>
                                        <option value="Draft" {{ (old('status') == 'Draft') ? 'selected' : '' }}>Draft</option>
                                        <option value="Published" {{ (old('status') == 'Published') ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description">{{ old('description') }}</textarea>

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
