@extends('layouts.app')

@section('content')
    <div class="container">
        <profile-form :user="{{ $profileUser }}"></profile-form>

        <div class="card-header mt-5 text-center">Activity feed</div>
        <div class="card py-2">
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
