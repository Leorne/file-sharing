@component('profiles.activity.activity');
@slot('header')
    <i class="fas fa-star"></i> Favorite a file <a
        href="{{ $activity->subject->favorited->path() }}">"{{ $activity->subject->favorited->name }}"</a>
@endslot


@endcomponent
