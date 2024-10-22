<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $case->title }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Figtree, "Times New Roman", sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        hr {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 20px 0;
        }

        .case-info {
            margin-bottom: 20px;
        }

        .case-info p {
            margin: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .tags {
            margin-top: 10px;
        }

        .tag {
            display: inline-block;
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .context {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }

        .context h2 {
            font-size: 18px;
            margin-top: 0;
            color: #495057;
        }

        footer {
            margin-top: 30px;
            text-align: center;
            padding: 15px;
            background-color: #dc3545;
            color: white;
        }

        footer img {
            max-width: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>{{ $case->title }}</h1>
            <hr>
        </header>

        <main>
            <div class="case-info">
                <p><span class="label">Número de caso:</span> {{ $case->id }}</p>
                <p><span class="label">Materia:</span> {{ $case->trial->subject->name }}</p>
                <p><span class="label">Juicio:</span> {{ $case->trial->name }}</p>
                <div class="tags">
                    <span class="label">Etiquetas:</span>
                    @foreach ($case->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="context">
                <h2>Contexto</h2>
                {!! htmlspecialchars_decode($case->context) !!}
            </div>
            <div class="context">
                <h2>Analisis</h2>
                {!! htmlspecialchars_decode($case->analysis) !!}
            </div>
            <div class="context">
                <h2>Resolucion</h2>
                {!! htmlspecialchars_decode($case->resolution) !!}
            </div>
            <div class="context">
                <h2>Nota</h2>
                {!! htmlspecialchars_decode($case->note) !!}
            </div>
        </main>

        <footer>
            <img src="{{ public_path('img/logo-utn.png') }}" alt="Logo UTN">
            <p>Repositorio Jurídico UTN</p>
        </footer>
    </div>
