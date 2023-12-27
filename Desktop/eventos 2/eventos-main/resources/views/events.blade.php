<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <title>Host Event</title>
  <!--CSS bugado-->
  <link rel="stylesheet" href="/css/style.css">
  <!--defer faz com que o js seja executado dps q o html for executado-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"
        defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!--CSS -->
</head>
    <body>
        <!--NAVBAR-->
        <nav class="navbar-dark bg-dark navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand logo" href="/">HostEvent</a>
            <form action="/" method="get" class="form-inline my-2 my-lg-0">
              <input name="search" class="form-control mr-sm-2" type="text" aria-label="Search">
            </form>  
            <!--SÓ APARECE NO CELULAR-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--SÓ APARECE NO CELULAR-->
            <!--LINKS-->
            <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: flex-end;">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="float: right;">
                @auth
                            {{--auth serve pra mostrar coisas pra quem tá logado--}}
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard" style="cursor:pointer">MEUS EVENTOS</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/create">CRIAR EVENTOS</a>
                            </li>
                        @endauth
                        @guest
                        {{--guest serve pra mostrar coisas pra pessoas não logadas--}}
                        <li class="nav-item">
                                <a class="nav-link" onclick="chamaPopUp()" style="cursor:pointer">LOGAR</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="chamaPopUp()" style="cursor:pointer">CADASTRAR</a>
                            </li>
                        @endguest
                        <li class="nav-item">
                            <button class="nav-link semEstilo" id="get-location">POR PERTO</button>
                        </li>
                        @auth
                        <li class="nav-item">
                                <form action="/logout" method="post">
                                @csrf
                                    <a class="nav-link logout" href="/" style="cursor:pointer" onclick="event.preventDefault(); this.closest('form').submit();">SAIR</a>
                                    {{--closest('form') fecha o formulario mais perto--}}
                                </form>
                            </li>
                        @endauth
            </ul>       
         </div>
        </nav>
        <div class="modal pagina" id="modalExemplo" tabindex="-1" role="dialog" style="margin: 0!important;" aria-labelledby="exampleModalLabel" aria-hidden="true" popUp-cadastrar-tag> 
        <div class="wrapper">
            <div class="container">
                <button type="button" class="btn-close btn-close-white" aria-label="Close" data-dismiss="modal" style="width: inherit;" onclick="removerPopUp()"></button>
                <div class="sign-up-container">
                    <form class="form" action="{{route('register')}}" enctype="multipart/form-data" method="POST">
                    @if ($errors->any())
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                chamaPopUp()
                                container.classList.add("right-panel-active");
                            });
                        </script>
                        <div>
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        @if (str_contains($error, 'cadastro'))
                                            <li>{{ $error }}</li>
                                        @endif
                                    @break;
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if (session('dangerCadastro'))
                        <div class="alert alert-danger">
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    chamaPopUp()
                                    container.classList.add("right-panel-active");
                                });
                            </script>
                            {{ session('dangerCadastro') }}
                        </div>
                        @endif
                        @csrf
                        <h1>CRIE SUA CONTA</h1>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" aria-describedby="emailHelp" placeholder="Digite seu nome:*">
                            </div>
                            <div class="col-md-6">
                                <input type="file" id="imagem" aria-describedby="emailHelp" name="foto">
                           </div>      
                        </div>      
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" name="email" aria-describedby="emailHelp" placeholder="E-mail:*">
                            </div>
                            <div class="col-md-6">
                                <input type="password" aria-describedby="emailHelp" name="password" placeholder="Senha:*" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="tel" name="telefone" aria-describedby="emailHelp" placeholder="(xx) xxxxx-xxxx*">
                            </div>
                            <div class="col-md-6">
                                <input type="date" id="date" aria-describedby="emailHelp" name="dataNascimento">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text"  id="cep" placeholder="Digite seu CEP *"  name="cep" maxlength="9" minlength="8" data-cep value='{{!empty($user)?"$user->cep":""}}'>
                            </div>
                            <div class="col-md-6">
                                <button class="overlay_btn">CADASTRO</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="sign-in-container">
                    <form class="form" action="{{route('login.login')}}" method="post">
                        @if ($errors->any() && !in_array('Os campos marcados com * são obrigatorios para cadastro!', $errors->all()))
                        <div>
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        @if (!str_contains($error, 'cadastro'))
                                            <li>{{ $error }}</li>
                                        @endif
                                    @break;
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if (session('dangerLogin'))
                            <div class="alert alert-danger" style="display: flex;justify-content: space-evenly;">
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    chamaPopUp()
                                });
                            </script>
                        {{ session('dangerLogin') }}
                        </div>
                        @endif
                        @csrf
                        <h1>Entrar</h1>
                        <span>Use sua conta</span>
                        <input type="email" name="email" style="width: 85% !important;" aria-describedby="emailHelp" placeholder="Email:" required>
                        <input type="password" name="password" placeholder="Senha:" style="width: 85% !important;" required>
                        <div class="mb-3 row" style="align-items: center !important;">
                            <div class="col-md-6">
                                <a href="/esqueceuSenha" >ESQUECI SENHA</a>
                            </div>
                            <div class="col-md-6">
                                <button class="overlay_btn" type="submit" style="float: right;">ENTRAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay-left">
                        <h1>JÁ TEM UMA CONTA?</h1>
                        <p>Faça seu login para ter acesso a mais funcionalidades em nosso site!</p>
                        <button id="signIn" class="overlay_btn">ENTRAR</button>
                    </div>
                    <div class="overlay-right">
                        <h1>OLÁ AMIGO</h1>
                        <p>Ainda não tem uma conta? Cadastre-se agora e recessa acesso a funcionalidades exclusivas a usuarios do nosso site!</p>
                        <button id="signUp" class="overlay_btn">CADASTRE-SE</button>
                    </div>
                </div>
            </div>
            </div>
            <script>
                const signUpBtn = document.getElementById("signUp");
                const signInBtn = document.getElementById("signIn");
                const container = document.querySelector(".container");
                signUpBtn.addEventListener("click",() =>{
                    container.classList.add("right-panel-active");
                })
                signInBtn.addEventListener("click",() =>{
                    container.classList.remove("right-panel-active")
                })
         </script>
        </div>
    </div>
