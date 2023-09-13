@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
<div id="user-data" data-user='{{ json_encode(Auth::user()) }}'></div>
<div class="wrapper">

    {{-- Preloader Animation --}}
    @if($layoutHelper->isPreloaderEnabled())
    @include('adminlte::partials.common.preloader')
    @endif

    {{-- Top Navbar --}}
    @if($layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.navbar.navbar-layout-topnav')
    @else
    @include('adminlte::partials.navbar.navbar')
    @endif

    {{-- Left Main Sidebar --}}
    @if(!$layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.sidebar.left-sidebar')
    @endif

    {{-- Content Wrapper --}}
    @empty($iFrameEnabled)
    @include('adminlte::partials.cwrapper.cwrapper-default')
    @else
    @include('adminlte::partials.cwrapper.cwrapper-iframe')
    @endempty

    {{-- Footer --}}
    @hasSection('footer')
    @include('adminlte::partials.footer.footer')
    @endif

    {{-- Right Control Sidebar --}}
    @if(config('adminlte.right_sidebar'))
    @include('adminlte::partials.sidebar.right-sidebar')
    @endif

</div>
@stop

@section('adminlte_js')
@stack('js')
<script src="{{ asset('js/file.js') }}"></script>
<script type="text/javascript">
getNotifications();
const role = ["1", "2", "3", "5"];
    var user = {!! json_encode(Auth::user()) !!};
    if(role.includes(user.admin)) {
        setInterval(async () => {
        await getNotifications();
        }, 10000);
    }
</script>
@yield('js')

@stop