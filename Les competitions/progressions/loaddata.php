<div>
    <?php
    // En-tête pour définir le type de contenu
    header('Content-Type: text/html; charset=utf-8');

    // Inclusion du fichier Service.php
    require_once('Fftt/Service.php');

    // Constantes pour les clés et les valeurs fixes
    const MALE = 'M';
    const FEMALE = 'F';
    const TRADITIONNELLE = 'T';
    const PROMOTIONNELLE = 'P';

    // Remplacez ces valeurs par celles de votre application FFTT
    $appId = 'SW927';
    $appKey = 'uJ5d9P6NqG';

    // Instancier la classe Service
    $service = new Mping\CoreBundle\Fftt\Service($appId, $appKey);

    // Initialiser l'utilisateur (à faire une fois)
    $service->initialization();

    // Remplacez NUMERO_CLUB par le numéro de votre club
    $getJoueursByClub = $service->getJoueursByClub('08920067');

    // Récupérez toutes les données dans un tableau
    $allJoueurs = [];

    foreach ($getJoueursByClub as $joueur) {
        try {
            $joueurDetails = $service->getLicence($joueur['licence']);
            $joueurProg = $service->getJoueur($joueur['licence']);
        } catch (Exception $e) {
            // Gérer l'erreur et passer au joueur suivant en cas d'erreur
            echo 'Une erreur est survenue lors du traitement des données.';
            continue;
        }

        // Ajoutez le joueur avec les détails et la progression à votre tableau
        $allJoueurs[] = [
            'details' => $joueurDetails,
            'progmois' => $joueurProg['progmois'],
            'progann' => $joueurProg['progann']
        ];
    }

    // Triez le tableau en fonction de la colonne de progression (décroissant)
    array_multisort(array_column($allJoueurs, 'progann'), SORT_DESC, $allJoueurs);

    // Sélectionnez les 5 meilleurs joueurs pour la progression annuelle
    $top5JoueursProgAnn = array_slice($allJoueurs, 0, 5);

    // Triez le tableau en fonction de la colonne de progression (décroissant)
    array_multisort(array_column($allJoueurs, 'progmois'), SORT_DESC, $allJoueurs);

    // Sélectionnez les 5 meilleurs joueurs pour la progression mensuelle
    $top5JoueursProgMois = array_slice($allJoueurs, 0, 5);
    ?>

    <!-- Affichez le premier tableau -->
    <h2>Joueurs</h2>
    <table class="joueurs-table" id="joueurs-table-all">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Licence</th>
                <th>Sexe</th>
                <th>Classement</th>
                <th>Certification</th>
                <th>Catégorie d'âge</th>
                <th>Type de licence</th>
                <th>Progression Annuelle</th>
                <th>Progression Mensuelle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allJoueurs as $joueur) : ?>
                <tr>
                    <td><?= $joueur['details']['nom'] ?></td>
                    <td><?= $joueur['details']['prenom'] ?></td>
                    <td><?= $joueur['details']['licence'] ?></td>
                    <td><?= formatSexe($joueur['details']['sexe']) ?></td>
                    <td><?= $joueur['details']['point'] ?></td>
                    <td><?= $joueur['details']['certif'] ?></td>
                    <td><?= $joueur['details']['cat'] ?></td>
                    <td><?= formatTypeLicence($joueur['details']['type']) ?></td>
                    <td><?= $joueur['progann'] ?></td>
                    <td><?= $joueur['progmois'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Affichez le deuxième tableau -->
    <h2>Top Progression de l'année</h2>
    <table class="joueurs-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Licence</th>
                <th>Sexe</th>
                <th>Classement</th>
                <th>Certification</th>
                <th>Catégorie d'âge</th>
                <th>Type de licence</th>
                <th>Progression Annuelle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($top5JoueursProgAnn as $joueur) : ?>
                <tr>
                    <td><?= $joueur['details']['nom'] ?></td>
                    <td><?= $joueur['details']['prenom'] ?></td>
                    <td><?= $joueur['details']['licence'] ?></td>
                    <td><?= formatSexe($joueur['details']['sexe']) ?></td>
                    <td><?= $joueur['details']['point'] ?></td>
                    <td><?= $joueur['details']['certif'] ?></td>
                    <td><?= $joueur['details']['cat'] ?></td>
                    <td><?= formatTypeLicence($joueur['details']['type']) ?></td>
                    <td><?= $joueur['progann'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Affichez le troisième tableau -->
    <h2>Top Progression du mois</h2>
    <table class="joueurs-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Licence</th>
                <th>Sexe</th>
                <th>Classement</th>
                <th>Certification</th>
                <th>Catégorie d'âge</th>
                <th>Type de licence</th>
                <th>Progression Mensuelle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($top5JoueursProgMois as $joueur) : ?>
                <tr>
                    <td><?= $joueur['details']['nom'] ?></td>
                    <td><?= $joueur['details']['prenom'] ?></td>
                    <td><?= $joueur['details']['licence'] ?></td>
                    <td><?= formatSexe($joueur['details']['sexe']) ?></td>
                    <td><?= $joueur['details']['point'] ?></td>
                    <td><?= $joueur['details']['certif'] ?></td>
                    <td><?= $joueur['details']['cat'] ?></td>
                    <td><?= formatTypeLicence($joueur['details']['type']) ?></td>
                    <td><?= $joueur['progmois'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#joueurs-table-all').DataTable({
                columnDefs: [{
                        type: 'any-number',
                        targets: 8
                    } // La colonne "Progression Annuelle" est à l'index 8
                ]
            });
        });
    </script>

    <?php
    // Fonction pour formater le sexe
    function formatSexe($sexe)
    {
        return ($sexe === MALE) ? '<p style="color: blue;">♂</p>' : '<p style="color: red;">♀</p>';
    }

    // Fonction pour formater le type de licence
    function formatTypeLicence($type)
    {
        return ($type === TRADITIONNELLE) ? 'T' : 'P';
    }
    ?>
</div>