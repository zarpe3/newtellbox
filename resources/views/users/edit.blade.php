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
                        {{ Form::open(array('route' => ['users.update', $responseUser->id], 'method' => 'put')) }}
                            <h6 class="heading-small text-muted mb-4">{{ __('Edição de Usuario') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Nome') }}
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome do Usuario') }}" value="{{ $responseUser->name }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __(' Alterar Senha') }}
                                    </label>
                                    <select name="updatePassword" class="form-control">
                                        <option selected="selected" value="0">Não</option>
                                        <option value="1">Sim</option> 
                                    </select>
                                </div>
                                <div id="password" class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}" style="display: none;">
                                    <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-map-big"></i>{{ __('Senha') }}
                                    </label>
                                    <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Novo password') }}" value="{{ $responseUser->password }}" required autofocus>
                                </div>
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
<script type="text/javascript">
    old_password = "{{ $responseUser->password }}";
    $(function(){
        $('select[name=updatePassword]').on('change', function() {
            if ($(this).val() == '1') {
                $('#password').show();
                $('#input-password').val(""); 
                return;
            }

            $('#password').hide();
            $('#input-password').val(old_password);
        })
    })
</script>
@endpush