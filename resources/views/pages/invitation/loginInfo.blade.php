
@component('mail::message')

## Detail Kandidat:

@component('mail::table')
    |                 |                           |
    | --------------- | -------------------------:|
    | Nama kandidat   | {{ $name }}               |
    | Email          | {{ $email }}            |
    | Password         | {{ $passwd }}               |
@endcomponent

@component('mail::button', ['url' => $url])
    Login
@endcomponent

{!! nl2br($text) !!}

@endcomponent
