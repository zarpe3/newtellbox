@extends('layouts.app', ['activePage' => 'queue', 'title' => 'Tellbox Varejo', 'navName' => 'Filas', 'activeButton' => 'laravel'])

@section('content')
<div class="content">

    @if(isset($success) && $success === false)
        @include('alerts.error_response')
    @endif

    @if(isset($success) && $success && $message != "")
        @include('alerts.success_response')
    @endif

    @if($success)
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div id="app" class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Filas</h3>
                                <p class="text-sm mb-0">
                                    Gerenciamento de Filas
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/{{$customer}}/queue/create" class="btn btn-sm btn-default">Adicionar Fila</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div id="queue" class="card-body table-full-width table-responsive">

                    <div class="modal fade modal-large modal-primary" id="confirmation" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <div class="modal-profile">
                                        <i class="fa fa-trash"></i>
                                    </div>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Você tem certeza de que deseja remover a fila @{{ name }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button 
                                        type="button" 
                                        v-on:click="dismiss()" 
                                        class="btn btn-link btn-simple">Não
                                    </button>
                                    <button 
                                        type="button" 
                                        v-on:click="confirmRemove()" 
                                        class="btn btn-link btn-simple" 
                                        data-dismiss="modal">Sim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                        <table class="table table-hover table-striped">
                            <thead>
                                <tr><th>Nome</th>
                                    <th>Qtd Agentes</th>
                                    <th>Data Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($queues as $queue)
                                <tr>
                                    <td>{{ $queue['name'] }}</td>
                                    <td>{{ count($queue['agents'])}}</td>
                                    <td>{{ $queue['created_at'] }}</td>
                                    <td class="d-flex">

                                        <a href="/{{$customer}}/queue/{{$queue['id']}}/edit"><i class="fa fa-edit"></i></a>
                                        <a style="color: red;" v-on:click="modalRemove('{{base64_encode(json_encode(['name' => $queue['name'], 'id' => $queue['id']]))}}')"><i class="fa fa-trash"></i></a>
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
<script src="{{ asset('/js/queue.js') }}"></script>
@endpush