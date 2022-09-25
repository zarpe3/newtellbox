@extends('layouts.app', ['activePage' => 'reception', 'title' => 'Telbox Varejo', 'navName' => 'Mosaico de Ramais', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    <reception-console :extradata="{{json_encode($extens)}}"></reception-console>
</div>
@endsection
@push('js')
@endpush
