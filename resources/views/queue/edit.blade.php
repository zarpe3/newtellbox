@extends('layouts.app', ['activePage' => 'queue', 'title' => 'Telbox Varejo', 'navName' => 'Usuários', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    @if(!$success)
        @include('alerts.error_response')
    @endif
    @if($success)
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Usuario</h3>
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
                        {{ Form::open(array('route' => ['queue.update', $customer, $queue['id']], 'method' => 'put')) }}
                            <h6 class="heading-small text-muted mb-4">{{ __('Edição de Fila') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome da fila') }}" value="{{$queue['name']}}" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('strategy') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="strategy">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Estrategia') }}
                                    </label>
                                    {{ Form::select('strategy', $strategy, $queue['strategy'], ['id' => 'strategy', 'class' => 'form-control']) }}
                                    
                                </div>
                                <div class="form-group{{ $errors->has('announe') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="announe">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Reproduzir Anuncios (TME e Qtd Fila') }}
                                    </label>
                                    {{ Form::select('announce', [0 => 'Não', 1 => 'Sim'], $queue['announce'], ['id' => 'announce', 'class' => 'form-control']) }}

                                </div>
                                <div class="form-group{{ $errors->has('wrapuptime') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="wrapuptime">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Tempo pré atendimento') }}
                                    </label>
                                    <input type="number" min="0" max="10" name="wrapuptime" id="wrapuptime" class="form-control{{ $errors->has('wrapuptime') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo de pré atendimento [0 - 10]') }}" value="{{$queue['wrapuptime']}}" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('timeout') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeout">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Tempo Ring Fila') }}
                                    </label>
                                    <input type="hidden" id="agents" name="agentsB64" value="<?php echo base64_encode(json_encode($queue['agents'])); ?>">
                                    <input type="number" min="0" max="90" name="timeout" id="timeout" class="form-control{{ $errors->has('timeout') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo ring Agente [0 - 10]') }}" value="{{$queue['timeout']}}" required autofocus>
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
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
        
        var agents = JSON.parse('<?php echo json_encode($queue['agents']); ?>');
        //$('#agents').val(btoa(JSON.stringify(agents));
        $('#multiple-checkboxes').multiselect('select', agents);
        $('#multiple-checkboxes').multiselect('refresh');  
        //$('#multiple-checkboxes').refresh(); 

        $('#multiple-checkboxes').on('change', function(val) {
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
