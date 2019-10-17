@component('mail::message')
#Last step of registration
Click the button to confirm your Email.
Then you will be able to upload files and take part in the discussion.
@component('mail::button', ['url' => '#'])
Confirm Email
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
