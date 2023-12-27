<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Host Event</title>
  <!--CSS-->
  <link rel="stylesheet" href="css/style.css">
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
            <a class="navbar-brand logo" href="/">HostEventoooo</a>
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
                                <a class="nav-link" href="/dashboard" style="cursor:pointer">Meus eventos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="chamaPopUpEvent()" style="cursor:pointer">Criar eventos</a>
                            </li>
                            <li class="nav-item">
                                <form action="/logout" method="post">
                                @csrf
                                    <a class="nav-link" href="/" style="cursor:pointer" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                                    {{--closest('form') fecha o formulario mais perto--}}
                                </form>
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
            </ul>       
         </div>
        </nav>
        <div class="modal pagina aparecer" id="modalExemplo" tabindex="-1" role="dialog" style="margin: 0!important;" aria-labelledby="exampleModalLabel" aria-hidden="true" popUp-cadastrar-tag> 
        <div class="wrapper">
            <div class="container">
                <a type="button" class="btn-close btn-close-white" aria-label="Close" data-dismiss="modal" style="width: inherit;" href="/"></a>
                <div class="sign-up-container">
                    <form class="form" action="{{route('register')}}" enctype="multipart/form-data" method="POST">
                    @if ($errors->any())
                        <div>
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @break;
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if (session('danger'))
                        <div class="alert alert-danger" style="display: flex;justify-content: space-evenly;">
                            {{ session('danger') }}
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
                            <div class="col-md-5">
                                <input type="text"  id="cep" placeholder="Digite seu CEP *"  name="cep" maxlength="9" minlength="8" data-cep value='{{!empty($user)?"$user->cep":""}}'>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="rua" placeholder="Rua *" name="rua" readonly value='{{!empty($user)?"$user->rua":""}}'>
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0" min="1" id="numero" placeholder="Nº *" name="numeroCasa" value='{{!empty($user)?"$user->numeroCasa":""}}' >
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="bairro" placeholder="Bairro *" name="bairro" readonly value='{{!empty($user)?"$user->bairro":""}}'>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="cidade" placeholder="Cidade *" name="cidade" readonly value='{{!empty($user)?"$user->cidade":""}}'>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="uf" name="uf" name="uf" placeholder="Estado *" readonly value='{{!empty($user)?"$user->uf":""}}'>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="complemento" name="complemento" placeholder="Complemento" value='{{!empty($user)?"$user->complemento":""}}'>
                            </div>
                            <div class="col-md-6">
                                <button class="overlay_btn">CADASTRO</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="sign-in-container">
                    <form class="form" action="{{route('login.login')}}" method="post">
                        @if ($errors->any())
                        <div>
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @break;
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if (session('danger'))
                        <div class="alert alert-danger" style="display: flex;justify-content: space-evenly;">
                            {{ session('danger') }}
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
        <div class="modal pagina" id="modalExemplo" tabindex="-1" role="dialog" style="margin: 0!important;" aria-labelledby="exampleModalLabel" aria-hidden="false" popUp-cadastrar-event> 
        <div class="wrapper">
            <div class="container">
                <button type="button" class="btn-close btn-close-white" aria-label="Close" data-dismiss="modal" style="width: inherit;" onclick="removerPopUpEvent()"></button>
                <div class="sign-in-container">
                    <form class="form" action="/events" method="POST" enctype="multipart/form-data">
                        @if ($errors->any())
                        <div>
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @break;
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if (session('danger'))
                        <div class="alert alert-danger">
                            {{ session('danger') }}
                        </div>
                        @endif
                        @csrf
                        <h1>CRIE SEU EVENTO</h1>
                        <span>INFORME OS DADOS DO EVENTO</span>
                    </hr><hr>
                    <div class="mb-3 row">
                        <label for="date"><strong>Dados do Evento</strong></label>
                        <div class="col-md-12 mb-4">
                            <label for="imagem">Foto do evento*</label>
                            <input type="file" class="form-control-file" id="imagem" name="imagem" >
                        </div>
                        <div class="col-md-8 mb-4">
                            <input type="text" class="form-control" id="title" name="nomeEvento" placeholder="Digite o nome do evento *">
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="number" step="0" min="1" class="form-control" id="title" name="quantidadeP" placeholder="Quantidade de participantes">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="date">Data do evento *</label>
                            <input  class="form-control" type="date" name="date" id="date">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="date">Horario do evento *</label>
                            <input class="form-control" type="time" id="appt" name="time" smin="00:01" max="23:59" required>          
                        </div>
                    </div>
            </div>
            <div class="overlay-container">
                <div class="overlay-right">
                    <div class="mb-3 row">
                        <label for="date"><strong>Endereço do Evento</strong></label>
                        <div class="col-md-4 mb-4">
                            <input type="text" class="form-control" id="cep" placeholder="Digite seu CEP *"  name="cep" maxlength="9" minlength="8" data-cep>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" class="form-control" id="cidade" placeholder="Cidade *" name="cidade" readonly >
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" class="form-control" id="uf" name="uf" name="uf" placeholder="Estado *" readonly >
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" id="rua" placeholder="Rua *" name="rua" readonly >
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" id="bairro" placeholder="Bairro *" name="bairro" readonly >
                        </div>
                        <div class="col-md-12 mb-4">
                            <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="date"><strong>Dados adicionais do Evento</strong></label>
                        <div class="from-grup col-md-6">
                            <label for="items"><strong>Items</strong></label>
                            <div class="from-grup">
                                <input style="width: auto!important;" type="checkbox" name="items[]" value="palco">palco
                            </div>
                            <div class="from-grup">
                                <input style="width: auto!important;" type="checkbox" name="items[]" value="bebidas">bebidas
                            </div>
                            <div class="from-grup">
                                <input style="width: auto!important;" type="checkbox" name="items[]" value="brindes">brindes
                            </div>
                            <div class="from-grup">
                                <input style="width: auto!important;" type="checkbox" name="items[]" value="cadeiras">cadeiras
                            </div>
                        </div>
                        <div class="form-grup col-md-6" style="display:grid">
                            <label for="descricao">Descrição *</label>
                            <textarea name="descricao" id="descricao" class="from-controller"></textarea>   
                        </div>
                    </div>
                    <button id="signUp" type="submit"  class="overlay_btn">CRIAR EVENTO</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
        @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
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
                                <p class="estiloFont"><b>{{$event->cidade}} ° {{date('d/m/y', strtotime($event->date))}} | {{date('h:m', strtotime($event->time))}}</b></p>
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
</body>
</html>