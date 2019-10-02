@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <h1>Here u can upload ur files</h1>
                        <div class="form-group">
                            <form method="POST" class="form-control-file" enctype="multipart/form-data"
                                  action="/main/upload">
                                {{csrf_field()}}
                                <input type="file" name="file" class="form-control-file mb-3">
                                <input type="submit" name="submit" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
