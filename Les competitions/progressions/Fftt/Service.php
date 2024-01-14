<?php

namespace Mping\CoreBundle\Fftt;

/**
 * @author VincentBab vincentbab@gmail.com
 */
class Service
{
    /**
     * @var string $appId ID de l'application fourni par la FFTT (ex: AM001)
     */
    protected $appId;

    /**
     * @var string $appKey Mot de passe fourni par la FFTT
     */
    protected $appKey;

    /**
     * @var string $serial Serial de l'utilisateur
     */
    protected $serial;

    /**
     * @var object $cache
     */
    protected $cache;

    /**
     * @var object $logger
     */
    protected $logger;

    /**
     * @var string $ipSource
     */
    protected $ipSource;

    public function __construct($appId, $appKey)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;

        libxml_use_internal_errors(true);
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function getAppKey()
    {
        return $this->appKey;
    }

    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setIpSource($ipSource)
    {
        $this->ipSource = $ipSource;

        return $this;
    }

    public function getIpSource()
    {
        return $this->ipSource;
    }

    public function initialization()
    {
        return Service::getObject($this->getData('https://apiv2.fftt.com/mobile/pxml/xml_initialisation.php', array()));
    }

    public function getClubsByDepartement($departement)
    {
        return $this->getCachedData("clubs_{$departement}", 3600 * 24 * 7, function ($service) use ($departement) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_club_dep2.php', array('dep' => $departement)), 'club');
        });
    }

    public function getClub($numero)
    {
        return $this->getCachedData("club_{$numero}", 3600 * 24 * 7, function ($service) use ($numero) {
            return Service::getObject($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_club_detail.php', array('club' => $numero)), 'club');
        });
    }
    public function cleanClub($numero)
    {
        if (!$this->cache) {
            return;
        }

        $this->cache->delete("club_{$numero}");
        $this->cache->delete("clubjoueurs_{$numero}");
        $this->cache->delete("clubequipes_{$numero}_M");
        $this->cache->delete("clubequipes_{$numero}_F");
        $this->cache->delete("clubequipes_{$numero}_");
    }

    public function getJoueur($licence)
    {
        $joueur = $this->getCachedData("joueur_{$licence}", 3600 * 24 * 7, function ($service) use ($licence) {
            return Service::getObject($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_joueur.php', array('licence' => $licence, 'auto' => 1)), 'joueur');
        });

        if (!isset($joueur['licence'])) {
            return null;
        }

        if (empty($joueur['natio'])) {
            $joueur['natio'] = 'F';
        }

        $joueur['photo'] = "https://apiv2.fftt.com/espacelicencie/photolicencie/{$joueur['licence']}_.jpg";
        $joueur['progmois'] = round($joueur['point'] - $joueur['apoint'], 2); // Progression mensuelle
        $joueur['progann'] = round($joueur['point'] - $joueur['valinit'], 2); // Progression annuelle

        return $joueur;
    }
    
    public function cleanJoueur($licence)
    {
        if (!$this->cache) {
            return;
        }

        $this->cache->delete("joueur_{$licence}");
        $this->cache->delete("joueurparties_{$licence}");
        $this->cache->delete("joueurspid_{$licence}");
    }

    public function getJoueurParties($licence)
    {
        return $this->getCachedData("joueurparties_{$licence}", 3600 * 24 * 7, function ($service) use ($licence) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_partie_mysql.php', array('licence' => $licence, 'auto' => 1)), 'partie');
        });
    }

    public function getJoueurPartiesSpid($licence)
    {
        return $this->getCachedData("joueurspid_{$licence}", 3600 * 24 * 1, function ($service) use ($licence) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_partie.php', array('numlic' => $licence)), 'resultat');
        });
    }

    public function getJoueurHistorique($licence)
    {
        return $this->getCachedData("joueur_historique_{$licence}", 3600 * 24 * 2, function ($service) use ($licence) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_histo_classement.php', array('numlic' => $licence)), 'histo');
        });
    }

    public function getJoueursByName($nom, $prenom = '')
    {
        return $this->getCachedData("joueurs_{$nom}_{$prenom}", 3600 * 24 * 7, function ($service) use ($nom, $prenom) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_liste_joueur.php', array('nom' => $nom, 'prenom' => $prenom)), 'joueur');
        });
    }

    public function getJoueursByClub($club)
    {
        return $this->getCachedData("clubjoueurs_{$club}", 3600 * 24 * 7, function ($service) use ($club) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_liste_joueur.php', array('club' => $club)), 'joueur');
        });
    }

    public function getEquipesByClub($club, $type = null)
    {
        if ($type && !in_array($type, array('M', 'F'))) {
            $type = 'M';
        }

        $teams = $this->getCachedData("clubequipes_{$club}_{$type}", 3600 * 24 * 7, function ($service) use ($club, $type) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_equipe.php', array('numclu' => $club, 'type' => $type)), 'equipe');
        });

        foreach ($teams as &$team) {
            $params = is_array($team['liendivision']) ? $team['liendivision'] : json_decode($team['liendivision'], true);

            // Vérifier si les clés existent avant de les utiliser
            $team['idpoule'] = isset($params['cx_poule']) ? $params['cx_poule'] : null;
            $team['iddiv'] = isset($params['D1']) ? $params['D1'] : null;
        }

        return $teams;
    }

    public function getPoules($division)
    {
        $poules = $this->getCachedData("poules_{$division}", 3600 * 24 * 7, function ($service) use ($division) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_equ.php', array('action' => 'poule', 'D1' => $division)), 'poule');
        });

        foreach ($poules as &$poule) {
            $params = array();
            parse_str($poule['lien'], $params);

            $poule['idpoule'] = $params['cx_poule'];
            $poule['iddiv'] = $params['D1'];
        }

        return $poules;
    }

    public function getPouleClassement($division, $poule = null)
    {
        return $this->getCachedData("pouleclassement_{$division}_{$poule}", 3600 * 24 * 1, function ($service) use ($division, $poule) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_equ.php', array('auto' => 1, 'action' => 'classement', 'D1' => $division, 'cx_poule' => $poule)), 'classement');
        });
    }

    public function getPouleRencontres($division, $poule = null)
    {
        return $this->getCachedData("poulerencontres_{$division}_{$poule}", 3600 * 24 * 1, function ($service) use ($division, $poule) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_equ.php', array('auto' => 1, 'D1' => $division, 'cx_poule' => $poule)), 'tour');
        });
    }

    public function getIndivGroupes($division)
    {
        $groupes = $this->getCachedData("groupes_{$division}", 3600 * 24 * 7, function ($service) use ($division) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'poule', 'res_division' => $division)), 'tour');
        });

        foreach ($groupes as &$groupe) {
            $params = array();
            parse_str($groupe['lien'], $params);

            if (isset($params['cx_tableau'])) {
                $groupe['idgroupe'] = $params['cx_tableau'];
            } else {
                $groupe['idgroupe'] = null;
            }
            $groupe['iddiv'] = $params['res_division'];
        }

        return $groupes;
    }

    public function getGroupeClassement($division, $groupe = null)
    {
        return $this->getCachedData("groupeclassement_{$division}_{$groupe}", 3600 * 24 * 1, function ($service) use ($division, $groupe) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'classement', 'res_division' => $division, 'cx_tableau' => $groupe)), 'classement');
        });
    }

    public function getGroupeRencontres($division, $groupe = null)
    {
        return $this->getCachedData("grouperencontres_{$division}_{$groupe}", 3600 * 24 * 1, function ($service) use ($division, $groupe) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'partie', 'res_division' => $division, 'cx_tableau' => $groupe)), 'partie');
        });
    }

    public function getOrganismes($type)
    {
        // Zone / Ligue / Departement
        if (!in_array($type, array('Z', 'L', 'D'))) {
            $type = 'L';
        }

        return $this->getCachedData("organismes_{$type}", 3600 * 24 * 30, function ($service) use ($type) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_organisme.php', array('type' => $type)), 'organisme');
        });
    }

    public function getEpreuves($organisme, $type)
    {
        // Equipe / Individuelle
        if (!in_array($type, array('E', 'I'))) {
            $type = 'E';
        }

        return $this->getCachedData("epreuves_{$organisme}_{$type}", 3600 * 24 * 30, function ($service) use ($organisme, $type) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_epreuve.php', array('type' => $type, 'organisme' => $organisme)), 'epreuve');
        });
    }

    public function getDivisions($organisme, $epreuve, $type = 'E')
    {
        // Equipe / Individuelle
        if (!in_array($type, array('E', 'I'))) {
            $type = 'E';
        }

        return $this->getCachedData("divisions_{$organisme}_{$epreuve}_{$type}", 3600 * 24 * 7, function ($service) use ($organisme, $epreuve, $type) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_division.php', array('organisme' => $organisme, 'epreuve' => $epreuve, 'type' => $type)), 'division');
        });
    }

    public function getRencontre($link)
    {
        $params = array();
        parse_str($link, $params);

        return $this->getCachedData("rencontre_" . sha1($link), 3600 * 24 * 1, function ($service) use ($params) {
            return Service::getObject($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_chp_renc.php', $params), null);
        });
    }

    public function getLicencesByName($nom, $prenom = '')
    {
        return $this->getCachedData("licences_{$nom}_{$prenom}", 3600 * 24 * 2, function ($service) use ($nom, $prenom) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_liste_joueur_o.php', array('nom' => strtoupper($nom), 'prenom' => ucfirst($prenom))), 'joueur');
        });
    }

    public function getLicencesByClub($club)
    {
        return $this->getCachedData("licencesclub_{$club}", 3600 * 24 * 2, function ($service) use ($club) {
            return Service::getCollection($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_liste_joueur_o.php', array('club' => $club)), 'joueur');
        });
    }

    public function getLicence($licence)
    {
        return $this->getCachedData("licence_{$licence}", 3600 * 24 * 2, function ($service) use ($licence) {
            return Service::getObject($service->getData('https://apiv2.fftt.com/mobile/pxml/xml_licence.php', array('licence' => $licence)), 'licence');
        });
    }

    public function getLicenceAndProgression($licence)
    {
        // Récupérer les données de la licence et du joueur en utilisant la mise en cache
        $licenceData = $this->getLicence($licence);
        $joueurData = $this->getJoueur($licence);

        // Vérifier si les deux ensembles de données ont été récupérés avec succès
        if ($licenceData && $joueurData) {
            // Fusionner les tableaux en privilégiant les données de joueur pour les clés en double
            $combinedData = array_merge($licenceData, $joueurData);
        } else {
            // Si l'une des données n'est pas disponible, retourner null
            return null;
        }

        return $combinedData;
    }

    protected function getCachedData($key, $lifeTime, $callback)
    {
        if (!$this->cache) {
            return $callback($this);
        }

        if (false === ($data = $this->cache->fetch($key))) {
            $data = $callback($this);

            if ($data !== false) {
                $this->cache->save($key, $data, $lifeTime);
            }
        }

        return $data;
    }

    public function getData($url, $params = array(), $generateHash = true)
    /**
     * Retrieves data from a specified URL.
     *
     * @param string $url The URL from which to retrieve the data.
     * @param array $params An optional array of parameters to include in the request.
     * @param bool $generateHash Whether or not to generate a hash for the request.
     * @throws Exception If there is an error in the cURL request or the HTTP response code is not 200.
     * @return string The retrieved data.
     */
    {
        if ($generateHash) {
            $params['serie'] = substr(hash('sha256', $this->getSerial()), 0, 15);
            $params['id'] = $this->getAppId();
            $params['tm'] = date('YmdHis') . substr(microtime(), 2, 3);
            $params['tmc'] = hash_hmac('sha1', $params['tm'], hash('md5', $this->getAppKey(), false));
        }

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($this->getIpSource()) {
            curl_setopt($curl, CURLOPT_INTERFACE, $this->getIpSource());
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept:", // Suprime le header par défaut de cUrl (Accept: */*)
            "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Win32)",
            "Content-Type: application/x-www-form-urlencoded",
            "Accept-Encoding: gzip",
            "Connection: Keep-Alive",
        ));

        $data = curl_exec($curl);
        // $data_info = curl_getinfo($curl);
        // print_r($data_info);
        $error = curl_error($curl); // Récupérer les éventuelles erreurs cURL
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Récupérer le code HTTP de la requête
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Suivre les redirections
        curl_close($curl);

        if ($error) {
            // En cas d'erreur cURL, afficher l'erreur
            die("Erreur cURL : " . $error);
        }

        if ($httpCode !== 200) {
            // En cas de code HTTP différent de 200, afficher le code
            die("Erreur HTTP : " . $httpCode);
        }

        $data = gzdecode($data);

        $xml = simplexml_load_string($data);

        if (!$xml) {
            // En cas d'échec du chargement XML, afficher le message d'erreur
            die("Erreur XML : Impossible de charger le XML.");
        }

        // Petite astuce pour transformer simplement le XML en tableau
        return json_decode(json_encode($xml), true);
    }



    public static function getCollection($data, $key = null)
    {
        if (empty($data)) {
            return array();
        }

        if ($key) {
            if (!array_key_exists($key, $data)) {
                return array();
            }
            $data = $data[$key];
        }

        return isset($data[0]) ? $data : array($data);
    }

    public static function getObject($data, $key = null)
    {
        if ($key && $data !== false) {
            return array_key_exists($key, $data) ? $data[$key] : null;
        } else {
            return empty($data) ? null : $data;
        }
    }

    public static function generateSerial()
    {
        $serial = '';
        for ($i = 0; $i < 15; $i++) {
            $serial .= chr(mt_rand(65, 90)); //(A-Z)
        }

        return $serial;
    }
}
