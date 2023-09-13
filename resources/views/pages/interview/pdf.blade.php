
@if($cv)
<iframe src ="{{ asset('/laraview/#../storage/doc/'.$cv->dokumen.'.pdf') }}" width="1000px" height="600px"></iframe>
@endif


@if(count($additionalFiles))
@foreach($additionalFiles as $file)
<iframe src ="{{ asset('/laraview/#../storage/additional/'.$file->file.'.pdf') }}" width="1000px" height="600px"></iframe>
@endforeach
@endif