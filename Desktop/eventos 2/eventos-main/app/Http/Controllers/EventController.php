<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    //Login
    public function login()
    {
        $user = auth()->user();
        $busca = request('search');
        if ($busca) {
            $Events = Event::where([
                ['nomeEvento', 'like', '%' . $busca . '%']
            ])->whereNotIn('finalizada', [1])->get();
        } else {
            $Events = Event::whereNotIn('finalizada', [1])->get();
        }
        return view('events', ['user' => $user, 'events' => $Events, 'busca' => $busca]);
    }
    public function loginForms(Request $request)
    {
        $entidade = User::where('email', $request->email)->first();
        if ($entidade && Hash::check($request->password, $entidade->password)) {
            Auth::loginUsingId($entidade->id);
            return redirect('/');
        } else {
            return redirect()->back()->with('dangerLogin', 'Email ou senha invalida!');
        }
    }
    //Esqueceu senha
    public function indexSenha()
    {
        return view('Login.esqueceusenha');
    }
    public function esqueceuSenhaFormsEmail(Request $request)
    {
        $email = $request->email;
        $usuario = User::where('email', 'like', '%' . $email . '%')->first();
        if (empty($usuario)) {
            return redirect('/esqueceuSenha')->with('msg', 'Esse usuario não existe!');
        }
        Mail::send(new \App\Mail\SendMail($usuario));
        return redirect('/esqueceuSenha')->with('success', 'Enviamos um email com as instruções para redefinir sua senha');
    }
    public function verificaIdsenhaForms($id)
    {
        $user = user::all();
        foreach ($user as $destinatario) {
            if (Hash::check($destinatario->id, $id)) {
                return view('Login.novaSenha', ['entidade' => $destinatario]);
            }
        }
        return back()->with('danger', 'usuario não encontrado');
    }
    public function esqueceuSenhaForms(Request $request)
    {
        User::findOrFail($request->entidade)->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect('/');
    }
    //Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    //cadastro usuario
    public function registerForms(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'dataNascimento' => 'required',
            'telefone' => 'required',
            'cep' => 'required',
            'password' => 'required'
        ], [
            'required' => 'Os campos marcados com * são obrigatorios para cadastro!',
        ]);
        $usuarios = new User;
        $usuarios->name = $request->name;
        $usuarios->email = $request->email;
        $usuarios->password = Hash::make($request->password);
        $usuarios->dataNascimento = $request->dataNascimento;
        $usuarios->telefone = $request->telefone;
        $usuarios->cep = str_replace("-", "", $request->cep);
        if ($request->hasfile('foto') && $request->file('foto')->isValid()) {
            $requestImagem = $request->foto;
            //Pega a imagem
            $extension = $requestImagem->extension();
            //pega a extensão
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $usuarios->foto = $imagemName;
            //cria o nome da imagem
            $request->foto->move(public_path('img/usuarios'), $imagemName);
            //salva no bd
            $date['foto'] = $imagemName;
        }
        if (empty(user::where('email', $request->email)->first())) {
            $usuarios->save();
            Auth::loginUsingId($usuarios->id);
            return redirect('/');
        }
        return redirect('/')->with('alert', 'ouve um erro no seu cadastro')->with('dangerCadastro', 'email já cadastrado!');
    }
    //cadastro usuario
    //atualizar usuario
    public function editarUsuario($id)
    {
        $user = user::findOrFail($id);
        return view('Login.register', ['user' => $user]);
    }
    public function editarUsuarioForms(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'dataNascimento' => 'required',
            'telefone' => 'required',
        ], [
            'required' => 'Os campos marcados com * são obrigatórios!',
        ]);

        $user = User::findOrFail($request->id);
        $filePath = public_path('img/usuarios/');

        $fotoAtual = $user->foto;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($fotoAtual && File::exists($filePath . $fotoAtual)) {
                File::delete($filePath . $fotoAtual);
            }
            $requestImagem = $request->foto;
            $extension = $requestImagem->extension();
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImagem->move($filePath, $imagemName);
            $imgFoto = $imagemName;
        }

        // Atualiza o usuário
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'dataNascimento' => $request->dataNascimento,
            'telefone' => $request->telefone,
            'foto' => $imgFoto
        ]);

        return redirect('/dashboard');
    }


    //atualizar usuario
    //Excluir usuario
    public function deletarUser($idUser)
    {
        $filePath = public_path('img/usuarios/');
        $fotoAtual = User::findOrFail($idUser)->foto;
        if ($fotoAtual && File::exists($filePath . $fotoAtual)) {
            File::delete($filePath . $fotoAtual);
        }

        User::findOrFail($idUser)->delete();
        return redirect('/');
    }
    //Excluir usuario

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        //Criadno a entidade
        $event = new Event;
        //Marcar como obrigatorio
        $this->validate($request, [
            'nomeEvento' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'nomeEvento' => 'required',
            'descricao' => 'required',
            'imagem' => 'required',
            'time' => 'required',
            'date' => 'required',
        ], [
            'required' => 'Os campos marcados com * são obriatorios!'
        ]);
        //Passando os valores da web/request pro bd
        $event->nomeEvento = $request->nomeEvento;
        $event->integranteQuantidade = $request->quantidadeP;
        $event->integranteQuantidadePreenchidas = 0;
        $event->cep = str_replace("-", "", $request->cep);
        $event->rua = $request->rua;
        $event->bairro = $request->bairro;
        $event->cidade = $request->cidade;
        $event->uf = $request->uf;
        $event->complemento = $request->complemento;
        $event->descricao = $request->descricao;
        $event->items = json_encode($request->items);
        $event->date = $request->date;
        $event->time = $request->time;
        $event->finalizada = 0;
        //Upload de imagem
        if ($request->hasfile('imagem') && $request->file('imagem')->isValid()) {
            $requestImagem = $request->imagem;
            //Pega a imagem
            $extension = $requestImagem->extension();
            //pega a extensão
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extension;
            //cria o nome da imagem
            $request->imagem->move(public_path('img/events'), $imagemName);
            //salva no bd
            $event->imagem = $imagemName;
        }
        $user = auth()->user();
        $event->user_id = $user->id;
        //Salvando os dados
        $event->save();
        //redirecionando a página
        return redirect('/')->with('msg', 'Evento criado');
    }

    public function event()
    {
        $user = auth()->user();
        $busca = request('search');
        $localizacaoAtual = request('s');
        $hoje = date('Y/m/d');
        $now = date('H:i:s', time());
        if ($busca) {
            $Events = Event::where([
                ['nomeEvento', 'like', '%' . $busca . '%']
            ])->whereNotIn('finalizada', [1])->where('date', '>=', $hoje)->get();
        } else {
            if (!empty($localizacaoAtual)) {
                $Events = Event::whereNotIn('finalizada', [1])->where('date', '>=', $hoje)->where('time', '>=', $now)->where('uf', 'like', $localizacaoAtual)->get();
                if (count($Events) < 1) {
                    $Events = Event::whereNotIn('finalizada', [1])->where('date', '>=', $hoje)->get();
                    return redirect('/')->with('msg', 'parece que não há eventos na sua localidade');
                }
            } else {
                $Events = Event::whereNotIn('finalizada', [1])->where('date', '>=', $hoje)->get();
            }
        }
        return view('events', ['user' => $user, 'events' => $Events, 'busca' => $busca]);
    }

    public function show($id)
    {
        $event = Event::findOrfail($id);
        if (!auth()->user()) {
            $user = ['id' => 0];
        } else {
            $user = auth()->user();
        }
        $existeUserJoin = false;
        if ($user and $user['id'] != 0) {
            //já pode entrar com tela de usuario
            $userEvents = $user->eventAsParticipant->toArray();
            foreach ($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $existeUserJoin = true;
                }
            }
        }
        $semanaDia = [
            'Sunday' => 'Dom.',
            'Monday' => 'Seg.',
            'Tuesday' => 'Ter.',
            'Wednesday' => 'Quart.',
            'Thursday' => 'Qui.',
            'Friday' => 'Sext.',
            'Saturday' => 'Sáb.'
        ];
        $eventOwner = User::where([['id', $event->user_id]])->first()->toArray(); //first serve pra para a busca na primeira corespondencia
        //EventOwner = dono do evento
        $items = json_decode($event->items, true) ?? [];

        return view('show', ['semanaD' => $semanaDia, 'usuario' => $user, 'event' => $event, 'eventOwner' => $eventOwner, 'JaParticipa' => $existeUserJoin, 'items' => $items]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $events = $user->events;
        $eventAsParticipant = $user->eventAsParticipant;
        $items = ['palco' => 0, 'cadeiras' => 0, 'bebidas' => 0, 'brindes' => 0];
        $situacaoEvento = ['emAndamento'=>0,'concluido'=>0];
        foreach ($events as $eventoDaVez) {
            $arrayItem = json_decode($eventoDaVez->items, true);
            if ($arrayItem !== null) {
                foreach ($arrayItem as $itemDaVez) {
                    /*switch ($itemDaVez) {
                    case 'palco':
                        $items['palco'] += 1;
                        break;
                    case 'bebidas':
                        $items['bebidas'] += 1;
                        break;
                    case 'brindes':
                        $items['brindes'] += 1;
                        break;
                    case 'cadeiras':
                        $items['cadeiras'] += 1;
                        break;
                    }*/
                    $items[$itemDaVez] += 1;
                }
            }
            if($eventoDaVez->finalizada){
                $situacaoEvento['concluido'] += 1;
            }else{
                $situacaoEvento['emAndamento'] += 1;
            }
        }
        foreach($eventAsParticipant as $eventoDaVez){
            if($eventoDaVez->finalizada){
                $situacaoEvento['concluido'] += 1;
            }else{
                $situacaoEvento['emAndamento'] += 1;
            }
        }
        return view('dashboard', [
            'user' => $user,
            'events' => $events,
            'eventasparticipant' => $eventAsParticipant,
            'items' => $items,
            'maximoItem' => max($items),
            'situacaoEvento' => $situacaoEvento,
            'maximoEvento' => max($situacaoEvento),
        ]);
    }

    public function deletar($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        //Esse if serve pra bloquear acessoas de terceiros sem propriedade administrador
        if ($user->id != $event->user->id) {
            return redirect('/dashboard')->with('msg', 'Esse evento não pertence a você');
        }
        $event->delete();
        return redirect('/dashboard')->with('msg', 'excluido com sucesso');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();
        if ($user->id != $event->user->id) {
            return redirect('/dashboard')->with('msg', 'Esse evento não pertence a você');
        }
        return view('edit', ['event' => $event]);
    }
    public function finalizarEvento($id)
    {
        Event::findOrFail($id)->update([
            'finalizada' => 1,
        ]);
        return back()->with('msg', 'Evento finalizado!');
    }

    public function update(request $request)
    {
        $this->validate($request, [
            'nomeEvento' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'nomeEvento' => 'required',
            'descricao' => 'required',
            'time' => 'required',
            'date' => 'required',
        ], [
            'required' => 'Os campos marcados com * são obriatorios!'
        ]);
        $date = $request->all();

        $caminhoFotoEvento = public_path('img/events/');
        $fotoAtual = Event::findOrFail($request->id)->imagem;

        //Upload de imagem
        if ($request->hasfile('imagem') && $request->file('imagem')->isValid()) {
            if ($fotoAtual && File::exists($caminhoFotoEvento . $fotoAtual)) {
                File::delete($caminhoFotoEvento . $fotoAtual);
            }
            $requestImagem = $request->imagem;
            //Pega a imagem
            $extension = $requestImagem->extension();
            //pega a extensão
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime("now") . "." . $extension);
            //cria o nome da imagem
            $request->imagem->move(public_path('img/events'), $imagemName);
            //salva no bd
            $date['imagem'] = $imagemName;
        }
        Event::findOrFail($request->id)->update($date);
        $date = $request->all();
        return redirect('/dashboard')->with('msg', 'Editado com sucesso');
    }

    public function join($id)
    {
        $user = auth()->user();
        $user->eventAsParticipant()->attach($id);
        $event = Event::findOrFail($id);
        $event->update([
            'integranteQuantidadePreenchidas' => $event->integranteQuantidadePreenchidas + 1,
        ]);
        return redirect('/dashboard')->with('msg', 'Sua presença no evento ' . $event->nomeEvento . ' foi confirmada');
    }

    public function removeJoin($id)
    {
        $user = auth()->user();
        $user->eventAsParticipant()->detach($id);
        $event = Event::findOrFail($id);
        $event->update([
            'integranteQuantidadePreenchidas' => $event->integranteQuantidadePreenchidas - 1,
        ]);
        return redirect('/dashboard')->with('msg', 'Sua presença no evento ' . $event->nomeEvento . ' foi removida');
    }
}
