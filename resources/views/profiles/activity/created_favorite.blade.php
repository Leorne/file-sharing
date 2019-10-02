@component('profiles.activity.activity');
@slot('header')
    Favorite a file <a
        href="{{ $activity->subject->favorited->path() }}">"{{ $activity->subject->favorited->name }}"</a>
@endslot


@endcomponent
