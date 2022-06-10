<h1>Outil de ticketing - DGAC</h1>
<h2>Vous avez créé un nouveau ticket au sein du service {{ $dataEntered['select'] }}.</h2>

<br>
<h3>Récapitulatif sur le ticket :</h3>
<p>N° du ticket: {{ $dataEntered['id'] }}</p>
<p>Taux de criticité du ticket: {{ $dataEntered['radio-hint'] }}</p>
<p>Titre du ticket : {{ $dataEntered['select-title'] }}</p>
<p>Description du ticket : {{ $dataEntered['textarea'] }}</p>
<p>Contact proposé : {{ $dataEntered['phone'] }}</p>
@if ($dataEntered['file'] == 'null')
    <p>Fichier : vous n'avez pas fourni d'image</p>
    @else
    <p>Fichier : vous avez fourni une image</p>
@endif

<br>
<p>Pour plus d'informations, regardez votre tableau de bord en vous connectant sur le site : <a href="{{ route('acc') }}">{{ route('acc') }}</a></p>
