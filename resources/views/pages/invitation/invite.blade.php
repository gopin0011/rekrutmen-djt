
@component('mail::message')
# Undangan Interview

Anda mendapatkan undangan interview dari PT. Dwida Jaya Tama:

@component('mail::button', ['url' => $url])
    Daftar akun
@endcomponent

## Detail undangan:

@component('mail::table')
    |                 |                           |
    | --------------- | -------------------------:|
    | Nama kandidat   | {{ $name }}               |
    | Posisi          | {{ $vacancy }}            |
    | Bertemu dengan  | {{ $sender }}             |
    | Tanggal         | {{ $date }}               |
    | Waktu           | {{ $time }}               |
    | Jenis interview | {{ $type }}               |
    | Link interview  | {{ $online_url }}         |
    | Invitation code | {{ $code }}               |
@endcomponent

@endcomponent
