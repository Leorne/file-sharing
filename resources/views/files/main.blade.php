@extends('layouts.app')

@section('content')
    <upload-file></upload-file>

{{--        <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        @if(auth()->check())--}}
{{--                            <span class="text-center">--}}
{{--                                <h1>--}}
{{--                                    Hello. You can upload the file!--}}
{{--                                </h1>--}}
{{--                            </span>--}}
{{--                            <div class="form-group">--}}
{{--                                <form method="POST" class="form-control-file" enctype="multipart/form-data"--}}
{{--                                      action="/upload">--}}
{{--                                    {{csrf_field()}}--}}
{{--                                    <input type="file" name="file" class="form-control-file mb-3">--}}
{{--                                    <input type="submit" name="submit" class="btn btn-primary" value="Send file.">--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <span class="text-center">--}}
{{--                                <h1>--}}
{{--                                    Hello. You must be logged in to upload a file.--}}
{{--                                </h1>--}}
{{--                            </span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection


