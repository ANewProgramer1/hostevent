<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Host Event</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar-dark bg-dark navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand logo" href="/">HostEvent</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="float: right;">
                @auth
                <li class="nav-item">
                    <a class="nav-link active" href="/dashboard" style="cursor:pointer">MEUS EVENTOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/create">CRIAR EVENTOS</a>
                </li>
                <li class="nav-item">
                    <form action="/logout" method="post">
                        @csrf
                        <a class="nav-link logout" href="/" style="cursor:pointer" onclick="event.preventDefault(); this.closest('form').submit();">SAIR</a>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="col-md-10 offset-md-1 dashbord-events-container" style="height: 90vh;">
        @if (session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
        @endif

        <div style="display: flex; flex-direction: row; height:inherit;margin-top: 0.5rem;">
            <div style="display: grid;align-items: center;justify-items: center;width: min-content;background: white;padding: 1.3rem;border-radius: 3rem; height: 545px;">
                @if(!empty($user->foto))
                <label tabIndex="0" for="picture__input" type="file" class="picture" style="padding:0px!important;margin-top: 1rem;">
                    <img src="/img/usuarios/{{$user->foto}}" class="fotoPerfil" alt="Não foi possível carregar sua foto" style="height: 10rem;width: 10rem;">
                </label>
                @else
                <label tabIndex="0" for="picture__input" type="file" class="picture" style="background: rgb(219, 221, 223);border-radius:100%;">
                    <img src="/img/user.png" class="fotoPerfil" style="height: 10rem;width: 10rem;"></img>
                </label>
                @endif
                <strong style="color: #0fa0e9;">{{$user->name}}</strong>
                <strong style="color: #0fa0e9;">Seus eventos totalizam: {{count($events)}}</strong>
                <strong style="color: #0fa0e9;">Suas participações totalizam: {{count($eventasparticipant)}}</strong>
                <a class="btn btn-primary mb-3" style="height: fit-content;" href="/editarUsuario/{{$user->id}}">Editar</a>
            </div>
            <div style="display: flex;flex-direction: column;width: 75%;padding-left: 1rem;margin-top: 10%;align-items: center;">
            <div style="display: flex;width: 92%; margin: 0 auto; flex: 1;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            @if($maximoItem>0 )
            <div style="width: 50% !important; background-color: #838383; border-radius: 10px;
    padding-top: 10px;">
                        <table class="table">
                            <thead style="border-style:none !important">
                                <tr>
                                    <th scope="col" style="border-style:none !important">CADEIRA</th>
                                    <th scope="col" style="border-style:none !important">BEBIDA</th>
                                    <th scope="col" style="border-style:none !important">BRINDE</th>
                                    <th scope="col" style="border-style:none !important">PALCO</th>
                                </tr>
                            </thead>
                            <tbody style="border-style:none !important">
                                <tr style="background: none !important">
                                    <td style="border-style:none !important">
                                        <div style="display: grid;justify-items: center;justify-content: space-around;">
                                            <div class="slider-wrapper">
                                                <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                                                    @php
                                                    $porcentagem=($items['cadeiras']/$maximoItem)*100;
                                                    echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoItem.'" value="'.$items['cadeiras'].'" step="1">';
                                                    @endphp
                                                </div>
                                            </div>
                                            <div>
                                                <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$items['cadeiras'])}}</h7>
                                    </td>
                        </div>
                    </div>
                    <td style="border-style:none !important">
                        <div style="display: grid;justify-items: center;justify-content: space-around;">
                            <div class="slider-wrapper">
                                <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                                    @php
                                    $porcentagem=($items['bebidas']/$maximoItem)*100;
                                    echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoItem.'" value="'.$items['bebidas'].'" step="1">'
                                    @endphp
                                </div>
                            </div>
                            <div>
                                <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$items['bebidas'])}}</h7>
                    </td>
                </div>
            </div>
            <td style="border-style:none !important">
                <div style="display: grid;justify-items: center;justify-content: space-around;">
                    <div class="slider-wrapper">
                        <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                            @php
                            $porcentagem=($items['brindes']/$maximoItem)*100;
                            echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoItem.'" value="'.$items['brindes'].'" step="1">'
                            @endphp
                        </div>
                    </div>
                    <div>
                        <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$items['brindes'])}}</h7>
            </td>
        </div>
        </div>
        <td style="border-style:none !important">
            <div style="display: grid;justify-items: center;justify-content: space-around;">
                <div class="slider-wrapper">
                    <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                        @php
                        $porcentagem=($items['palco']/$maximoItem)*100;
                        echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoItem.'" value="'.$items['palco'].'" step="1">'
                        @endphp
                    </div>
                </div>
                <div>
                    <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$items['palco'])}}</h7>
        </td>
        </div>
        </div>
        </tr>
        </tbody>
        </table>
    </div>
    @endif
    @if ($maximoEvento>0)
    <div style="margin-left: 0.09rem;width: 50% !important; background-color: #838383; border-radius: 10px;
    padding-top: 10px;">
        <table class="table" style="border-style:none !important">
            <thead style="border-style:none !important">
                <tr>
                    <th scope="col" style="border-style:none !important">CONCLUÍDO</th>
                    <th scope="col" style="border-style:none !important">EM ANDAMANETO</th>
                </tr>
            </thead>
            <tbody style="border-style:none !important">
                <tr style="background: none !important">
                    <td style="border-style:none !important">
                        <div style="display: grid;justify-items: center;justify-content: space-around;">
                            <div class="slider-wrapper">
                                <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                                    @php
                                    $porcentagem=($situacaoEvento['concluido']/$maximoEvento)*100;
                                    echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoEvento.'" value="'.$situacaoEvento['concluido'].'" step="1">'
                                    @endphp
                                </div>
                            </div>
                            <div>
                                <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$situacaoEvento['concluido'])}}</h7>
                    </td>
                    <td style="border-style:none !important">
                        <div style="display: grid;justify-items: center;justify-content: space-around;">
                            <div class="slider-wrapper">
                                <div class="progress mt-1 " style="transform: rotate(180deg);height: inherit;">
                                    @php
                                    $porcentagem=($situacaoEvento['emAndamento']/$maximoEvento)*100;
                                    echo '<input style="background-color:darkgray;height:'.$porcentagem.'%" type="range" min="0" max="'.$maximoEvento.'" value="'.$situacaoEvento['emAndamento'].'" step="1">'
                                    @endphp
                                </div>
                            </div>
                            <div>
                                <h7 style="display: grid;justify-items: center;">{{str_replace(".",",",$situacaoEvento['emAndamento'])}}</h7>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
    </div>
    <div style="display: flex; justify-content: space-around; margin: 30px;">

