@extends('layouts.app', ['activePage' => 'trunks', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'laravel'])

@section('content')
<div id="app"></div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Troncos - Modo Básico</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/{{$customer}}/trunks/create" class="btn btn-sm btn-default">Adicionar Tronco</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div id="trunks" class="card-body table-full-width table-responsive">

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
                                    <p>Você tem certeza de que deseja remover o tronco @{{ trunkName }}</p>
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
                                    <th>Host</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trunks as $trunkName => $trunk)
                                    
                                    @foreach($trunk as $name => $prop)
                                    <tr>
                                        <td>{{$prop['trunkName']}}</td>
                                        <td>{{$prop['host']}}</td>
                                        <td>
                                            <a href="trunks/{{ base64_encode($name) }}"><i class="fa fa-edit"></i>
                                            </a>
                                            <a style="color: red;" v-on:click="modalDelete('{{ base64_encode($name) }}')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
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
    $(document).ready(function () {
        // Javascript method's body can be found in assets/js/demos.js
        //demo.initDashboardPageCharts();

        //demo.showNotification();

    });
</script>
<script src="{{ asset('/js/trunks.js') }}"></script>
@endpush
