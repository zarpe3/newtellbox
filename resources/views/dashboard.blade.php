@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Tellbox Varejo', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Ramais') }}</h4>
                            <p class="card-category">{{ __('Lista de Ramais cadastrados') }}</p>
                        </div>
                        <div class="card-body ">
                            
                            @foreach ($dashboard['extens'] as $exten)    
                            <div class="alert alert-info"> {{ substr($exten['name'], -4)}}</div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Troncos') }}</h4>
                            <p class="card-category">{{ __('Lista de troncos cadastrados') }}</p>
                        </div>
                        <div class="card-body ">
                            @foreach ($dashboard['trunks'] as $trunkName => $trunk)    
                                <div class="alert alert-warning">  {{ $trunkName }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Filas') }}</h4>
                            <p class="card-category">{{ __('Lista de Filas cadastradas') }}</p>
                        </div>
                        <div class="card-body ">
                            @foreach ($dashboard['queues'] as $queue)    
                                <div class="alert alert-danger"> {{ $queue['name'] }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
        });
    </script>
@endpush