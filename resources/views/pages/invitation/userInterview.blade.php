
@component('mail::message')

{!! nl2br($text) !!}

@component('mail::button', ['url' => $url])
    Isi Hasil Interview
@endcomponent

## Detail Kandidat:

@component('mail::table')
    |                 |                           |
    | --------------- | -------------------------:|
    | Nama kandidat   | {{ $name }}               |
    | Posisi          | {{ $vacancy }}            |
    | Tanggal         | {{ $date }}               |
@endcomponent

@endcomponent
