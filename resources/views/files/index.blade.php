@extends('layouts.app')

@section('content')
    <div class="container">
        {{ $files->links() }}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="">
                <tr>
                    <th class="col-6">Name</th>
                    <th class="col-1">Size</th>
                    <th class="col-2">Created at</th>
                    <th class="col-2">Uploaded by</th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td><a href="{{ $file->path() }}">{{ $file->name }}</a></td>
                        <td>{{ $file->formatSize() }}</td>
                        <td>{{ $file->created_at->isoFormat('M/D/YY HH:mm') }}</td>
                        <td><a href="{{route('profile', $file->uploader) }}">{{ $file->uploader->name }}</a></td>
                        <td class="text-center border-0"><a href="{{ asset("storage/$file->path") }}"
                                                            class="btn btn-outline-dark"
                                                            download="{{ $file->name }}">Download</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $files->links() }}
    </div>
@endsection
