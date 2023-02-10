@extends('layouts.app', ['activePage' => 'cdr', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'reports'])

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
                                <h3 class="mb-0">Relatório CDR</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-8">
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <form id="contact-form" role="form" method="POST" action="/report/cdr/search">
                            @csrf
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">Data inicio</label>
                                            <input id="start_date" type="date" name="start_date" class="form-control" @isset($request['start_date']) value="{{ $request['start_date'] }}" @endisset required="required" data-error="Datainicio é obrigatório.">  
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_time">Tempo inicio</label>
                                            <input id="start_time" type="text" name="start_time" value="00:00" class="form-control" required="required" data-error="tempoinicio é obrigatório.">  
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date">Data fim</label>
                                            <input id="end_date" type="date" name="end_date" @isset($request['end_date']) value="{{ $request['end_date'] }}" @endisset class="form-control"  required="required" data-error="datafim é obrigatório">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_time">Tempo fim</label>
                                            <input id="end_time" type="text" name="end_time" value="23:59" class="form-control" required="required" data-error="tempofim é obrigatório.">  
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" name="status" class="form-control" required="required">
                                                <option value="0">Todos</option>
                                                <option value="ANSWER">Atendida</option>
                                                <option value="NOANSWER">Não Atendida</option>
                                                <option value="BUSY">Ocupada</option>
                                                <option value="CONGESTION">Falha</option>
                                                <option value="CHANUNAVAIL">Tronco Indisponível</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="display: flex;width: 100%; justify-content: end;">
                                        <button id="search" class="btn btn-primary">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table id="routes" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Inicio</th>
                                    <th>Fim</th>
                                    <th>Status</th>
                                    <th>Billing</th>
                                    <th>Custo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cdrs as $cdr)
                                <tr>
                                    <td>
                                    @if ($cdr['audio'] != "") 
                                        <a class="btn-sm btn-success" data-toggle="collapse" href="#{{$cdr['uniqueid']}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    @endif
                                    </td>
                                    <td>{{ $cdr['src'] }}</td>
                                    <td>{{ $cdr['dst'] }}</td>
                                    <td>{{ $cdr['start_date'] }}</td>
                                    <td>{{ $cdr['end_date'] }}</td>
                                    <td>{{ $cdr['status'] }}</td>
                                    <td>{{ $cdr['billsec'] }}</td>
                                    <td>{{ number_format(floatval($cdr['rating']), 2, '.', '') }}</td>
                                </tr>
                                @if ($cdr['audio'] != "") 
                                <tr class="collapse table-dark" id="{{$cdr['uniqueid']}}">
                                    <td> - </td>
                                    <td>Duracao: </td>
                                    <td>{{ $cdr['billsec']}}s</td>
                                    <td colspan="1">
                                        <audio style="width: 200px" controls src="{{ $cdr['audio'] }}"></audio>
                                    </td>
                                </tr>
                                @endif
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
        $('#start_time').mask('00:00:00');
        $('#end_time').mask('00:00:00');
    });
</script>
<script src="{{ asset('/js/routes.js') }}"></script>
@endpush
