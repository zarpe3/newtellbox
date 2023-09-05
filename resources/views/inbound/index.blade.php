
@extends('layouts.app', ['activePage' => 'inbound', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'laravel'])

@section('content')
<div id="app"></div>
<div class="content">
    @if(isset($success) && $success === false)
        @include('alerts.error_response')
    @endif

    @if(isset($success) && $success && $message != "")
        @include('alerts.success_response')
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Rotas</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/{{$customer}}/inbound/create" class="btn btn-sm btn-default">Adicionar Rota de Entrada</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table id="inbounds" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th> Ações </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inbounds as $inbound)
                                    <tr>
                                        <td> {{ $inbound['name'] }} </td>
                                        <td class="d-flex">
                                            <a href="/{{$customer}}/inbound/{{ $inbound['id'] }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a v-on:click="remove('{{ base64_encode(json_encode($inbound)) }} ')">
                                                <i class="fa fa-trash" style="color: red"></i>
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

</div>
@endsection

@push('js')
<script type="text/javascript">
</script>
<script src="{{ asset('/js/inbounds.js') }}"></script>
@endpush
