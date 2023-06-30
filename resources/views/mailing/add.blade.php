@extends('layouts.app', ['activePage' => 'mailing-import', 'title' => 'Importação', 'navName' => 'Importação', 'activeButton' => 'mailings'])

@section('content')
@if(isset($success) && $success === false)
    @include('alerts.error_response')
@endif

@if(isset($success) && $success && $message != "")
    @include('alerts.success_response')
@endif

@if($success)
<div id="app" class="content">
    <mailing-import extens="{{json_encode($extens)}}" routesdata="{{ json_encode($routes) }}"></mailing-import>
</div>
@endif
@endsection