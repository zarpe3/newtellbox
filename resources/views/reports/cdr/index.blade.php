@extends('layouts.app', ['activePage' => 'routes', 'title' => 'Telbox Varejo', 'navName' => '', 'activeButton' => 'laravel'])

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
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table id="routes" class="table table-hover table-striped">
                            <thead>
                                <tr>
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
                                    <td>{{ $cdr->src }}</td>
                                    <td>{{ $cdr->dst }}</td>
                                    <td>{{ $cdr->start_date }}</td>
                                    <td>{{ $cdr->end_date }}</td>
                                    <td>{{ $cdr->status }}</td>
                                    <td>{{ $cdr->billsec }}</td>
                                    <td>{{ number_format(floatval($cdr->rating), 2, '.', '') }}</td>
                                </tr>
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
<script src="{{ asset('/js/routes.js') }}"></script>
@endpush
