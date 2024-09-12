<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/registros-materias', function () {
//    return view('subjects');
//})->name('subjects.index');

Route::get('/materias',  [SubjectController::class, 'list'])->name('subjects.list');

Route::get('/juicios-materia/{id}',  [TrialController::class, 'showTrials'])->name('subjects.show');

Route::get('/casos-juicio/{id}',  [CaseController::class, 'showCasesbyTrial'])->name('cases.showByTrial');

Route::get('/caso/{id}', [CaseController::class, 'show'])->name('cases.show');


Route::get('/prueba', function () {
    return view('prueba');
})->name('prueba');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
