@extends('layouts.app', ['activePage' => 'mailing-followup', 'title' => 'Acompanhamento', 'navName' => 'Acompanhamento', 'activeButton' => 'mailings'])

@section('content')
<div id="app" class="content">
   <mailing-follow-up></mailing-follow-up>
</div>
@endsection