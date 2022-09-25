@extends('layouts.app', ['activePage' => 'users', 'title' => 'Telbox Varejo', 'navName' => 'Usuários', 'activeButton' => 'laravel'])

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
                        {{ Form::open(array('route' => ['users.update', $user->id], 'method' => 'put')) }}
                            {!! method_field('PUT') !!}
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Edição de Usuario') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome do Usuario') }}" value="{{$user->name}}" required autofocus>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-default mt-4">{{ __('Save') }}</button>
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
<script type="text/javascript">
</script>
@endpush