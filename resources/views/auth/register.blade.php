@extends('layouts.app', ['activePage' => 'register', 'title' => 'Criar Conta'])

@section('content')
    <div class="full-page register-page section-image" data-color="webdec" data-image="{{ asset('light-bootstrap/img/phone.jpeg') }}">
        <div class="content">
            <div class="container">
                <div class="card card-register card-plain text-center">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-5 ml-auto">
                                <div class="media">
                                    <div class="media-left">
                                        <div class="icon">
                                            <i class="nc-icon nc-circle-09"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4>{{ __('Nova conta') }}</h4>
                                        <p>{{ __('Mais ligações por muito menos. Trabalhe daqui, de lá ou de onde quiser') }}</p>
                                        <p>{{ __('Você quer que a ligações no seu negócio sejam faceis, certo? Então você está no lugar certo') }}</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <div class="icon">
                                            <i class="nc-icon nc-preferences-circle-rotate"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4>{{ __('Excelentes Funcionalidades') }}</h4>
                                        <p>{{ __('Assuma o controle do seu número com nossa plataforma adicionando diversas funcionalidades que tornarão seu trabalho mais agil.') }}</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <div class="icon">
                                            <i class="nc-icon nc-notification-70"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4>{{ __('Nunca perca uma chamada') }}</h4>
                                        <p>{{ __('Atenda a chamada, adicione um encaminhamento ou deixe que um atendimento automatico faça o trabalho por você.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mr-auto">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="card card-plain">
                                        <div class="content">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Nome da empresa') }}" value="{{ old('name') }}" required autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="username" id="username" class="form-control" placeholder="{{ __('Nome do administrador da conta') }}" value="{{ old('username') }}" required autofocus>
                                            </div>
                                            <div class="form-group">   {{-- is-invalid make border red --}}
                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control" required>
                                            </div>
                                            <div class="form-group">   {{-- is-invalid make border red --}}
                                                <input type="text" name="zipcode" value="{{ old('zipcode') }}" placeholder="CEP" class="form-control" required>
                                            </div>
                                            <div class="form-group">   {{-- is-invalid make border red --}}
                                                <input type="text" name="address" value="{{ old('address') }}" placeholder="Endereço" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Senha" class="form-control" required >
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" placeholder="Confirmação de Senha" class="form-control" required autofocus>
                                            </div>
                                            <div class="form-group d-flex justify-content-center">
                                                <div class="form-check rounded col-md-10 text-left">
                                                    <label class="form-check-label text-white d-flex align-items-center">
                                                        <input class="form-check-input" name="agree" type="checkbox" required >
                                                        <span class="form-check-sign"></span>
                                                        <b>{{ __('Concordo com os termos e condições') }}</b>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="footer text-center">
                                                <button type="submit" class="btn btn-fill btn-neutral btn-wd">{{ __('Próximo') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-warning alert-dismissible fade show" >
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close"> &times;</a>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endpush