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

    @foreach($projects as $project)
    <div>
        <a href="/article/{{$project->id}}">
            <div>
                <h2>{{$project->name}}</h2>
                <p>{{$project->description}}</p>
            </div>
            @endforeach
        </a>
    </div>
</body>
</html>