<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <title>Host Event</title>
  <!--CSS-->
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
            <!--SÓ APARECE NO CELULAR-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--SÓ APARECE NO CELULAR-->
            <!--LINKS-->
            <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: flex-end;">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="float: right;">
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
    <div class="form-container ">
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
      </br>
      </br>
      </br>
      </br>
      </br>
      </br>
      </br>
      <div class="col-md-12 centered my-auto" style="width: max-content;margin-right:10%;margin-left:10%">
        <h1 class="mb-4 m-auto">Nova Senha</h1>
        <form class="col-md-10 m-auto" action="{{route('recSenhaEntidade')}}" method="POST">
            @csrf   
            @method('PUT') 
            <input type="hidden" name="entidade" value="{{$entidade->id}}">
            <div class="mb-3">
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Nova Senha:">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Confirmar Senha:">
            </div>
            <div class="d-flex flex-row-reverse bd-highlight">
                <div class="p-2 bd-highlight">
                    <button type="submit" class="btn btn-primary mb-3">Enviar</button>
                </div>
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
</body>

</html>