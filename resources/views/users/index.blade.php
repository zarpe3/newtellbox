@extends('layouts.app', ['activePage' => 'users', 'title' => 'Tellbox Varejo', 'navName' => 'Usuários', 'activeButton' => 'laravel'])

@section('content')
<div class="content">

    @if(isset($success) && $success === false)
        @include('alerts.error_response')
    @endif

    @if(isset($success) && $success)
        @include('alerts.success_response')
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div id="app" class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Usuários</h3>
                                <p class="text-sm mb-0">
                                    Gerenciamento de Usuarios
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/users/create" class="btn btn-sm btn-default">Adicionar Usuario</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div id="users" class="card-body table-full-width table-responsive">

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
                                    <p>Você tem certeza de que deseja remover o usuario @{{ name }}</p>
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
                                <tr><th>Name</th>
                                    <th>Email</th>
                                    <th>Data Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['created_at'] }}</td>
                                    <td class="d-flex">

                                        <a href="/users/{{$user['id']}}/edit"><i class="fa fa-edit"></i></a>
                                        <a style="color: red;" v-on:click="modalRemove('{{ base64_encode(json_encode(['name' => $user['name'], 'id' => $user['id']]))}}')"><i class="fa fa-trash"></i></a>
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
<script src="{{ asset('/js/users.js') }}"></script>
@endpush