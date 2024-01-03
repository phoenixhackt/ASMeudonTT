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
    $getPouleClassementR1 = $service->getPouleClassement('126126', '656628');
    $link = $getPouleClassementR1['lien'];
    $getRencontre = $service->getRencontre($link);
    ?>
    <pre><?php print_r($getRencontre); ?></pre>

</body>

</html>