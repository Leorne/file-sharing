@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
@endsection()

@section('content')
    <upload-file></upload-file>
@endsection


