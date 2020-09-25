<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>add-project</title>
</head>
<body>
<h1>Edit project</h1>
<hr>
<form method="post" action="{{url('project', [$projects->id])}}">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group">
        <label for="title">Project Name</label>
        <input type="text" value="{{$projects->name}}" class="form-control" id="projectName"  name="name" >
    </div>
    <div class="form-group">
        <label for="description">Project Description</label>
        <input type="int" value="{{$projects->description}}" class="form-control" id="projectDescription" name="description" >
    </div>
    <a href="/project">
        <button type="button">Retourner aux projets'</button>
    </a>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
</body>
</html>
