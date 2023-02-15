@extends('layouts.app', ['activePage' => 'mailings.import', 'title' => 'Importação', 'navName' => 'Importação', 'activeButton' => 'mailings'])

@section('content')
<div id="mailing" class="content">
    <import></import>
</div>
@endsection
@push('js')
<script type="text/javascript">
</script>
<script src="{{ asset('/js/mailing.js') }}"></script>
@endpush