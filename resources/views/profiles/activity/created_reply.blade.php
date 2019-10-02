@component('profiles.activity.activity');
@slot('header')
    Commented file <a
        href="{{ $activity->subject->path() }}">"{{ $activity->subject->file->name }}"</a>
@endslot

@slot('body')
    {{$activity->subject->body}}
@endslot

@endcomponent
