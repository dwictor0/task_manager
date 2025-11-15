<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SugestoesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListaDeTarefasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [ListaDeTarefasController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/pusher/auth', function (Request $request) {
        return Broadcast::auth($request);
    });
    Route::resource('tarefas', ListaDeTarefasController::class);
    Route::get('/api', [ApiController::class, 'renderizaApi'])->name('api.controle');
    Route::post('/restore/{id}', [ListaDeTarefasController::class, 'restore'])->name('tarefas.restore');
    Route::get('/download/{id}', [ListaDeTarefasController::class, 'download'])->name('tarefas.download');
    Route::get('/tarefas', [ListaDeTarefasController::class, 'tarefas'])->name('tarefas.home');
    Route::get('/deleted', [ListaDeTarefasController::class, 'indexSoftDelete'])->name('tarefas.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/sugestoes', [SugestoesController::class, 'indexSugestoes'])->name('sugestao.index');
    Route::get('/save/sugestoes', [SugestoesController::class, 'criarSugestoes'])->name('sugestao.save');
    Route::post('/store/sugestoes', [SugestoesController::class, 'salvarSugestoes'])->name('sugestao.store');
    Route::post('/update/sugestoes', [SugestoesController::class, 'atualizarSugestao'])->name('sugestao.update');
});

require __DIR__ . '/auth.php';
