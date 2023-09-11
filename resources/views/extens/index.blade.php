@extends('layouts.app', ['activePage' => 'extens', 'title' => 'Telbox Varejo', 'navName' => 'Ramais', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    @if($success)
        <exten :extradata="{{ $extens }}" :extraroutes="{{ $routes }}"></exten>
    @endif

    @if(!$success)
        @include('alerts.error_response')
    @endif
</div>
@endsection
@push('js')
@endpush