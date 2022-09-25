@extends('layouts/app', ['activeButton' => '', 'activePage' => 'register', 'title' => 'Criar Conta'])

@section('content')
<div class="full-page register-page product-page"  id="app" data-color="webdec">
    <div class="content">
        <div class="container">
            <div class="card card-register card-plain text-center">
                <div class="card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('customer.add.plan') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="card" style="background: white;">
                                        <div class="card-body product" style="color: #3f3f3f">
                                            <div class="icon">
                                                <i style="font-weight: bold; font-size: 40px;" class="nc-icon nc-tv-2"></i>
                                            </div>
                                            <h4 style="font-weight: bold">{{ __('Meu Número') }}</h4>
                                            <div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Gravação de chamadas
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Encaminhamento
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Fila de Atendimento
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Muito mais
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary">
                                            Por Apenas
                                            <span>
                                                <b> R$ 29,90 </b>
                                            </span>
                                        </div>
                                        <button type="submit" name="plan" value="mn" style="cursor: pointer;" class="alert alert-info">
                                                Quero contratar!
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card" style="background: white;">
                                        <div class="card-body product" style="color: #3f3f3f">
                                            <div class="icon">
                                                <i style="font-weight: bold; font-size: 40px;" class="nc-icon nc-tv-2"></i>
                                            </div>
                                            <h4 style="font-weight: bold">{{ __('Meu Discador') }}</h4>
                                            <div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Speed Dial
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Filtro de Voz Eletronica
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Resultados Tempo Real
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Muito mais
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary">
                                            Por Apenas
                                            <span>
                                                <b> R$ 89,90 </b>
                                            </span>
                                        </div>
                                        <button type="submit" name="plan" value="md" style="cursor: pointer;" class="alert alert-info">
                                                Quero contratar!
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card" style="background: white;">
                                        <div class="card-body product" style="color: #3f3f3f">
                                            <div class="icon">
                                                <i style="font-weight: bold; font-size: 40px;" class="nc-icon nc-tv-2"></i>
                                            </div>
                                            <h4 style="font-weight: bold">{{ __('Minha URA') }}</h4>
                                            <div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Multiplas campanhas
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Filtro de Voz Eletronica
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Resultados Tempo Real
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Muito mais
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary">
                                            Por Apenas
                                            <span>
                                                <b> R$ 79,90 </b>
                                            </span>
                                        </div>
                                        <button type="submit" name="plan" value="mu" style="cursor: pointer;" class="alert alert-info">
                                                Quero contratar!
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card" style="background: white;">
                                        <div class="card-body product" style="color: #3f3f3f">
                                            <div class="icon">
                                                <i style="font-weight: bold; font-size: 40px;" class="nc-icon nc-tv-2"></i>
                                            </div>
                                            <h4 style="font-weight: bold">{{ __('Meu Tellbox') }}</h4>
                                            <div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Ramais Ilimitados
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Total controle de Rotas
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Ramais Ilimitados
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Discador
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Ura
                                                </div>
                                                <div class="d-flex item-plano align-items-center">
                                                    <i class="nc-icon nc-check-2"></i>
                                                    Muito mais
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-primary">
                                            Por Apenas
                                            <span>
                                                <b> R$ 559,90 </b>
                                            </span>
                                        </div>
                                        <button type="submit" name="plan" value="mt" style="cursor: pointer;" class="alert alert-info">
                                                Quero contratar!
                                        </button>
                                    </div>
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
<script>
    $(document).ready(function () {
        demo.checkFullPageBackgroundImage();

        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
@endpush