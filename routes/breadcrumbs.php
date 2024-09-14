<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Tags\Tag;


// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('home'));
});

// Materias
Breadcrumbs::for('subjects', function (BreadcrumbTrail $trail) {
    $trail->push('Materias', route('subjects.list'));
});

// [Materia]
Breadcrumbs::for('subject', function (BreadcrumbTrail $trail, $subject) {
    $trail->push('Materia: ', route('subjects.list'));
});

// [Materia] > [Juicios]
Breadcrumbs::for('trials', function (BreadcrumbTrail $trail, $subject) {
    $trail->parent('subjects');
    $trail->push($subject->name, route('trials.bySubject', $subject->id));
});

// Materias > [Materia] > [Juicio]
Breadcrumbs::for('casesByTrial', function (BreadcrumbTrail $trail, $trial) {
    $trail->parent('trials', $trial->subject);
    $trail->push($trial->name, route('cases.showByTrial', $trial->id));
});

// Materias > [Materia] > [Juicio] > [Caso]
Breadcrumbs::for('caseByTrial', function (BreadcrumbTrail $trail, $case) {
    $trail->parent('casesByTrial', $case->trial);
    $trail->push('Caso '.$case->id, route('trial.cases.show', $case->id));
});

// Tags
Breadcrumbs::for('tags', function (BreadcrumbTrail $trail) {
    $trail->push('Etiquetas', route('tags.list'));
});


// Tags > [Tag]
Breadcrumbs::for('casesByTag', function (BreadcrumbTrail $trail, $tag) {

    $trail->parent('tags');
    $true_tag = Tag::findOrFail($tag);
    $trail->push($true_tag->name, route('cases.showByTag', $tag));
});

// Tags > [Tag]
Breadcrumbs::for('casesByTagDef', function (BreadcrumbTrail $trail, $tag) {

    $trail->parent('tags');
    $trail->push($tag->name, route('cases.showByTag', $tag));
});

//Tags > [Tag] > [Case]
Breadcrumbs::for('caseByTag', function (BreadcrumbTrail $trail, $case, $tag) {
    $trail->parent('casesByTag', $tag);
    $trail->push('Caso ' . $case->id, route('cases.showByTag', [$case->id, $tag]));
});
