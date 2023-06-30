@extends('layouts.app', ['activePage' => 'mailing-import', 'title' => 'Importação', 'navName' => 'Importação', 'activeButton' => 'mailings'])

@section('content')

<div id="app" class="content">
    <mailing-import edit="1" extens="{{json_encode($extens)}}" mailing="{{ $mailing }}" routesdata="{{ json_encode($routes) }}"></mailing-import>
</div>
@endsection