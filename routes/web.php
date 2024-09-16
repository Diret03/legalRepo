<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('prueba');
});

//Route::get('/registros-materias', function () {
//    return view('subjects');
//})->name('subjects.index');

Route::get('/go-back', function() {
    return back();
})->name('goBack');

Route::get('/materias',  [SubjectController::class, 'list'])->name('subjects.list');

Route::get('/materia/juicio/{id}',  [TrialController::class, 'showTrials'])->name('trials.bySubject');

Route::get('/materia/juicio/casos/{id}',  [CaseController::class, 'showCasesbyTrial'])->name('cases.showByTrial');

Route::get('/caso/{id}', [CaseController::class, 'showAll'])->name('cases.show');
Route::get('/tags/caso/{id}/{tag}', [CaseController::class, 'showCaseByTag'])->name('tag.cases.show');
Route::get('/juicio/caso/{id}', [CaseController::class, 'showCaseByTrial'])->name('trial.cases.show');


Route::get('/casos', [CaseController::class, 'list'])->name('cases.list');
Route::get('/casos-etiqueta/{id}',[CaseController::class,'showByTag'])->name('cases.showByTag');

Route::get('/etiquetas', [TagController::class, 'list'])->name('tags.list');

Route::resource('/dashboard/users', UserController::class);

Route::get('/inicio', function () {
    return view('prueba');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
