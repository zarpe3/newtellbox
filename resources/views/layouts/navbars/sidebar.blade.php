<div class="sidebar" data-color="webdec">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
    -->
    <div class="sidebar-wrapper">
        <div class="logo" style="background: white; background-repeat: no-repeat;  background-position: center; background-image: url('{{ asset('img/icon-webdec-pbx-discador.png') }}');">
            <a href="http://www.webdec.com" class="simple">
                <div  style="height: 39px;"></div>
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'reception') active @endif">
                <a class="nav-link" href="{{route('reception.index', $customer)}}">
                    <i class="fa fa-desktop"></i>
                    <p>{{ __("Mosaico de Ramais") }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="true">
                    <i>
                        <img src="{{ asset('light-bootstrap/img/report.png') }}" style="color: white; width:25px">
                    </i>
                    <p>
                        {{ __('Relatórios') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if($activeButton =='reports') show @endif" id="reports">
                    <ul class="nav">
                        <li class="nav-item @if($activePage == 'cdr') active @endif">
                            <a class="nav-link" href="{{route('cdr.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("CDR") }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#laravelExamples" aria-expanded="true">
                    <i>
                        <img src="{{ asset('light-bootstrap/img/laravel.svg') }}" style="width:25px">
                    </i>
                    <p>
                        {{ __('Administração') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if($activeButton =='laravel') show @endif" id="laravelExamples">
                    <ul class="nav">
                        <li class="nav-item @if($activePage == 'users') active @endif">
                            <a class="nav-link" href="{{route('users.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Usuários") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'trunks') active @endif">
                            <a class="nav-link" href="{{route('trunks.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Troncos") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'routes') active @endif">
                            <a class="nav-link" href="{{route('routes.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Rota de Saída") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'inbound') active @endif">
                            <a class="nav-link" href="{{route('inbound.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Rota de Entrada") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'extens') active @endif">
                            <a class="nav-link" href="{{route('extens.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Ramais") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'queue') active @endif">
                            <a class="nav-link" href="{{route('queue.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Filas") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'audios') active @endif">
                            <a class="nav-link" href="{{route('audios.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Audios") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'ivr') active @endif">
                            <a class="nav-link" href="{{route('ivr.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("URA") }}
                            </a>
                        </li> 
                        <li class="nav-item @if($activePage == 'voicemail') active @endif">
                            <a class="nav-link" href="{{route('voicemail.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Voicemail") }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#mailings" aria-expanded="true">
                    <i>
                        <i class="fa fa-upload"></i>
                    </i>
                    <p>
                        {{ __('Discador') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if($activeButton =='mailings') show @endif" id="mailings">
                    <ul class="nav">
                        <li class="nav-item @if($activePage == 'mailing-import') active @endif">
                            <a class="nav-link" href="{{route('mailing.create', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Importação") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'mailing-followup') active @endif">
                            <a class="nav-link" href="{{route('mailing.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Acompanhamento") }}
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'mailing-report') active @endif">
                            <a class="nav-link" href="{{route('mailing.index', $customer)}}" style="margin-left: 20%;">
                                <!--<i class="nc-icon nc-circle-09"></i>-->
                                - {{ __("Relatorios") }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item @if($activePage == 'notifications') active @endif">
            <!--<li class="nav-item @if($activePage == 'notifications') active @endif">
                <a class="nav-link" href="{{route('page.index', 'notifications')}}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Notificações") }}</p>
                </a>
            </li>-->
        </ul>
    </div>
</div>
