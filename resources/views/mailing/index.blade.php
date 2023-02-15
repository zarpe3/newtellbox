@extends('layouts.app', ['activePage' => 'mailings', 'title' => 'Acompanhamento', 'navName' => 'Acompanhamento', 'activeButton' => 'mailings'])

@section('content')
<div id="app" class="content">
   <follow-up></follow-up>
</div>
@endsection