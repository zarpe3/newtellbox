@extends('layouts.app', ['activePage' => 'trunks', 'title' => 'Telbox Varejo', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')

<div id="app" class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="width: 90%">
                <div class="card-header">
                    <h4 class="card-title">Adicionar Tronco modo básico</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trunks.store') }}" autocomplete="off">
                    @csrf
                    <div class="container">
                    </div>
                    <div class="row">
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <label>Tronco</label>
                                <input type="text" name="trunkName" class="form-control{{ $errors->has('trunkName') ? ' is-invalid' : '' }}" placeholder="Tronco" value="">
                            </div>
                        </div>
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" value="">
                            </div>
                        </div>
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Host</label>
                                    <input type="text" name="host" class="form-control{{ $errors->has('host') ? ' is-invalid' : '' }}" placeholder="Tronco" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="secret" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" name="code" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label>Bina</label>
                                <input type="text" name="callerid" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label>Porta</label>
                                <input type="number" name="port" class="form-control" placeholder="Port Number" value="">
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label for="transport">Transporte</label>
                                <select name="transport" class="form-control">
                                    <option value='udp'>UDP</option>
                                    <option value='tcp'>TCP</option>
                                    <option value='udp,tcp'>UDP,TCP</option>
                                    <option value='tcp,udp'>TCP,UDP</option>
                                    <option value='tls'>TLS</option>
                                    <option value='tls,udp,tcp'>TLS,UDP,TCP</option>
                                    <option value='ws,wss,udp'>ws,wss,udp</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label for="qualify">Qualify</label>
                                <select name="qualify" class="form-control">
                                    <option value='yes'>Sim</option>
                                    <option value='no'>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-left m-1">
                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                    <div class="clearfix"></div>
                    </form>
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
@endpush