@extends('layouts.app', ['activePage' => 'campaign', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'dialer'])

@section('content')
<div id="app" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Adicionar nova Campanha</h3>
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
                            <h6 class="heading-small text-muted mb-4">{{ __('Criação de Campanha') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome da campanha') }}" value="" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('queue') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Fila') }}
                                    </label>
                                    <select name="queue" id="queue" class="form-control">

                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('mailing') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Mailing') }}
                                    </label>
                                    <select name="mailing" id="mailing" class="form-control">

                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('attempts') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Tentativas') }}
                                    </label>
                                    <select name="attempts" id="attempts" class="form-control">

                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('force') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __('Agressividade') }}
                                    </label>
                                    <select name="force" id="force" class="form-control">

                                    </select>
                                </div> 
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __('Tipo') }}
                                    </label>
                                    <select name="type" id="type" class="form-control">

                                    </select>
                                </div>
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
    
</script>
@endpush