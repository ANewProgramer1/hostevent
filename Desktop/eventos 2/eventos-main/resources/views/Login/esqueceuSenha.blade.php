<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Host Event</title>
  <!--CSS BOOTSTRAP-->
  <link rel="stylesheet" href="css/style.css">
  <!--defer faz com que o js seja executado dps q o html for executado-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"
        defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
    <!--Link Css-->
</head>

<body style="height: -webkit-fill-available;">
  <!--NAVBAR-->
  <nav class="navbar-dark bg-dark navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand logo" href="/">HostEvent</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: flex-end;">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="float:right">
        <!--LINKS-->
        <li class="nav-item">
          <a class="nav-link" onclick="chamaPopUp()" style="cursor:pointer">LOGAR</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="chamaPopUp()" style="cursor:pointer">CADASTRAR</a>
        </li>
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
            <h1>CRIE SUA CONTA</h1>
            <span>informe seus dados</span>
            <input type="text" name="name" aria-describedby="emailHelp" placeholder="NOME*">
            <input type="email" name="email" aria-describedby="emailHelp" placeholder="EMAIL*">
            <input type="email" name="email" aria-describedby="emailHelp" placeholder="CONFIRME O EMAIL*">
            <input type="password" name="password" aria-describedby="emailHelp" placeholder="SENHA*">
            <button class="form_btn">CADASTRO</button>
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
            <div class="alert alert-danger">
              {{ session('danger') }}
            </div>
            @endif
            @csrf
            <h1>Entrar</h1>
            <span>Use sua conta</span>
            <input type="email" name="email" aria-describedby="emailHelp" placeholder="Email:" required>
            <input type="password" name="password" placeholder="Senha:" required>
            <div class="mb-3 row" style="align-items: center !important;">
              <div class="col-md-6">
                <a href="/esqueceuSenha" >ESQUECI SENHA</a>
              </div>
              <div class="col-md-6">
                <button class="form_btn" type="submit" style="float: right;">ENTRAR</button>
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
            <p>Ainda não tem uma conta? Cadastre-se agora e receba acesso a funcionalidades exclusivas a usuários do nosso site!</p>
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
        <div class="form-container ">
          @if (session('msg'))
          <p class="alert alert-danger">{{session('msg')}}</p>
          @endif
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <div class="col-md-12 centered my-auto" style="width: max-content;margin-right:10%;margin-left:10%">
            <h1 class="mb-4 m-auto titulo">Redefinir Senha</h1>
            <form class="col-md-10 m-auto confirmaEmail" action="{{route('recSenhaToEmail')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for=""><strong>Confirme seu email</strong></label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email:" required>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary mb-3 align-center" onclick="troca" id="EnviarEmail">Enviar</button>
            </div>
          </form>
          </div>
        </div>
  <!--SCRIPTS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
    integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
    crossorigin="anonymous"></script>
    <script src="js/popUp.js"></script>
</body>
  <!--SCRIPTS-->
  <script src="js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src="js/script.js"></script>
  <script 
  src = "https://code.jquery.com/jquery-3.4.1.min.js" integridade = "sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin = "anonymous" > </script>

</html>