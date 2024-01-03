<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes</title>
</head>

<body>

    <?php
    header('Content-Type: text/html; charset=utf-8');
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
    $getPouleClassementD1_P1 = $service->getPouleClassement('125705', '655053');
    $getPouleClassementD1_P2 = $service->getPouleClassement('125705', '655054');
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

        <?php foreach ($equipesByClub as $equipe) : ?>
            <tr class="tabcouleur1">
                <td>
                    <a href="/include/pages/equipes.php?cx_poule=656628&amp;D1=126126&amp;organisme_pere=16&amp;poule=1&amp;num_club=08920067&amp;color=5E9DC8&amp;taille=&amp;nomequipe=<?php echo urlencode($equipe['libequipe']); ?>&amp;num_phase=all&amp;numpoule=<?php echo $equipe['poule']; ?>&amp;division=<?php echo urlencode($equipe['libdivision']); ?>&amp;phase=1" title="<?php echo $equipe['libequipe']; ?>">
                        <?php echo $equipe['libequipe']; ?>
                    </a>
                </td>
                <td>1</td>
                <td><?php echo $equipe['libdivision']; ?></td>
            </tr>
        <?php endforeach; ?>

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
</body>

</html>