@extends('layouts.app', ['activePage' => 'ivr', 'title' => 'Telbox Varejo', 'navName' => 'Audios', 'activeButton' => 'laravel'])

@section('content')

<div id="app" class="content">
@if(isset($message))
@include('alerts.success_response')
@endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar URA</h3>
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
                        {{ Form::open(array('route' => ['ivr.update', $ivr['id']], 'method' => 'put')) }}
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Edição de URA') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome do Audio') }}" value="{{$ivr['name']}}" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('audio') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="audio">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Audio') }}
                                    </label>
                                    <select class="form-control" name="audio" id="audio">
                                        @foreach ($audios as $audio)
                                        @php
                                        $selected = '';
                                        if ($audio == $ivr['audio']) {
                                            $selected = 'selected="selected"';
                                        }
                                        @endphp
                                            <option {{$selected}} value="{{$audio}}">{{$audio}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <ivr-options extendata="{{json_encode($extens)}}" ivrdata="{{json_encode($ivr)}}" queuedata="{{json_encode($queues)}}"></ivr-options>
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