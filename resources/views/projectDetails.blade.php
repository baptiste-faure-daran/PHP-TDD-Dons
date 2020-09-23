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
<h1>Projet</h1>

    <div>
            <div>
                <h2>{{$projects->name}}</h2>
                <p>{{$projects->User->name}}</p>
                <p>{{$projects->published_at}}</p>

                <a href="/project/{{$projects->id}}/edit">Modifier</a>
                <form action="/project/{{$projects->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="input">Supprimer</button>
                </form>
                <a href="/project">Retourner page projets</a>
            </div>


    </div>
</body>
</html>