
@extends('layouts.app', ['activePage' => 'ivr', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'laravel'])

@section('content')
<div id="app"></div>
<div class="content">
    @if(isset($success) && $success === false)
        @include('alerts.error_response')
    @endif

    @if(isset($success) && $success && $message != "")
        @include('alerts.success_response')
    @endif

    @if(!isset($success) || $success)
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">URAs</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/{{$customer}}/ivr/create" class="btn btn-sm btn-default">Adicionar Ura</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table id="ivrs" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Audio</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ivrs as $ivr)
                                    <tr>
                                        <td> {{ $ivr['name'] }} </td>
                                        <td> {{ $ivr['audio'] }} </td>
                                        <td> 
                                            <a href="/{{$customer}}/ivr/{{$ivr['id']}}/edit"><i class="fa fa-edit"></i></a>
                                            <a style="color: red;" v-on:click="remove('{{$ivr['id']}}')">
                                                <i class="fa fa-trash"></i>
                                            </a> 
                                        </td>
                                    </tr>    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
@endsection

@push('js')
<script type="text/javascript">
</script>
<script src="{{ asset('/js/ivrs.js') }}"></script>
@endpush
