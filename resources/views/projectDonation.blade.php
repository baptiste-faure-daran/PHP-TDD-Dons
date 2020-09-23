
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>donation</title>
</head>
<body>

<h1>{{$projects->name}}</h1>
<h2>Historique des donnations</h2>

@foreach ($projects->donation as $donation)
<li>
    <u>{{$donation->user->name}} : {{$donation->amount}} Euros</u>
</li>
    <br>
@endforeach
<br>
<br>

<form action="{{url('projectDonation', [$projects->id])}}" method="post">
    {{ csrf_field() }}
    <h4>Faire un don</h4>
    <input type="int" id="donationAmount" name="amount">
    <br>
    <input type="hidden" name="project_id" value="{{$projects->id}}"/>
    <button type="submit" class="btn btn-primary">Donner C donner, reprendre C voler</button>
</form>
<br>
<a href="/project/{{$projects->id}}">Retourner page projet</a>

</body>
</html>