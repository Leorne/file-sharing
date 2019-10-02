@component('profiles.activity.activity');
@slot('header')
    Uploaded file <a
        href="{{ $activity->subject->path() }}">"{{ $activity->subject->name }}"</a>
@endslot

{{--@slot('body')--}}

{{--@endslot--}}

@endcomponent
