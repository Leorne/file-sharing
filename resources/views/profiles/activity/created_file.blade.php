@component('profiles.activity.activity');
@slot('header')
    <i class="fas fa-upload"></i> Uploaded file <a
        href="{{ $activity->subject->path() }}">"{{ $activity->subject->name }}"</a>
@endslot

{{--@slot('body')--}}

{{--@endslot--}}

@endcomponent
