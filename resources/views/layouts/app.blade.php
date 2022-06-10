<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ url('dsfr/dsfr.min.css') }}">

    <meta name="theme-color" content="#ffffff">
    <!-- Défini la couleur de thème du navigateur (Safari/Android) -->
    <link rel="apple-touch-icon" href="{{ url('favicon/apple-touch-icon.png') }}">
    <!-- 180×180 -->
    <link rel="icon" href="{{ url('favicon/favicon.svg') }}" type="image/svg+xml">
    <!-- <link rel="shortcut icon" href="favicon/favicon.ico" type="image/x-icon"> -->
    <!-- 32×32 -->
    <link rel="manifest" href="favicon/manifest.webmanifest" crossorigin="use-credentials">
    <!-- Modifier les chemins relatifs des favicons en fonction de la structure du projet -->
    <!-- Dans le fichier manifest.webmanifest aussi, modifier les chemins vers les images -->

    <script src="{{ url('../resources/js/app.js') }}"></script>
    <title>Outil de ticketing</title>
</head>

<body>
    <header role="banner" class="fr-header">
        <div class="fr-header__body test">
            <div class="fr-container">
                <div class="fr-header__body-row">
                    <div class="fr-header__brand fr-enlarge-link">
                        <div class="fr-header__brand-top">
                            <div class="fr-header__logo">
                                <p class="fr-logo">
                                    MINISTERE
                                    <br>DE LA TRANSITION
                                    <br>ECOLOGIQUE
                                </p>
                            </div>
                            <div class="fr-header__navbar">
                                <button class="fr-btn--menu fr-btn" data-fr-opened="false" aria-controls="modal-833"
                                    aria-haspopup="menu" title="Menu" id="fr-btn-menu-mobile">
                                    Menu
                                </button>
                            </div>
                        </div>
                        <div class="fr-header__service">
                            <a href="#"
                                title="Accueil - [À MODIFIER | Nom du site / service] - [À MODIFIER | nom de l’entité (ministère , secrétariat d‘état, gouvernement)]">
                                <p class="fr-header__service-title">Outil de ticketing / DGAC</p>
                            </a>
                            <p class="fr-header__service-tagline">baseline - précisions sur l‘organisation</p>
                        </div>
                    </div>
                    <div class="fr-header__tools">
                        <div class="fr-header__tools-links">
                            <ul class="fr-btns-group">
                                <li>
                                    @if (auth()->check())
                                        <a class="fr-btn fr-fi-lock-line" href="#"
                                            onclick="document.getElementById('logout-form').submit()">
                                            <form action="{{ route('dec') }}" method="post" id="logout-form">@csrf
                                            </form>
                                            Se déconnecter
                                        </a>
                                    @else
                                        <a class="fr-btn fr-fi-lock-line" href="{{ route('con') }}">Se connecter</a>
                                    @endif
                                </li>
                                <li>
                                    @if (!auth()->check())
                                        <a class="fr-btn fr-fi-account-line"
                                            href="{{ route('creC') }}">S’enregistrer</a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @yield('navbar')
            </div>
        </div>

        <!-- Navigation principale -->
        <div class="fr-header__menu fr-modal" id="modal-833" aria-labelledby="fr-btn-menu-mobile">
            <div class="fr-container">
                <button class="fr-btn--close fr-btn" aria-controls="modal-833">Fermer</button>
                <div class="fr-header__menu-links"></div>
            </div>
        </div>

    </header>

    <!-- permet d'appeler les différentes parties dynamiques lorsque 'section' est appelé sur les autres pages -->
    @yield('content')

    <dialog aria-labelledby="fr-modal-title-modal-1" role="dialog" id="fr-modal-1" class="fr-modal">
        <div class="fr-container fr-container--fluid fr-container-md">
            <div class="fr-grid-row fr-grid-row--center">
                <div class="fr-col-12 fr-col-md-8 fr-col-lg-6">
                    <div class="fr-modal__body">
                        <div class="fr-modal__header">
                            <button class="fr-btn--close fr-btn" title="Fermer la fenêtre modale"
                                aria-controls="fr-modal-1">Fermer</button>
                        </div>
                        @yield('modal')
                        {{-- @yield('modal2') --}}
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <dialog aria-labelledby="fr-modal-title-modal-confirmation" role="dialog" id="fr-modal-confirmation"
        class="fr-modal">
        <div class="fr-container fr-container--fluid fr-container-md">
            <div class="fr-grid-row fr-grid-row--center">
                <div class="fr-col-12 fr-col-md-8 fr-col-lg-6">
                    <div class="fr-modal__body">
                        <div class="fr-modal__header">
                            <button class="fr-btn--close fr-btn" title="Fermer la fenêtre modale"
                                aria-controls="fr-modal-confirmation">Fermer</button>
                        </div>
                        @yield('modal-confirmation')
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <dialog aria-labelledby="fr-modal-commentaire" role="dialog" id="fr-modal-commentaire" class="fr-modal">
        <div class="fr-container fr-container--fluid fr-container-md">
            <div class="fr-grid-row fr-grid-row--center">
                <div class="fr-col-12 fr-col-md-8 fr-col-lg-6">
                    <div class="fr-modal__body">
                        <div class="fr-modal__header">
                            <button class="fr-btn--close fr-btn" title="Fermer la fenêtre modale"
                                aria-controls="fr-modal-commentaire">Fermer</button>
                        </div>
                        <form action="{{ route('commentaireTicket') }} " method="post" id="commentaire-insert"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="fr-modal__content">
                                <h3 id="fr-modal-2-title" class="fr-tile__body">Voulez-vous écrire un commentaire ?
                                </h3>
                                <textarea class="fr-input" id="textarea-commentaire" name="commentaire"></textarea>
                            </div>
                            <div class="fr-modal__footer">
                                <ul
                                    class="fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg fr-btns-group--icon-left">
                                    <li>
                                        <button class="fr-btn" id="btn-statut--chgmt">
                                            Envoyer
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <footer class="fr-footer" role="contentinfo" id="footer">
        <div class="fr-container">
            <div class="fr-footer__body">
                <div class="fr-footer__brand fr-enlarge-link">
                    <a href="/" title="Retour à l’accueil">
                        <p class="fr-logo" title="république française">
                            Intitulé<br> officiel
                        </p>
                    </a>
                </div>
                <div class="fr-footer__content">
                    <p class="fr-footer__content-desc">Lorem [...] elit ut.</p>
                    <ul class="fr-footer__content-list">
                        <li class="fr-footer__content-item">
                            <a class="fr-footer__content-link" href="https://legifrance.gouv.fr">legifrance.gouv.fr</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a class="fr-footer__content-link" href="https://gouvernement.fr">gouvernement.fr</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a class="fr-footer__content-link" href="https://service-public.fr">service-public.fr</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a class="fr-footer__content-link" href="https://data.gouv.fr">data.gouv.fr</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="fr-footer__bottom">
                <ul class="fr-footer__bottom-list">
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Plan du site</a>
                    </li>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Accessibilité: non/partiellement/totalement
                            conforme</a>
                    </li>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Mentions légales</a>
                    </li>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Données personnelles</a>
                    </li>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="#">Gestion des cookies</a>
                    </li>
                </ul>
                <div class="fr-footer__bottom-copy">
                    <p>Sauf mention contraire, tous les contenus de ce site sont sous <a
                            href="https://github.com/etalab/licence-ouverte/blob/master/LO.md" target="_blank">licence
                            etalab-2.0</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
<!-- Script en version es6 module et nomodule pour les navigateurs le ne supportant pas -->
<script type="module" src="dsfr/dsfr.module.min.js"></script>
<script type="text/javascript" nomodule src="dsfr/dsfr.nomodule.min.js"></script>

</html>
