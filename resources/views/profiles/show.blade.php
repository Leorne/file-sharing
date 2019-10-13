@extends('layouts.app')

@section('content')
    <div class="container">
        <profile-form :user="{{ $profileUser }}"></profile-form>
        <div class="card pb-2 mt-5">
            <div class="text-center p-2" style="background: #343a40; color: #fff">
                <h5>Activity feed</h5>
            </div>
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
