@extends('layouts.app', ['activePage' => 'routes', 'title' => 'Telbox Varejo', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div id="app" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Adicionar Rota de Entrada</h3>
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
                        <form id="inbounds" method="post" action="{{ route('inbound.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Criação de Rota de Entrada') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome da rota') }}" value="" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' DID') }}
                                    </label>
                                    <input type="text" name="did" id="input-name" class="form-control{{ $errors->has('did') ? ' is-invalid' : '' }}" placeholder="{{ __('DID') }}" value="" required autofocus>
                                </div>
                                <add-inbound extendata="{{json_encode($extens)}}" ivrdata="{{ json_encode($ivrs) }}" queuedata="{{json_encode($queues)}}"></add-inbound>
                            
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

<script type="text/javascript">
    var extensData = {!! json_encode($extens) !!};
</script>
@endpush