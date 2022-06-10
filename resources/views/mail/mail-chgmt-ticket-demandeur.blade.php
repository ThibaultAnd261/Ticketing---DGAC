@foreach ($dataTicket as $data)
    <h1>Outil de ticketing - DGAC</h1>
    <h2>Un superviseur du service {{ $data->serviceAffecte }} a redéfini un ticket créé par vous.</h2>

    <h3>Renseignements sur le ticket concerné :</h3>
    <p>N° du ticket : {{ $data->id }}</p>
    <p>Titre du ticket : {{ $data->titre }}</p>
    <p>Création du ticket : {{ $data->created_at }}</p>
    <p>Taux de criticité du ticket: {{ $data->priorite }}</p>
    <br>
    
    @if ($data->status == 'en cours')
        <p>Votre ticket est désormais <strong>en cours de traitement</strong>.</p>
    @elseif($data->status == 'traité')
        <p>Votre ticket est désormais <strong>traité</strong>.</p>
    @endif
    <br>

    <p>Pour plus d'informations, regardez vos tickets en vous connectant sur le site : <a
            href="{{ route('acc') }}">{{ route('acc') }}</a></p>
@endforeach
