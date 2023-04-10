@extends('layouts.app', ['activePage' => 'mailings', 'title' => 'Acompanhamento', 'navName' => 'Acompanhamento', 'activeButton' => 'mailings'])

@section('content')
<div id="app" class="content">
   <mailing-follow-up></mailing-follow-up>
</div>
@endsection