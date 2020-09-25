<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Project</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
    </style>

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body>
    <h1>Liste des projets</h1>

    <h2>Hello</h2>

    @foreach($projects as $project)
    <div>
        <a href="/project/{{$project->id}}">
            <div>
                <h2>{{$project->name}}</h2>
                <p>{{$project->description}}</p>
                <p>{{$project->published_at}}</p>
            @auth
                <form action="/project/{{$project->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="input">Supprimer</button>
                </form>
                @endauth
            </div>
            @endforeach
        </a>
        <a href="/project/create">
            <p>Ajouter un projet</p>
        </a>
        <a href="/dashboard">
            <p>Retourner page accueil</p>
        </a>
    </div>
</body>
</html>