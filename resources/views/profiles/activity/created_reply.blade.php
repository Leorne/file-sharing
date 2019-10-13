@component('profiles.activity.activity');
@slot('header')
    <i class="fas fa-comment"></i> Commented file <a
        href="{{ $activity->subject->path() }}">"{{ $activity->subject->file->name }}"</a>
@endslot

@slot('body')
    {{$activity->subject->body}}
@endslot

@endcomponent
