@extends('layouts.app', ['activePage' => 'trunks', 'title' => 'Telbox Varejo', 'navName' => 'Troncos', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    <trunk></trunk>
</div>
@endsection
@push('js')
@endpush