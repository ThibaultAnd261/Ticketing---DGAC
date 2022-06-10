<h1>Outil de ticketing - DGAC</h1>
<h2>Un nouveau ticket au sein du service {{ $dataEntered['select'] }} a été créé.</h2>

<br>
<h3>Renseignements sur le ticket :</h3>
<p>N° du ticket: {{ $dataEntered['id'] }}</p>
<p>Taux de criticité du ticket: {{ $dataEntered['radio-hint'] }}</p>
<p>Titre du ticket : {{ $dataEntered['select-title'] }}</p>

<br>
<p>Pour plus d'informations, regardez votre tableau de bord en vous connectant sur le site : <a href="{{ route('acc') }}">{{ route('acc') }}</a></p>

