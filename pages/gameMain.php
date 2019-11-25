<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   gameMain.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/gameMain.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page principale du jeu
 *   Date mise en oeuvre :   12/11/2019
 *          Dernière MàJ :   25/11/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/
require("../scripts/admin/variables.php");                          // Variables globales du site
require("../scripts/admin/bdd.php");                                // Gestion des accès base de donnée
require("../scripts/classes/page.php");                             // Script de définition de la classe 'Page'
require("../scripts/classes/game.php");                             // Script de définition de la classe 'Game'
require("../scripts/paging/htmlPaging.php");                        // Script de pagination html
require("../scripts/paging/mainView.php");                          // Vue principale
require("../scripts/paging/gameEnd.php");                           // Vue de fin de partie
require("../scripts/tools/calcscripts.php");                        // Scripts utilitaires (calculs divers)
require("../scripts/tools/selectItems.php");                        // Script de sélection des questions

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
$arrPlayers = fct_SelectAllPlayers();                       // Tableau des joueurs de la base de données
$intPlayers = count($arrPlayers);                           // Nombre de joueurs de la base de données
$arrLevels = fct_SelectAllLevels();                         // Tableau des informations des niveaux de difficulté
$intLevels = count($arrLevels);                             // Nombre de niveaux de difficulté

// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
$strPlayerName = $arrPlayers[$_POST['selectPlayer']]['Pseudo'];
// Controller : type de partie
switch ($_POST['optPartie']) {
    case $GLOBALS['str10SuiteCode']:
        $strPartie = $GLOBALS['str10SuiteName'];
        $intMaxItems = 10;
        break;
    case $GLOBALS['strFriendsBattleCode']:
        $strPartie = $GLOBALS['strFriendsBattleName'];
        $intMaxItems = 20;
        break;
    case $GLOBALS['strScoreBattleCode']:
        $strPartie = $GLOBALS['strScoreBattleName'];
        $intMaxItems = 0;
        break;
}
// Controller : nombre de questions
if ( isset($_POST['asknum'])) {
    $intAskNumber = $_POST['asknum'] + 1;
} else {
    $intAskNumber = 1;
    $intAskedItems = 0;
    fct_CreateGameTable($strPlayerName);
}
// Controller : score de la partie
if ( isset($_POST['score'])) {
    $intGameScore = $_POST['score'];
} else {
    $intGameScore = 0;
}
// Controller : ajout de l'id de la question précédente dans le tableau des id des questions à bannir
if ( isset($_POST['askid'])) {
    fct_UpdateGameTable($strPlayerName, $_POST['askid']);
}
// Controller : enregistrement des stats du joueur
if ( isset($_POST['result'])) {
    fct_UpdateStats($_POST['selectPlayer'], $_POST['result'], $_POST['level'], $_POST['category']);
}
// Model : sélection de la prochaine question
$arrAskItem = fctSelectNextQuestion($strPlayerName);
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
    <section class="row" id="game_header">
     <div class="offset-xl-1 col-xl-11">
      <p><span id="gm_header">P<span class="fa fa-circle red"></span>a<span class="fa fa-circle blue"></span>r<span class="fa fa-circle yellow"></span>t<span class="fa fa-circle blue"></span>i<span class="fa fa-circle red"></span>e en cours</span></p>
     </div>
     <div class="col-xl-3 partie-label"><h2>Joueur :</h2></div>
     <div class="col-xl-7 partie-param"><h2><?php echo $strPlayerName;?></h2></div>
     <div class="col-xl-3 partie-label"><h2>Partie :</h2></div>
     <div class="col-xl-7 partie-param"><h2><?php echo $strPartie;?></h2></div>
     <div class="col-xl-3 partie-label"><h2>Niveau :</h2></div>
     <div class="col-xl-7 partie-param"><h2><?php echo $arrLevel['Name'];?></h2></div>
    </section>
<!-- -- -- -- -- Vue principale -- -- -- -- -->
<?php
// Controller : fin de partie
if  ( $intMaxItems > 0 ) {
    if ( $intAskNumber <= $intMaxItems ){
        fctDisplayGameView($arrAskItem, $arrCategories, $strPartie, $intAskNumber,$strPlayerName, $intGameScore);
    } else {
        fctDisplayEndGame($arrCategories, $strPartie, $intAskNumber,$strPlayerName, $intGameScore);
    }
} else {
    if ( $intGameScore < 20 ) {
        fctDisplayGameView($arrAskItem, $arrCategories, $strPartie, $intAskNumber,$strPlayerName, $intGameScore);
    } else {
        fctDisplayEndGame($arrCategories, $strPartie, $intAskNumber,$strPlayerName, $intGameScore);
    }
}
?>
    <script src="../scripts/js/mainView.js"></script>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>