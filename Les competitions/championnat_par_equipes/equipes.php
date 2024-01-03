<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AS Meudon Tennis de Table - Équipes</title>
    <meta name="description" content="Découvrez les équipes du club de tennis de table AS Meudon. Consultez les détails du club, les contacts, et les classements des équipes dans différentes phases et divisions.">
    <meta name="author" content="Gary Lacroix && Maxence Pruvost && Antonin Pruvost">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../global.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <script src="../../header.js" defer></script>
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
                            <a class="aSidenav" href="Les competitions/criterium/criterium.html">Criterium</a>
                        </li>
                        <li>
                            <a class="aSidenav" href="Les competitions/progressions/progressions.php">Progressions</a>
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

        <?php
        require_once('Fftt/Service.php');

        // Remplacez ces valeurs par celles de votre application FFTT
        $appId = 'SW927';
        $appKey = 'uJ5d9P6NqG';

        // Instancier la classe Service
        $service = new Mping\CoreBundle\Fftt\Service($appId, $appKey);

        // Initialiser l'utilisateur (à faire une fois)
        $service->initialization();

        // Remplacez NUMERO_CLUB par le numéro de votre club
        $clubDetails = $service->getClub('08920067');
        $getJoueursByClub = $service->getJoueursByClub('08920067');
        $equipesByClub = $service->getEquipesByClub('08920067');
        // $getEpreuves = $service->getEpreuves('16', 'E');
        // $getDivisions = $service->getDivisions('F', '257', 'E');
        // Pour récupérer les id equipes, il suffit d'aller sur le lien de redirection xml_equipe.php et de regarder l'iddiv et cx_poule dans liendivision
        $getPouleClassementR1 = $service->getPouleClassement('126126', '656628');
        $getPouleClassementR2 = $service->getPouleClassement('125922', '655864');
        $getPouleClassementD1_P2 = $service->getPouleClassement('125705', '655054');
        $getPouleClassementD1_P1 = $service->getPouleClassement('125705', '655053');
        $getPouleClassementD2_P6 = $service->getPouleClassement('125705', '655058');
        ?>

        <h2>Club</h2>
        <table style="text-align: center; width: 100%; margin: auto;">
            <tbody>
                <tr class="tabtitre">
                    <td colspan="2">
                        <b><?php echo mb_convert_encoding($clubDetails['nom'], 'HTML-ENTITIES', 'UTF-8'); ?></b><br>
                        n°<?php echo mb_convert_encoding($clubDetails['numero'], 'HTML-ENTITIES', 'UTF-8'); ?>
                    </td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Salle</td>
                    <td><?php echo mb_convert_encoding($clubDetails['adressesalle1'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Code postal</td>
                    <td><?php echo mb_convert_encoding($clubDetails['codepsalle'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur2">
                    <td>Ville</td>
                    <td><?php echo mb_convert_encoding($clubDetails['villesalle'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Latitude</td>
                    <td><?php echo mb_convert_encoding($clubDetails['latitude'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur2">
                    <td>Longitude</td>
                    <td><?php echo mb_convert_encoding($clubDetails['longitude'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur1">
                    <td colspan="2"><a href="http://maps.google.fr/maps?f=q&amp;hl=fr&amp;q=<?php echo mb_convert_encoding($clubDetails['latitude'], 'HTML-ENTITIES', 'UTF-8'); ?>,<?php echo mb_convert_encoding($clubDetails['longitude'], 'HTML-ENTITIES', 'UTF-8'); ?>" title=" Afficher la carte " target="_blank" rel="noopener"><img src="../images/map.png" width="16px" height="16px" alt="" style="vertical-align:middle;"> Afficher la carte</a></td>
                </tr>
                <tr class="tabtitre">
                    <td colspan="2">Contact</td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Prénom</td>
                    <td><?php echo mb_convert_encoding($clubDetails['prenomcor'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur2">
                    <td>NOM</td>
                    <td><?php echo mb_convert_encoding($clubDetails['nomcor'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Téléphone</td>
                    <td><?php echo mb_convert_encoding($clubDetails['telcor'], 'HTML-ENTITIES', 'UTF-8'); ?></td>
                </tr>
                <tr class="tabcouleur2">
                    <td>Mail</td>
                    <td><a href="mailto:<?php echo mb_convert_encoding($clubDetails['mailcor'], 'HTML-ENTITIES', 'UTF-8'); ?>" title="<?php echo mb_convert_encoding($clubDetails['mailcor'], 'HTML-ENTITIES', 'UTF-8'); ?>"><?php echo mb_convert_encoding($clubDetails['mailcor'], 'HTML-ENTITIES', 'UTF-8'); ?></a></td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Site internet</td>
                    <td><a href="https://asmeudontennisdetable.fr">https://asmeudontennisdetable.fr</a></td>
                </tr>
            </tbody>
        </table>

        <h2>Équipes</h2>
        <table style="text-align: center; width: 100%; margin: auto;">
            <tr class="tabtitre">
                <td>Nom équipe</td>
                <td>Phase</td>
                <td>Division</td>
            </tr>

            <?php
            $compteur = 1; // Initialisation du compteur

            foreach ($equipesByClub as $equipe) :
                $nomPage = 'meudon' . $compteur;
            ?>
                <tr class="tabcouleur1">
                    <td>
                        <a href="parties/<?php echo $nomPage; ?>.php">
                            <?php echo $equipe['libequipe']; ?>
                            <br>
                            voir les résultats
                        </a>
                    </td>
                    <td>1</td>
                    <td><?php echo $equipe['libdivision']; ?></td>
                </tr>
            <?php
                $compteur++;
            endforeach;
            ?>

        </table>

        <h2>Résultat Equipes</h2>

        <?php
        // Tableau des classements de poules
        $poulesClassements = array(
            $getPouleClassementR1,
            $getPouleClassementR2,
            $getPouleClassementD1_P1,
            $getPouleClassementD1_P2,
            $getPouleClassementD2_P6,
        );

        foreach ($poulesClassements as $classementPoule) :
        ?>
            <table style="text-align: center; width: 100%; margin: auto;">
                <tr class="tabtitre">
                    <td colspan="2">
                        <b>Poule <?php echo $classementPoule[0]['poule']; ?></b>
                    </td>
                </tr>
                <tr class="tabcouleur1">
                    <td>Classement</td>
                    <td>Équipe</td>
                </tr>
                <?php foreach ($classementPoule as $equipeClassement) : ?>
                    <tr class="tabcouleur1">
                        <td><?php echo $equipeClassement['clt']; ?></td>
                        <td>
                            <?php
                            // Vérifier si l'ID du club est égal à 12920067
                            if ($equipeClassement['idclub'] == '12920067') {
                                echo '<strong>' . mb_convert_encoding($equipeClassement['equipe'], 'HTML-ENTITIES', 'UTF-8') . '</strong>';
                            } else {
                                echo mb_convert_encoding($equipeClassement['equipe'], 'HTML-ENTITIES', 'UTF-8');
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>

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