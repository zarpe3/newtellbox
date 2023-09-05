@extends('layouts.app', ['activePage' => 'voicemail', 'title' => 'Tellbox Varejo', 'navName' => 'Voicemail', 'activeButton' => 'laravel'])

@section('content')
<div id="app">
</div>
<div class="content" id="voicemail">
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a v-bind:class="{ active: params }" v-on:click="showParams()" class="nav-link" aria-current="page" href="#">Parametros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" v-on:click="showVoicemails()" v-bind:class="{ active: voicemails }" href="#">Voicemails</a>
            </li>
        </ul>
    </div>
    <div class="container-fluid" v-show="params">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Parametros do Voicemail</h3>
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
                        <form method="post" action="{{ route('voicemail.update', $customer) }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="notify_voicemail">
                                        <i class="fa fa-envelope"></i>{{ __(' Notificar por Email') }}
                                    </label>
                                    {!! Form::select('notify_voicemail', [1 => 'Sim', 0 => 'Não'], $voicemail_notify, ['class' => 'form-control']) !!}
                                </div> 
                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">
                                        <i class="fa fa-envelope"></i>{{ __(' Email para receber voicemails') }}
                                    </label>
                                    <input type="text" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email da conta') }}" value="{{ $email }}" required autofocus>
                                </div>
                            </div> 
                            <div class="text-center">
                                <button type="submit" class="btn btn-default mt-4">{{ __('Salvar') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" v-show="voicemails">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div id="app" class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Voicemails</h3>
                                <p class="text-sm mb-0">
                                    Lista de Voicemails
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
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Data</th>
                                    <th>Audio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voicemails as $voicemail)
                                    <tr>
                                        <td>{{ $voicemail['name'] }}</td>
                                        <td>{{ $voicemail['src'] }}</td>
                                        <td>{{ $voicemail['dst'] }}</td>
                                        <td>{{ $voicemail['created_at'] }}</td>
                                        <td><audio controls src="{{$voicemail['audio']}}" /></td>
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
</script>
<script src="{{ asset('/js/voicemail.js') }}"></script>
@endpush