</div>
</div>
</div>
        @if (session('msg'))
            <div class="alert alert-success" style="display: flex;justify-content: space-evenly;">
                {{ session('msg') }}
        </div>
         @endif
         @if (session('alert'))
            <div class="alert alert-warning" style="display: flex;justify-content: space-evenly;">
                {{ session('alert') }}
        </div>
         @endif
        @if ($busca)
            <h6>Procurando por <i>{{$busca}}</i></h6>
        @endif
        @if(empty($busca)  && count($events)>0)
            <h6>Proximos eventos</h6>
        @endif
        @if (count($events) == 0 && $busca)
            <h6>Evento não encontrado</h6>
        @elseif (count($events) == 0)
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-md-12 centered my-auto" style="width: max-content;margin-right:10%;margin-left:10%">
        <a type="submit" href="/create" class="btn btn-primary btn-lg">Nenhum evento disponivel.</br>Click aqui para criar um!</a>
        </div>
        @else
        <div style="margin-right:10%;margin-left: 10%;display: flex;flex-wrap: wrap;justify-content: flex-start;">
        @foreach ($events as $event)
            <a style="height: 190px;width: 32%;" href="/event/{{$event->id}}">
                <div class="container marketing" style="height: 190px;width: 300px;">   
                        <div class="row featurette">
                        <div style="color: #000;">
                            <div class="img-box">
                                <img class="img-event-post" src="/img/events/{{$event->imagem}}" alt="{{$event->title}}"></img>
                            </div>
                            <div class="p-2 d-flex flex-column  align-items-center border border-secondary rounded" style="position: relative !important;background: white;@php if(isset($event->imagem)) echo 'margin-top: -10px;' @endphp">
                                <p class="estiloFont"><b>{{$event->cidade}} ° {{date('d/m/y', strtotime($event->date))}}  {{date('', strtotime($event->time))}}</b></p>
                                <p class="estiloFont" class="truncate-1l" style="display: flex;justify-content: space-around;" ><b>{{$event->nomeEvento}}</b></p>
                            </div>
                        </div>
                    </div>
                </div>    
            </a>
        @endforeach
        @if ($busca)
            <a style="position: static;height: 60px;" href="/">Ver todos os eventos</a>
        @endif
        </div>
        @endif
  <!--SCRIPTS-->
  
  <script src="js/jquery.js"></script>
  <script src="js/script.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src = "https://code.jquery.com/jquery-3.4.1.min.js" integridade = "sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin = "anonymous" > </script>
  <script src="js/consultaCEP.js"></script>
  <script src="js/popUp.js"></script>
  <script src="js/geolocation.js"></script>
</body>
</html>