@foreach ($dataTicket as $data)
    <h1>Outil de ticketing - DGAC</h1>
    <h2>Vous avez redéfini un ticket appartenant au service {{ $data->serviceAffecte }}.</h2>

    <h3>Renseignements sur le ticket concerné :</h3>
    <p>N° du ticket : {{ $data->id }}</p>
    <p>Titre du ticket : {{ $data->titre }}</p>
    <p>Création du ticket : {{ $data->created_at }}</p>
    <p>Taux de criticité du ticket: {{ $data->priorite }}</p>
    <br>

    @if ($data->status == 'en cours')
        <p>Le ticket est désormais <strong>en cours de traitement</strong> grâce à votre intervention.</p>
    @elseif($data->status == 'traité')
        <p>Le ticket est désormais <strong>traité</strong> grâce à votre intervention.</p>
    @endif
    <br>

    <p>Pour plus d'informations, regardez vos tickets en vous connectant sur le site : <a
            href="{{ route('acc') }}">{{ route('acc') }}</a></p>
@endforeach