<div style="flex-basis: 48%; margin-right: 100px;">
    @if(count($events)>0)
    <h1 class="m-auto" style="padding-bottom: 20px; font-size: 3.8vh; text-align: center;">Meus eventos</h1>
    <table class="table" style="border-color: #000;">
        <thead>
            <tr>
                <th scope="col">Cod</th>
                <th scope="col">Nome</th>
                <th scope="col">Participantes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <th scope="row">{{$event->id}}</th>
                <th scope="row"><a href="/event/{{$event->id}}">{{$event->nomeEvento}}</a></th>
                <th scope="row">{{count($event->users)}}</th>
                @if(!$event->finalizada)
                <th scope="row" style="vertical-align: middle; display: flex; flex-direction: column; align-items: center;">

    <!-- Link "Editar" -->
    <a href="/event/edit/{{$event->id}}" style="margin-bottom: 10px;">Editar</a>

    <!-- Botão "Deletar" -->
    <a class="btn btn-info edit-btn" href="/event/{{$event->id}}" style="margin-bottom: 10px;">
        <form action="/event/{{$event->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger delete-btn" style="font-size: 12px; padding: 4px 8px;">Deletar</button>
        </form>
    </a>

    <!-- Link "Finalizar" -->
    <a href="/event/end/{{$event->id}}">Finalizar</a>

</th>

            @endif
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não criou nenhum evento. <a href="/create">Criar evento</a></p>
    @endif
</div>

<div style="flex-basis: 48%;">
    @if (count($eventasparticipant)>0)
    <h1 class="m-auto" style="padding-bottom: 20px; font-size: 3.8vh; text-align: center;">Suas participações</h1>
    <table class="table" style="border-color: #000;">
        <thead>
            <tr>
                <th scope="col">Cod</th>
                <th scope="col">Nome</th>
                <th scope="col">Participantes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventasparticipant as $participant)
            <tr>
                <th scope="row">{{$participant->id}}</th>
                <th scope="row"><a href="/event/{{$participant->id}}">{{$participant->nomeEvento}}</a></th>
                <th scope="row">{{count($participant->users)}}</th>
                <th scope="row">
                    <form action="/event/removeJoin/{{$participant->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-btn" style="font-size: 12px; padding: 4px 8px;">Sair</button>
                    </form>
                </th>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não participa de eventos. <a href="/">Veja alguns eventos</a></p>
    @endif
</div>

</div>

    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="js/consultaCEP.js"></script>
    <script src="js/popUp.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
