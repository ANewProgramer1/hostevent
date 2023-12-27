<!doctype html>
<html lang="pt-br" style="height: unset !important;">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Host Event</title>
  <!--CSS Bootstrap-->
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!--CSS -->
</head>

<body>
  <!--NAVBAR-->
  <nav class="navbar-dark bg-dark navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand logo" href="/">HostEvent</a>
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
  <main>
  <div id="event-create-conteiner" class="col-md-6 offset-md-3">
        @if(empty($user))
    <h1 class="col-md-8 m-auto" style="width: max-content;">Cadastro de Usuario</h1>
    @else
    <h1 class="col-md-8 m-auto" style="width: max-content;">ATUALIZAR USUÁRIO</h1>
    @endif
    <div class="col-md-8 m-auto">
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
   </div>  
   @if(empty($user))
     <form class="col-md-8 m-auto" action="{{route('register')}}" enctype="multipart/form-data" method="POST">
   @else
     <form class="col-md-8 m-auto" action="/update?id={{$user->id}}" enctype="multipart/form-data" method="POST">
     @method('PUT')
   @endif
      @csrf
      </hr><hr>
      <div class="mb-3">
        <label for="imagem">Foto do usuario</label>
        <input type="file" class="form-controll-file" id="imagem" name="foto" value='{{!empty($user)?"$user->foto":""}}'>
      </div>      
      <div class="mb-3">
         <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Digite seu nome:*" value='{{!empty($user)?"$user->name":""}}'>
      </div>      
      <div class="mb-3">
         <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="E-mail:*" value='{{!empty($user)?"$user->email":""}}'>
      </div>
      @if(empty($user))
      <div class="mb-3">
         <input type="email" class="form-control" name="Confirme_email" placeholder="Confirme seu E-mail:*" >
      </div>
      <div class="mb-3 row">
        <div class="col-md-6 mb-3">
          <input type="password" class="form-control" name="password" placeholder="Senha:*" >
        </div>
        <div class="col-md-6 mb-3">
          <input type="password" class="form-control" name="Confirme_password" placeholder="Confirme sua senha:*" >
        </div>
      </div>
      @endif
      </hr><hr>
      <div class="mb-3 row">
        <div class="col-md-6">
          <input type="tel" class="mb-3 form-control" name="telefone"  placeholder="(xx) xxxxx-xxxx*" value='{{!empty($user)?"$user->telefone":""}}'>
        </div>
        <div class="col-md-6">
          <input type="date" class="mb-3 form-control" id="date" name="dataNascimento"  value='{{!empty($user)?"$user->dataNascimento":""}}'>
        </div>
      </div>
      </hr><hr>
    <div class="p-2 bd-highlight" style="display: flex;justify-content: space-between;flex-direction: row-reverse;">
      <button class="btn btn-primary mb-3" type="submit">{{!empty($user)?"Atualizar":"Cadastra-se"}}</button>
  </form>
    <a class="btn btn-danger mb-3" href="/user/{{$user->id}}">
       <form action="/user/{{$user->id}}" method="POST">
       @csrf
       @method('DELETE')
      </form>
      DELETAR
      </a>
  </div>
  </div>
  </main>


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
    <script src="/js/consultaCEP.js"></script>
</body>
</html>