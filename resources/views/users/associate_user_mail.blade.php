<p>Olá, {{ $person->name }}</p>
@foreach($messages as $message)
    <p>{{ $message }}</p>
@endforeach
<p><a target="_blank" href="{{ route('home') }}">Acesso</a></p>
