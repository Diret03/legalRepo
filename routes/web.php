<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JudgeController;
use App\Models\Judge;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('prueba');
})->name('/');

//Route::get('/registros-materias', function () {
//    return view('subjects');
//})->name('subjects.index');

Route::get('/go-back', function () {
    return back();
})->name('goBack');

Route::get('/test-email', function () {
    return view('emails.transactional');
});

Route::get('/materias',  [SubjectController::class, 'list'])->name('subjects.list');
Route::get('/subjects/filter', [SubjectController::class, 'filter'])->name('subjects.filter');

Route::get('/materia/{id}/juicios',  [TrialController::class, 'showTrials'])->name('trials.bySubject');

Route::get('/materia/juicio/{id}/casos',  [CaseController::class, 'showCasesbyTrial'])->name('cases.showByTrial');

Route::get('/casos/{id}', [CaseController::class, 'show'])->name('cases.show');
Route::get('/tags/caso/{id}/{tag}', [CaseController::class, 'showCaseByTag'])->name('tag.cases.show');
Route::get('/juicio/caso/{id}', [CaseController::class, 'showCaseByTrial'])->name('trial.cases.show');
Route::post('/casos/clean-filters', [CaseController::class, 'cleanFilters'])->name('cases.cleanFilters');
Route::get('/trials/filter', [TrialController::class, 'filter'])->name('trials.filter');

Route::get('/casos', [CaseController::class, 'list'])->name('cases.list');
Route::get('/etiquetas/caso/{id}', [CaseController::class, 'showByTag'])->name('cases.showByTag');

Route::get('/etiquetas', [TagController::class, 'list'])->name('tags.list');

Route::get("/cases/search", [CaseController::class, 'search'])->name('cases.search');
Route::get("/cases/filter", [CaseController::class, 'filter'])->name('cases.filter');
Route::get('/cases/tags/accepted', [TagController::class, 'getAcceptedTags']);
Route::get('/cases/{id}/download', [CaseController::class, 'generatePDF'])->name('cases.pdf');

Route::get('/judges/filter', [JudgeController::class, 'filter'])->name('judges.filter');

Route::get('/acerca', function () {
    $judges = Judge::orderBy('last_name', 'asc')->get();
    return view('about', compact('judges'));
})->name('about');

Route::get('/error-500', function () {
    abort(500);
});

Route::get('/error-401', function () {
    abort(401);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['middleware' => ['can:ver dashboard']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    // User routes
    Route::group(['middleware' => ['can:ver usuarios']], function () {
        Route::get('/dashboard/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');
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

    Route::group(['middleware' => ['can:desactivar usuarios']], function () {
        Route::patch("/dashboard/deactivate-selected-users", [UserController::class, 'deactivateSelected'])->name('users.deactivateSelected');
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
        Route::delete("/dashboard/selected-subjects", [SubjectController::class, 'deleteSelected'])->name('subjects.deleteSelected');
    });


    // Trial routes
    Route::get('/dashboard/{materia}/juicios', [TrialController::class, 'getTrialsBySubject']);

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


    //Judges routes
    Route::group(['middleware' => ['can:ver jueces']], function () {
        Route::get('/dashboard/jueces', [JudgeController::class, 'index'])->name('judges.index');
        Route::get('/dashboard/jueces/{judge}', [JudgeController::class, 'show'])->name('judges.show');
    });

    Route::get("/judges/search", [JudgeController::class, 'search'])->name('judges.search');

    Route::group(['middleware' => ['can:crear jueces']], function () {
        Route::get('/dashboard/jueces/crear', [JudgeController::class, 'create'])->name('judges.create');
        Route::post('/dashboard/jueces', [JudgeController::class, 'store'])->name('judges.store');
    });

    Route::group(['middleware' => ['can:editar jueces']], function () {
        Route::get('/dashboard/jueces/{judge}/editar', [JudgeController::class, 'edit'])->name('judges.edit');
        Route::put('/dashboard/jueces/{judge}', [JudgeController::class, 'update'])->name('judges.update');
    });

    Route::group(['middleware' => ['can:eliminar jueces']], function () {
        Route::delete('/dashboard/jueces/{judge}', [JudgeController::class, 'destroy'])->name('judges.destroy');
        Route::delete("/dashboard/selected-judges", [JudgeController::class, 'deleteSelected'])->name('judges.delete');
    });


    // Cases routes
    Route::group(['middleware' => ['can:ver casos']], function () {
        Route::get('/dashboard/casos', [CaseController::class, 'index'])->name('cases.index');
    });
    Route::get('/dashboard/casos/crear', [CaseController::class, 'create'])->name('cases.create');
    Route::post('/dashboard/casos', [CaseController::class, 'store'])->name('cases.store');
    Route::get('/dashboard/casos/{case}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/dashboard/casos/{case}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/dashboard/casos/{case}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::delete("/dashboard/selected-cases", [CaseController::class, 'deleteSelected'])->name('cases.delete');
    Route::get('/cases/tags', [TagController::class, 'getAllTags']);

    Route::get('/cases/{id}/tags', [CaseController::class, 'getTags']);
    Route::get('/dashboard/revisar', [CaseController::class, 'review'])->name('cases.review');
    Route::patch('/cases/{id}/approve', [CaseController::class, 'approve'])->name('cases.approve');
    Route::patch('/cases/{id}/reject', [CaseController::class, 'reject'])->name('cases.reject');

    Route::get('/dashboard/mis-casos', [CaseController::class, 'myCases'])->name('cases.mycases');



    Route::get('/dashboard/casos/archivados', [CaseController::class, 'archived'])->name('cases.archived');
    Route::post('dashboard/casos/{case}/restaurar', [CaseController::class, 'restore'])->name('cases.restore');
    Route::post('dashboard/casos/{case}/force-delete', [CaseController::class, 'forceDelete'])->name('cases.forceDelete');
    Route::post('dashboard/casos/force-delete-selected', [CaseController::class, 'forceDeleteSelected'])->name('cases.forceDeleteSelected');
});

Route::get('/caso-pdf', function () {
    $case = \App\Models\LegalCase::findOrFail(53);
    return view('pdf.case', ['case' => $case]);
});



Route::get('/inicio', function () {
    return view('prueba');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
