@extends('layouts.app', ['activePage' => 'inbound', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'laravel'])

@section('content')

<div id="app" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Rota</h3>
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
                        {{ Form::open(['route' => ['inbound.update', $id], 'method' => 'put']) }}
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <h6 class="heading-small text-muted mb-4">{{ __('Criação de Rota') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome da rota') }}" value="{{$inbound[0]->name}}" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' DID') }}
                                    </label>
                                    <input type="text" name="did" id="input-name" class="form-control{{ $errors->has('did') ? ' is-invalid' : '' }}" placeholder="{{ __('DID') }}" value="{{$inbound[0]->did}}" required autofocus>
                                </div>
                                <div class="form-group">
                                <edit-inbound queuedata="{{json_encode($queues)}}" extendata="{{json_encode($extens)}}" inbounddata="{{ json_encode($inbound[0]) }}"></edit-inbound>
                                </div>
                                <div class="text-left m-1">
                                <button type="submit" class="btn btn-success">{{ __('Salvar') }}</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        // Javascript method's body can be found in assets/js/demos.js
        //demo.initDashboardPageCharts();

        //demo.showNotification();

    });
</script>
@endpush