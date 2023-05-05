<!-- <iframe src="{{$rekrutmen_pdf}}" style="width: 100vw; height: 100vh;"></iframe>
<iframe src="{{$cv_url}}" style="width: 100vw; height: 100vh;"></iframe> -->
<iframe src ="{{ asset('/laraview/#../'.$rekrutmen_pdf) }}" style="width: 100vw; height: 100vh;"></iframe>
@if($cv_url)
<iframe src ="{{ asset('/laraview/#../'.$cv_url) }}" style="width: 100vw; height: 100vh;"></iframe>
@endif