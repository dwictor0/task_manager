<?php

use App\Http\Controllers\ProfileController;
use App\Jobs\EnviarAlertaTarefaJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListaDeTarefasController;
use App\Events\TestePusherEvent;
use App\Models\ListaTarefas;
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
    Route::post('/restore/{id}', [ListaDeTarefasController::class, 'restore'])->name('tarefas.restore');
    Route::get('/controle', [ListaDeTarefasController::class,'controleTarefas'])->name('tarefas.controle');
    Route::get('/deleted', [ListaDeTarefasController::class, 'IndexSoftDelete'])->name('tarefas.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
