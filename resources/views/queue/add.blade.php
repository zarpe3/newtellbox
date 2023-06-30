@extends('layouts.app', ['activePage' => 'queue', 'title' => 'Telbox Varejo', 'navName' => 'Fila', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Adicionar Fila</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post" action="{{ route('queue.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Criação de Fila') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome da fila') }}" value="" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('strategy') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="strategy">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Estrategia') }}
                                    </label>
                                    <select name="strategy" id="strategy" class="form-control">
                                        <option value="ringall">Ringar Todos</option>
                                        <option value="roundrobin">Aleatório</option>
                                        <option value="leastrecent">Menos recente</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('announe') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="announe">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Reproduzir Anuncios (TME e Qtd Fila') }}
                                    </label>
                                    <select name="announe" id="announe" class="form-control">
                                        <option value="0">Não<option value="">
                                        <option value="1">Sim</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('wrapuptime') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="wrapuptime">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Tempo pré atendimento') }}
                                    </label>
                                    <input type="number" min="0" max="10" name="wrapuptime" id="wrapuptime" class="form-control{{ $errors->has('wrapuptime') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo de pré atendimento [0 - 10]') }}" value="" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('timeout') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeout">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Tempo Ring Fila') }}
                                    </label>
                                    <input type="hidden" id="agents" name="agentsB64">
                                    <input type="number" min="0" max="90" name="timeout" id="timeout" class="form-control{{ $errors->has('timeout') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo ring Agente [0 - 10]') }}" value="" required autofocus>
                                </div>
                                <fieldset class="form-group">
                                    <label class="form-control-label" for="password">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Agentes') }}
                                    </label>
                                    <div class="form-group">
                                        <select id="multiple-checkboxes" class="form-control" multiple="multiple">
                                            @foreach ($extens as $exten)
                                                <option value="{{$exten['name']}}">{{$exten['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-default mt-4">{{ __('Salvar') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<script type="text/javascript">
    $(document).ready(function () {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
          header: "Agentes",
          minWidth:100
        });
        

        $('#multiple-checkboxes').on('change', function(val) {
            console.log($(this).val());
            $('#agents').val(btoa(JSON.stringify($(this).val())));
        });

        $('.form-group .btn-group').css('width','100%');
        $('button.multiselect').css('width','100%');

        // Javascript method's body can be found in assets/js/demos.js
        //demo.initDashboardPageCharts();

        //demo.showNotification();

    });
</script>
@endpush
