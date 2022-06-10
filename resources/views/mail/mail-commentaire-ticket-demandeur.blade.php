@foreach ($dataTicket as $data)
    <h1>Outil de ticketing - DGAC</h1>
    <h2>Un superviseur du service {{ $data->serviceAffecte }} a ajouté/modifié un commentaire sur un de vos tickets créé.</h2>

    <h3>Renseignements sur le ticket concerné :</h3>
    <p>N° du ticket : {{ $data->id }}</p>
    <p>Titre du ticket : {{ $data->titre }}</p>
    <br>
    
    <p>Commentaire inséré/modifié : "{{ $data->commentaires }}"</p>
    <br>

    <p>Pour plus d'informations, regardez vos tickets en vous connectant sur le site : <a
        href="{{ route('acc') }}">{{ route('acc') }}</a></p>

@endforeach
