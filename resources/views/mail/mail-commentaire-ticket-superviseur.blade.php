@foreach ($dataTicket as $data)
    <h1>Outil de ticketing - DGAC</h1>
    <h2>Vous avez ajouté/modifié un commentaire sur un des tickets créé au sein du service {{ $data->serviceAffecte }}.</h2>

    <h3>Renseignements sur le ticket concerné :</h3>
    <p>N° du ticket : {{ $data->id }}</p>
    <p>Titre du ticket : {{ $data->titre }}</p>
    <br>
    
    <p>Commentaire inséré/modifié : "{{ $data->commentaires }}"</p>
    <br>

    <p>Pour plus d'informations, regardez vos tickets en vous connectant sur le site : <a
        href="{{ route('acc') }}">{{ route('acc') }}</a></p>

@endforeach
