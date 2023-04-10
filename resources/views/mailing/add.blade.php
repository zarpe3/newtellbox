@extends('layouts.app', ['activePage' => 'mailings.import', 'title' => 'Importação', 'navName' => 'Importação', 'activeButton' => 'mailings'])

@section('content')
<div id="app" class="content">
    <mailing-import></mailing-import>
</div>
@endsection