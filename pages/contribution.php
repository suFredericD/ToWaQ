<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   contribution.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/contribution.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de contribution d'un utilisateur
 *   Date mise en oeuvre :   25/11/2019
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
switch ($_GET['type']) {
    case "question":
        $strType = "Nouvelle question";
        break;
    default:
    $strType = "unknown";
    break;
}
// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
    <section class="row" id="contrib_header">
     <div class="offset-xl-1 col-xl-11">
      <p><span id="ch_header">C<span class="fa fa-circle red"></span>o<span class="fa fa-circle blue"></span>n<span class="fa fa-circle yellow"></span>t<span class="fa fa-circle blue"></span>r<span class="fa fa-circle red"></span>i<span class="fa fa-circle blue"></span>b<span class="fa fa-circle yellow"></span>u<span class="fa fa-circle blue"></span>t<span class="fa fa-circle red"></span>i<span class="fa fa-circle blue"></span>o<span class="fa fa-circle yellow"></span>n<span class="fa fa-circle red"></span></span></p>
     </div>
     <label for="frmContribution" class="col-xl-12"><?php echo $strType;?></label>
    </section>
<!-- -- -- -- -- Vue principale : formulaire d'ajout question -- -- -- -- -->
    <form class="row" id="frmContribution" action="sendItem.php" method="post">
        <label for="friend" class="col-form-label col-xl-4">Friend</label>
        <select class="col-form-control col-xl-8" id="friend" name="friend" required>
<?php
    for ( $i = 1 ; $i <= $intPlayers ; $i++ ) {?>
         <option value="<?php echo $arrPlayers[$i]['Id'];?>"><?php echo $arrPlayers[$i]['Pseudo'];?></option>
<?php
    }?>
        </select>
<!-- -- -- -- -- Niveau de difficulté -- -- -- -- -->
        <label for="level" class="col-form-label col-xl-4">Niveau</label>
        <fieldset id="fieldlevel" class="col-form-control col-xl-8">
            <input type="radio" class="col-form-check-input col-xl-2" id="level1" name="level" value="1" required>
            <label class="col-form-check-label col-xl-8" for="level1" title="Les questions simples, générales, pour les débutants...">Facile</label>
            <input type="radio" class="col-form-check-input col-xl-2" id="level2" name="level" value="2" required>
            <label class="col-form-check-label col-xl-8" for="level2" title="Les questions un peu salées, pour les amateurs avertis...">Moyen</label>
            <input type="radio" class="col-form-check-input col-xl-2" id="level3" name="level" value="3" required>
            <label class="col-form-check-label col-xl-8" for="level3" title="Les questions hardcore, pour les vrais, les durs...">Expert</label>
        </fieldset>

        <input type="text" id="type" name="type" value="<?php echo $_GET['type'];?>" hidden>
        <input type="submit" class="offset-xl-3 col-xl-6 submit" value="Soumettre la question">
    </form>
<!-- -- -- -- -- Scripting dédié -- -- -- -- -->
    <script src="../scripts/js/contribution.js"></script>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>