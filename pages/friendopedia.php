<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   friendopedia.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/friendopedia.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de consultation de la base de données
 *   Date mise en oeuvre :   26/11/2019
 *          Dernière MàJ :   01/12/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/
require("../scripts/admin/variables.php");                          // Variables globales du site
require("../scripts/admin/bdd.php");                                // Gestion des accès base de donnée
require("../scripts/classes/page.php");                             // Script de définition de la classe 'Page'
require("../scripts/classes/game.php");                             // Script de définition de la classe 'Game'
require("../scripts/paging/htmlPaging.php");                        // Script de pagination html
require("../scripts/tools/calcscripts.php");                        // Scripts utilitaires (calculs divers)
require("../scripts/paging/menuFop.php");                           // Script de construction du menu
require("../scripts/paging/viewFop.php");                           // Script de construction de la vue 'fiche'
require("../scripts/paging/viewEpisodes.php");                      // Script de construction des vues 'Epiosdes'

/***** *****    DECLARATIONS   ***** *****/
$datNow = new DateTime();                                           // Timer de génération de la page (start)
$intMinInMilli = intval( ( $datNow->format("i") * 60 ) * 1000 );    // Minutes en millisecondes
$intSecInMilli = intval($datNow->format("s")*1000);                 // Secondes en millisecondes
$intMilliSec = $datNow->format("v");                                // Millisecondes
$intStartMilliSec = $intMinInMilli + $intSecInMilli + $intMilliSec; // Timer en millisecondes (start)
//***** *****   Informations de la page
if ( $_SERVER["SCRIPT_NAME"] === "/ToWaQ/index.php" ) {              // Comparaison du nom du script
	$strPathFile = $_SERVER["CONTEXT_PREFIX"]."/";                  // Affectation du path si index.php
}else{
	$strPathFile = $_SERVER["CONTEXT_PREFIX"]."/pages/";            // Affectation du path si autre fichier
}
if ( isset($_SERVER["HTTP_REFERER"]) ) {                            // Récupération de la page précédente
    $strHttpReferer = $_SERVER["HTTP_REFERER"];
}else{
    $strHttpReferer = $_SERVER["SCRIPT_NAME"];
}
$arrFileName = preg_split("/\//", $_SERVER["SCRIPT_NAME"]);         // Split du nom complet du fichier en tableau
$intFileCount = count($arrFileName)-1;                              // Position de lecture du nom de fichier seul
$strPageFile = $arrFileName[$intFileCount];                         // Nom du fichier seul
$objPageInfos = new Page();                                         // Incrémentation de l'objet 'Page'
$objPageInfos->setName($strPageFile);
//***** *****   Variables de la page ***** ***** *****
$strFriendoTitle = "F<span class=\"fa fa-circle red\"></span>"
                 . "r<span class=\"fa fa-circle blue\"></span>"
                 . "i<span class=\"fa fa-circle yellow\"></span>"
                 . "e<span class=\"fa fa-circle red\"></span>"
                 . "n<span class=\"fa fa-circle yellow\"></span>"
                 . "d<span class=\"fa fa-circle blue\"></span>"
                 . "O<span class=\"fa fa-circle red\"></span>"
                 . "p<span class=\"fa fa-circle blue\"></span>"
                 . "e<span class=\"fa fa-circle yellow\"></span>"
                 . "d<span class=\"fa fa-circle blue\"></span>"
                 . "i<span class=\"fa fa-circle red\"></span>a";
$strFriendsTitle = "F<span class=\"fa fa-circle red\"></span>"
                 . "r<span class=\"fa fa-circle blue\"></span>"
                 . "i<span class=\"fa fa-circle yellow\"></span>"
                 . "e<span class=\"fa fa-circle red\"></span>"
                 . "n<span class=\"fa fa-circle yellow\"></span>"
                 . "d<span class=\"fa fa-circle blue\"></span>s";
$strMenuIconFile = $objPageInfos->getPicturesPath().$GLOBALS['strSiteIcon'];

//***** *****   Variables issues de la base ***** ***** *****
$arrPlayers = fct_SelectAllPlayers();                       // Tableau des joueurs de la base de données
$intPlayers = count($arrPlayers);                           // Nombre de joueurs de la base de données
$arrLevels = fct_SelectAllLevels();                         // Tableau des informations des niveaux de difficulté
$intLevels = count($arrLevels);                             // Nombre de niveaux de difficulté
$arrCategories = fct_SelectAllCategories();                 // Tableau des catégories
$intCategories = count($arrCategories);                     // Nombre de catégories
$arrSeasons = fct_SelectAllSeasons();                       // Tableau des saisons
$intSeasons = count($arrSeasons);                           // Nombre de saisons

// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
    <section class="row" id="friendop_header">
     <div class="offset-xl-1 col-xl-10">
      <p><span id="fop_header"><?php echo $strFriendoTitle;?></span></p>
      <div id="fop_subtitle">L'encyclopédie de</div>
      <p><?php echo $strFriendsTitle;?></p>
     </div>
    </section>
<?php
//***** *****   Controllers ***** ***** *****
?>
<!-- -- -- -- -- Vue principale -- -- -- -- -->
    <section class="row" id="friendop_container">
     <a id="haut" href="#" hidden></a><!-- Ancre pour les liens back-to-top -->
<!-- -- -- -- -- Menu : section gauche -- -- -- -- -->
        <aside class="col-xl-2" id="friendop_menu">
         <a href="friendopedia.php" id="fop_acclink" title="Retour à l'accueil de FriendOpedia">
          <label class="row"><?php echo $strFriendoTitle;?></label>
         </a>
<?php fctDisplayFriendOpediaMenu($strMenuIconFile);?>
        </aside>
<!-- -- -- -- -- Fiche : section droite -- -- -- -- -->
        <section class="col-xl-10" id="friendop_main">
<?php
// Controller : redirection d'affichage
if ( preg_match("/actors$/", $_GET['show']) ) {             // Liste de tous les acteurs
    fctDisplayActors($_GET['show']);
} elseif (preg_match("/actor$/", $_GET['show'])) {          // Fiches individuelles des acteurs
    fctDisplayActorFile($_GET['item']);
} elseif ( preg_match("/character$/", $_GET['show']) ) {    // Fiches individuelles des personnages secondaires
    fctDisplayCharacterFile($_GET['item']);
} elseif ( preg_match("/fcharac$/", $_GET['show']) ) {      // Fiches individuelles des Friends
    fctDisplayFriendFile($_GET['item']);
} elseif ( !isset($_GET['show']) ) {                        // Page d'accueil
    fctDisplayWelcome();
} elseif (preg_match("/episodes$/", $_GET['show'])) {       // Liste de tous les épisodes
    fctDisplayEpisodeList();
} else {                                                    // Liste des personnages
    fctDisplayCharacters($_GET['show']);
}
?>
<!-- -- -- -- -- Fin : vue principale -- -- -- -- -->
        </section>
<!-- -- -- -- -- Bouton : Retour à l'accueil -- -- -- -- -->
<div class="col-xl-12">
      <a href="../index.php" title="Retour à l'accueil de ToWaQ">
       <button><span class="fa fa-arrow-circle-left"></span>&nbsp;Accueil</button>
      </a>
     </div>
<!-- -- -- -- -- Fin : page -- -- -- -- -->
    </section>
<!-- -- -- -- -- Scripting dédié -- -- -- -- -->
    <script src="../scripts/js/friendopedia.js"></script>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>