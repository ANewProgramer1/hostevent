<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../../../public/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
<body>
    <div class="container" style="padding-bottom:.8rem">
        <div class="col-md-12 centered mx-auto ">
            <div style="display: flex;flex-direction: column;justify-content: space-between;align-items: center;">
                <span class="navbar-brand logo">Event host</span>
                <h1 class="titulo">Olá {{$destinatario->name}}, estamos retornando o seu contato para redefinir sua senha.</h1>
                <br>
                <br>
                <h4><i>Caso não tenha solicitado, apenas ignore esta mensagem, caso contrario, clique no botão a baixo para redefinir sua senha</i></h4>
                <a href="http://127.0.0.1:8000/esqueceuSenha-Forms/{{$idUser}}" class="btn btn-primary mt-4">REDEFINIR SENHA</a>
            </div>
        </div>
    </div>
</body>
