@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card m-2">
            <div class="">
                <h1>
                    {{ $profileUser->name }}
                </h1>
                <img src="{{ $profileUser->avatar() }}" alt="" width="200px" height="200px">
                @can('update', $profileUser)
                    <form method="POST" class="form-control-file" enctype="multipart/form-data"
                          action="{{ route('avatar', $profileUser) }}">
                        {{csrf_field()}}

                        <input type="file" name="avatar" class="form-control-file mb-3">
                        <input type="submit" name="submit" class="btn btn-primary">
                    </form>
                @endcan
            </div>
        </div>
        <div class="card m-2">
            <div class="p-3">
                @forelse($activities as $date => $gropedActivities)
                    <h5 class="page-header">{{ $date }}</h5>
                    @foreach($gropedActivities as $activity)
                        @if(view()->exists("profiles.activity.{$activity->type}"))
                            <div class="card m-2">
                                @include("profiles.activity.{$activity->type}")
                            </div>
                        @endif
                    @endforeach
                @empty
                    <div class="text-center m-3">
                        <h5>There is no activity for this user yet.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
