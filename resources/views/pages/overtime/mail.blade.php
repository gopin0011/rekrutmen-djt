
@component('mail::message')
# Overtime

Pengajuan overtime:

## Detail overtime:

@component('mail::table')
    |                                           |   |
    |------------------------------------------:|---|
    | {{ $details['greeting'] }}                |   |
    | {{ $details['head'] }}                    |   |
    | {{ $details['line1'] }}                   |   |
    | {{ $details['line2'] }}                   |   |
    | {{ $details['line3'] }}                   |   |
    | {{ $details['line4'] }}                   |   |
    | {{ $details['line5'] }}                   |   |
    | {{ $details['footnote'] }}                |   |
    |------------------------------------------:|---|
@foreach ($peoples as $people)
    | {{ $people['nik']}},  {{$people['nama'] }}|   |
@endforeach

@endcomponent



@endcomponent
