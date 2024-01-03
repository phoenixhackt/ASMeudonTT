<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AS Meudon Tennis de Table - Progression</title>
    <meta name="description" content="Suivez la progression du classement des joeurs de tennis de table au sein du club AS Meudon. Consultez les données de manière interactive grâce à des tableaux dynamiques.">
    <meta name="author" content="index.html">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../../global.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">

    <!-- Move jQuery to the end of the body -->
    <script defer src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Combined JS -->
    <script defer src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/plug-ins/1.13.7/sorting/any-number.js"></script>
    <script defer src="https://cdn.datatables.net/plug-ins/1.13.7/filtering/row-based/TableTools.ShowSelectedOnly.js"></script>
    <script defer src="../../header.js"></script>

    <!-- htmx -->
    <script defer src="https://unpkg.com/htmx.org@1.9.10" integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div id="asMeudon">
            <a href="#"><span id="asMeudon1">AS</span><span id="asMeudon2">Meudon TT</span>
            </a>
        </div>
        <nav id="nav1">
            <ul class="navbar">
                <li id="liAccueil"><a href="../../index.html">Accueil</a></li>
                <li>
                    <a href="#">Le Club</a>
                    <ul>
                        <li>
                            <a href="../../Le Club/Inscriptions/inscriptions.html">Inscriptions</a>
                        </li>
                        <li><a href="../../Le Club/Lieu/lieu.html">Lieu</a></li>
                        <li>
                            <a href="../../Le Club/Entraîneurs et dirigeants/entraineurs.html">Entraîneurs et dirigeants</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Les Compétitions</a>
                    <ul>
                        <li>
                            <a href="../criterium/criterium.html">Criterium</a>
                        </li>
                        <li>
                            <a href="#">Progressions</a>
                        </li>
                        <li>
                            <a href="../championnat_par_equipes/equipes.php">Championnat par equipes</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Plus</a>
                    <ul>
                        <li><a href="../../Plus/stages/stages.html">Stages</a></li>
                        <li><a href="../../Plus/Horaires/horaires.html">Horaires</a></li>
                        <li><a href="../../Plus/Contact/contact.html">Contact</a></li>
                        <li>
                            <a href="../../Plus/collabs/collab.html">Les Collaborateurs</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a id="buttonInscription" href="../../Le Club/Inscriptions/inscriptions.html">S'inscrire</a>
                </li>
            </ul>
        </nav>
        <div class="divSidenav">
            <div id="mySidenav" class="sidenav">
                <a id="closeBtn" href="#" class="close">&times;</a>
                <ul>
                    <li><a class="aPrincipaux" href="../../index.html">Accueil</a></li>
                    <li><a class="aPrincipaux" href="#">Le Club</a></li>
                    <ul class="sousNav">
                        <li>
                            <a class="aSidenav" href="../../Le Club/Inscriptions/inscriptions.html">Inscriptions</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../../Le Club/Lieu/lieu.html">Lieu</a>
                        </li>
                        <li>
                            <a id="entraineurLong" class="aSidenav" href="../../Le Club/Entraîneurs et dirigeants/entraineurs.html">Entraîneurs et dirigeants</a>
                        </li>
                    </ul>
                    <li><a class="aPrincipaux" href="#">Les Compétitions</a></li>
                    <ul class="sousNav">
                        <li>
                            <a class="aSidenav" href="../criterium/criterium.html">Criterium</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../progressions/progressions.php">Progressions</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../championnat_par_equipes/equipes.php">Championnat par equipes</a>
                        </li>
                    </ul>
                    <li><a class="aPrincipaux" href="#">Plus</a></li>
                    <ul class="sousNav">
                        <li>
                            <a class="aSidenav" href="../../Plus/stages/stages.html">Stages</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../../Plus/Horaires/horaires.html">Horaires</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../../Plus/Contact/contact.html">Contact</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="../../Plus/collabs/collab.html">Les Collaborateurs</a>
                        </li>
                    </ul>
                </ul>
            </div>
            <a href="#" id="openBtn">
                <div class="burger-icon">
                    <img src="../../images/icon-burger.png" alt="Buger Icon" />
                </div>
            </a>
        </div>
    </header>


    <main>
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>
        <div class="precontent">
        </div>

        <div class="tables">
            <div hx-get="loaddata.php" hx-trigger="load delay:0.1s" hx-swap="outerHTML">
            </div>
        </div>

        <script>
            document.addEventListener("htmx:afterRequest", function() {
                // Hide the loader and show the content after each htmx request
                const loaderWrapper = document.getElementById("loader-wrapper");
                const preContent = document.querySelector(".precontent");
                const tables = document.querySelector(".tables");

                loaderWrapper.style.display = "none";
                preContent.style.display = "none";
                tables.style.display = "block";
            });
        </script>
    </main>

    <footer>
        <div>
            <h4>Menu</h4>
            <div id="separationMenu"></div>
            <ul id="first">
                <li>
                    <a href="#asMeudon">Accueil</a>
                </li>
                <li><a href="#asMeudon">Le Club</a></li>
                <li>
                    <a href="#asMeudon">Les Compétitions</a>
                </li>
                <li><a href="#asMeudon">Plus</a></li>
            </ul>
        </div>
        <div class="marginDiv">
            <h4>Contactez-nous</h4>
            <div id="separationContact"></div>
            <ul id="second">
                <li>
                    <div id="one">
                        <img src="../../images/phone.webp" alt="Icon téléphone" />
                        <p>
                            <a href="tel:+33171227252">01 71 22 72 52</a> &nbsp;
                            <br id="brNum" />
                            ou &nbsp; <a href="tel:+33661649008">06 61 64 90 08</a>
                        </p>
                    </div>
                </li>
                <li>
                    <div id="two">
                        <img src="../../images/email.webp" alt="Icon mail" />
                        <a href="mailto:asmeudontt@gmail.com">asmeudontt@gmail.com</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="marginDiv" id="web">
            <h4>Suivez-nous</h4>
            <div id="separationWeb"></div>
            <ul id="third">
                <a href="https://goo.gl/maps/eCt315XPcR1168rm9" target="_blank"><img src="../../images/map.webp" alt="Icon map" /></a>
                <a href="https://www.instagram.com/asmeudontennisdetable/" target="_blank"><img src="../../images/instagram.webp" alt="Logo Instagram" /></a>
                <a href="https://www.facebook.com/people/As-Meudon-Tennis-de-Table/100057156052613/" target="_blank"><img src="../../images/facebook.webp" alt="Logo Facebook" /></a>
            </ul>
        </div>
    </footer>

</body>

</html>