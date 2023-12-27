<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
//Listagem e informação de evento
    //PUBLICO
        Route::get('/', [EventController::class, 'event']);
        Route::get('/event/{id}',[EventController::class, 'show']);
    //PUBLICO
//Listagem e informação de evento

Route::middleware('guest')->group(function(){
    //Login
        //Login
            Route::get('/login', [EventController::class, 'login'])->name('login');
            Route::post('/Forms-login', [EventController::class, 'loginForms'])->name('login.login');
        //Esqueceu senha
            Route::get('/esqueceuSenha', [EventController::class, 'indexSenha']);
            Route::post('/esqueceuSenha-Forms-email', [EventController::class, 'esqueceuSenhaFormsEmail'])->name('recSenhaToEmail');
            Route::get('/esqueceuSenha-Forms/{id}', [EventController::class, 'verificaIdsenhaForms']);
            Route::put('/esqueceuSenha-Forms-senha', [EventController::class, 'esqueceuSenhaForms'])->name('recSenhaEntidade');
    //Login
    //cadastro de usuario
        Route::POST('/Forms-register', [EventController::class, 'registerForms'])->name('register');
    //cadastro de usuario
});

Route::middleware('auth')->group(function(){
    Route::get('/home', [EventController::class, 'event']);
    //Logout
        Route::post('/logout', [EventController::class, 'logout']);
    //Logout
    //Editar usuario
        Route::get('/editarUsuario/{id}', [EventController::class, 'editarUsuario']);
        Route::put('/update', [EventController::class, 'editarUsuarioForms']);
    //Editar  usuario
    //Listagem e informação de evento
        //PRIVADO
            Route::post('/events',[EventController::class, 'store']);
            Route::get('/dashboard',[EventController::class, 'dashboard']);
        //PRIVADO
    //Listagem e informação de evento

    //Criar Evento
        Route::get('/create',[EventController::class, 'create']);
    //Criar Evento

    //Deletar
        Route::delete('/event/{id}',[EventController::class,'deletar']);
        Route::get('/user/{id}',[EventController::class,'deletarUser']);
    //Deletar

    //Finalizar
        Route::get('/event/end/{id}',[EventController::class,'finalizarEvento']);
    //Finalizar

    //Editar
        Route::GET('/event/edit/{id}',[EventController::class, 'edit']);
        Route::put('/event/update/{id}',[EventController::class, 'update']);
    //Editar

    //Participar
        Route::post('/event/join/{id}',[EventController::class, 'join']);
        Route::delete('/event/removeJoin/{id}',[EventController::class,'removeJoin']);
    //Participar
});
