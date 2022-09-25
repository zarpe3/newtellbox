@extends('layouts.app', ['activePage' => 'users', 'title' => 'Tellbox Varejo', 'navName' => 'Users', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div id="app" class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                                <p class="text-sm mb-0">
                                    Gerenciamento de Usuarios
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/users/create" class="btn btn-sm btn-default">Add Usuario</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table id="users" class="table table-hover table-striped">
                            <thead>
                                <tr><th>Name</th>
                                    <th>Email</th>
                                    <th>Start</th>
                                    <th>Actions</th>
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
                                        <a style="color: red;" v-on:click="remove('{{ base64_encode(json_encode(['id' => $user['id']]))}}')"><i class="fa fa-trash"></i></a>
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