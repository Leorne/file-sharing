@extends('layouts.app')

@section('content')
    <file-view inline-template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-9">
                                    {{ $file->name }}
                                </div>
                                <div class="col-lg-3 text-right">
                                    @can('delete', $file)
                                        <form action="{{ $file->path() }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-dark">Delete File</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            @if(view()->exists("files.types.".explode('/',$file->mime,-1)[0]))
                                @include("files.types.".explode('/',$file->mime,-1)[0])
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4 align-items-center my-auto">
                                    <img class="img-fluid mb-3"
                                         src="{{ $file->extensionImage() }}">
                                    <h4><a href="{{ $file->path }}" class="btn btn-outline-dark"
                                           download="{{ $file->name }}">Download</a>
                                    </h4>
                                </div>
                                <div class="col-8">
                                    <ul class="text-left pl-0">
                                        <li class="list-group-item">Name: {{ $file->name }}</li>
                                        <li class="list-group-item">Extension: {{ $file->extension }}</li>
                                        @if(isset($file->additional_data['resolution']))
                                            <li class="list-group-item">
                                                Resolution: {{ $file->additional_data['resolution'] }}</li>
                                        @endif
                                        @if(isset($file->additional_data['playtime']))
                                            <li class="list-group-item">
                                                Lenght: {{ $file->additional_data['playtime'] }}</li>
                                        @endif
                                        <li class="list-group-item">Size: {{ $file->size }}</li>
                                        <li class="list-group-item">Uploaded
                                            at: {{ $file->created_at->toDayDateTimeString() }}</li>
                                        <li class="list-group-item">
                                            <div style="position: relative">
                                                <div class="level">
                                                    <span class="flex">Uploader:</span>
                                                    <span class="flex">
                                                <profile-flash :user="{{ $file->uploader }}"></profile-flash>
                                            </span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if(Auth::check())
                            <div class="row justify-content-center">
                                <favorite :file="{{ $file }}"></favorite>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <replies :initial-replies-count="{{ $file->replies_count }}"></replies>
                </div>
            </div>
        </div>
    </file-view>
@endsection

