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

Route::get('/materias/juicio/{id}',  [TrialController::class, 'showTrials'])->name('trials.bySubject');

Route::get('/materias/juicio/casos/{id}',  [CaseController::class, 'showCasesbyTrial'])->name('cases.showByTrial');

//Route::get('/caso/{id}', [CaseController::class, 'showAll'])->name('cases.show');
Route::get('/casos/{case}', [CaseController::class, 'show'])->name('cases.show');
Route::get('/tags/caso/{id}/{tag}', [CaseController::class, 'showCaseByTag'])->name('tag.cases.show');
Route::get('/juicio/caso/{id}', [CaseController::class, 'showCaseByTrial'])->name('trial.cases.show');


Route::get('/casos', [CaseController::class, 'list'])->name('cases.list');
Route::get('/etiquetas/caso/{id}',[CaseController::class,'showByTag'])->name('cases.showByTag');

Route::get('/etiquetas', [TagController::class, 'list'])->name('tags.list');


Route::middleware(['auth', 'verified'])->group(function () {

    // User routes
    Route::group(['middleware' => ['can:ver usuarios']], function () {
        Route::get('/dashboard/usuarios', [UserController::class, 'index'])->name('users.index');
    });

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/dashboard/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::group(['middleware' => ['can:crear usuarios']], function () {
        Route::get('/dashboard/usuarios/crear', [UserController::class, 'create'])->name('users.create');
        Route::post('/dashboard/usuarios', [UserController::class, 'store'])->name('users.store');
    });

    Route::group(['middleware' => ['can:editar usuarios']], function () {
        Route::get('/dashboard/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/dashboard/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::group(['middleware' => ['can:eliminar usuarios']], function () {
          Route::delete('/dashboard/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
          Route::delete("/dashboard/selected-users", [UserController::class, 'deleteSelected'])->name('users.deleteSelected');
    });


    // Subject routes
    Route::group(['middleware' => ['can:ver materias']], function () {
        Route::get('/dashboard/materias', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/dashboard/materias/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    });
    Route::get("/materias/search", [SubjectController::class, 'search'])->name('subjects.search');

    Route::group(['middleware' => ['can:crear materias']], function () {
        Route::get('/dashboard/materias/crear', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('/dashboard/materias', [SubjectController::class, 'store'])->name('subjects.store');
    });

    Route::group(['middleware' => ['can:editar materias']], function () {
        Route::get('/dashboard/materias/{subject}/editar', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('/dashboard/materias/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    });

    Route::group(['middleware' => ['can:eliminar materias']], function () {
        Route::delete('/dashboard/materias/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
        Route::delete("/dashboard/materias/selected", [SubjectController::class, 'deleteSelected'])->name('subjects.deleteSelected');
    });


    // Trial routes
    Route::group(['middleware' => ['can:ver juicios']], function () {
        Route::get('/dashboard/juicios', [TrialController::class, 'index'])->name('trials.index');
        Route::get('/dashboard/juicios/{trial}', [TrialController::class, 'show'])->name('trials.show');
    });
    Route::get("/trials/search", [TrialController::class, 'search'])->name('trials.search');

    Route::group(['middleware' => ['can:crear juicios']], function () {
        Route::get('/dashboard/juicios/crear', [TrialController::class, 'create'])->name('trials.create');
        Route::post('/dashboard/juicios', [TrialController::class, 'store'])->name('trials.store');
    });

    Route::group(['middleware' => ['can:editar juicios']], function () {
        Route::get('/dashboard/juicios/{trial}/editar', [TrialController::class, 'edit'])->name('trials.edit');
        Route::put('/dashboard/juicios/{trial}', [TrialController::class, 'update'])->name('trials.update');
    });

    Route::group(['middleware' => ['can:eliminar juicios']], function () {
        Route::delete('/dashboard/juicios/{trial}', [TrialController::class, 'destroy'])->name('trials.destroy');
        Route::delete("/dashboard/selected-trials", [TrialController::class, 'deleteSelected'])->name('trials.delete');
    });

    // Cases routes
    Route::get('/dashboard/cases', [CaseController::class, 'index'])->name('cases.index');
    Route::get('/dashboard/casos/crear', [CaseController::class, 'create'])->name('cases.create');
    Route::post('/dashboard/cases', [CaseController::class, 'store'])->name('cases.store');

    Route::get('/dashboard/cases/{case}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/dashboard/cases/{case}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/dashboard/cases/{case}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::get("/cases/search", [CaseController::class, 'search'])->name('cases.search');
    Route::delete("/dashboard/selected-cases", [CaseController::class, 'deleteSelected'])->name('cases.delete');
    Route::get('/cases/tags', [CaseController::class, 'getAllTags']);
    Route::get('/cases/{id}/tags', [CaseController::class, 'getTags']);
    Route::get('/dashboard/revisar', [CaseController::class, 'review'])->name('cases.review');
    Route::patch('/cases/{id}/approve', [CaseController::class, 'approve'])->name('cases.approve');
    Route::patch('/cases/{id}/reject', [CaseController::class, 'reject'])->name('cases.reject');
    Route::get('/dashboard/mis-casos/{user_id}', [CaseController::class, 'myCases'])->name('cases.mycases');
});



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
