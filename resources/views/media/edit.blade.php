@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="page-content">
            <form action="{{ route('media.update', ['id' => $id, 'album_id' => $album_id]) }}" enctype="multipart/form-data"
                method="put" class="ajax-form">
                @method('put')
                @csrf
                <div class="widget">
                    <div class="widget-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image </label>
                                    <input type="file" class="jfilestyle" name="image" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $media->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="custom-btn green-bc" type="submit">
                                Store
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
