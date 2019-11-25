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
$arrCategories = fct_SelectAllCategories();                 // Tableau des catégories
$intCategories = count($arrCategories);                     // Nombre de catégories
$arrSeasons = fct_SelectAllSeasons();                       // Tableau des saisons
$intSeasons = count($arrSeasons);                           // Nombre de saisons

// Controller : type d'item à ajouter
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
       <fieldset id="newFriend" class="offset-xl-1 col-xl-10">
        <label for="friend" class="col-form-label col-xl-4">Friend</label>
        <select class="col-form-control col-xl-6" id="friend" name="friend" required>
<?php
    for ( $i = 1 ; $i <= $intPlayers ; $i++ ) {?>
         <option value="<?php echo $arrPlayers[$i]['Id'];?>"><?php echo $arrPlayers[$i]['Pseudo'];?></option>
<?php
    }?>
        </select>
       </fieldset>
<!-- -- -- -- -- Niveau de difficulté -- -- -- -- -->
        <label for="level" class="col-form-label offset-xl-1 col-xl-3" style="display:flex;justify-content:flex-end;align-items:center;">Niveau</label>
        <fieldset id="fieldlevel" class="col-form-control offset-xl-1 col-xl-5">
            <input type="radio" class="col-form-check-input col-xl-2" id="level1" name="level" value="1" required>
            <label class="col-form-check-label col-xl-8" for="level1" title="Les questions simples, générales, pour les débutants...">Facile</label>
            <input type="radio" class="col-form-check-input col-xl-2" id="level2" name="level" value="2" required>
            <label class="col-form-check-label col-xl-8" for="level2" title="Les questions un peu salées, pour les amateurs avertis...">Moyen</label>
            <input type="radio" class="col-form-check-input col-xl-2" id="level3" name="level" value="3" required>
            <label class="col-form-check-label col-xl-8" for="level3" title="Les questions hardcore, pour les vrais, les durs...">Expert</label>
        </fieldset>
<!-- -- -- -- -- Catégorie -- -- -- -- -->
        <fieldset id="newCategory" class="offset-xl-1 col-xl-10">
         <label for="category" class="col-form-label col-xl-4">Catégorie</label>
         <select class="col-form-control col-xl-6" id="category" name="category" required>
<?php
    for ( $i = 1 ; $i <= $intCategories ; $i++ ) {?>
          <option value="<?php echo $arrCategories[$i]['Id'];?>"><?php echo $arrCategories[$i]['Name'];?></option>
<?php
    }?>
         </select>
        </fieldset>
<!-- -- -- -- -- Episode -- -- -- -- -->
        <fieldset id="newEpisode" class="offset-xl-1 col-xl-10">
         <div id="epiInfos" class="col-form-row">
          <label for="epiInfos" class="col-form-label col-xl-12">&Eacute;pisode concerné</label>
          <label for="season" class="col-form-label col-xl-4">La saison</label>
          <select class="col-form-control col-xl-7" id="season" name="season" required>
<?php
    for ( $i = 1 ; $i <= $intSeasons ; $i++ ) {?>
         <option class="epiSeason<?php echo $arrSeasons[$i]['Id'];?>" value="<?php echo $arrSeasons[$i]['Id'];?>">
          Saison <?php echo $arrSeasons[$i]['Id'];?>
         </option>
<?php
    }?>
        </select>
         </div>
        </fieldset>
<!-- -- -- -- -- La question -- -- -- -- -->
        <fieldset id="newQuestion" class="offset-xl-1 col-xl-10">
         <label for="questInfos" class="col-form-label col-xl-12">Votre question et son contexte</label>
         <div id="questInfos" class="col-form-row">
          <label for="text" class="col-form-label offset-xl-1 col-xl-5">Le contexte</label>
          <textarea id="text" name="text" class="col-form-control offset-xl-1 col-xl-10 questText" rows="8" maxlength="255" placeholder="Ici, c'est pour la description concise de la situation de départ (255 caractères max.)..." required></textarea>
          <label for="question" class="col-form-label offset-xl-1 col-xl-5">La question</label>
          <textarea id="question" name="question" class="col-form-control offset-xl-1 col-xl-10 questText" rows="4" maxlength="120" placeholder="LA question elle-même (120 caractères max.)..." required></textarea>
         </div>
        </fieldset>
<!-- -- -- -- -- Les réponses -- -- -- -- -->
        <fieldset id="newAnswers" class="offset-xl-1 col-xl-10">
         <label for="ansInfos" class="col-form-label col-xl-12">Vos options de réponse</label>
          <div id="ansInfos" class="col-form-row">
           <label for="ansGood" class="col-form-label col-xl-3">La bonne</label>
           <input type="text" id="ansGood" name="ansGood" class="col-xl-8" maxlength="80" placeholder="La bonne réponse ici..." required>
           <label for="choice1" class="col-form-label col-xl-3">Choix #1</label>
           <input type="text" id="choice1" name="choice1" class="col-xl-8" maxlength="80" placeholder="La première mauvaise réponse (80 caractères max.)..." required>
           <label for="choice2" class="col-form-label col-xl-3">Choix #2</label>
           <input type="text" id="choice2" name="choice2" class="col-xl-8" maxlength="80" placeholder="La deuxième mauvaise réponse (80 caractères max.)..." required>
           <label for="choice3" class="col-form-label col-xl-3">Choix #3</label>
           <input type="text" id="choice3" name="choice3" class="col-xl-8" maxlength="80" placeholder="La troisième mauvaise réponse (80 caractères max.)..." required>
          </div>
        </fieldset>
<!-- -- -- -- -- Les messages -- -- -- -- -->
        <fieldset id="newMessages" class="offset-xl-1 col-xl-10">
         <label for="msgInfos" class="col-form-label col-xl-10">Félicitation et moquerie</label>
          <div id="msgInfos" class="col-form-row">
           <label for="msgGood" class="col-form-label col-xl-3">Bravo</label>
           <input type="text" id="msgGood" name="msgGood" class="col-xl-8" maxlength="80" placeholder="Une phrase de félicitations..." required>
           <label for="msgBad" class="col-form-label col-xl-3">Vanne</label>
           <input type="text" id="msgBad" name="msgBad" class="col-xl-8" maxlength="80" placeholder="Une vanne pour le perdant..." required>
          </div>
        </fieldset>
<!-- -- -- -- -- Les photos -- -- -- -- -->
        <fieldset id="newPictures" class="offset-xl-1 col-xl-10">
         <label for="picInfos" class="col-form-label col-xl-10">Vos photos</label>
          <div id="picInfos" class="col-form-row">

          </div>
        </fieldset>
<!-- -- -- -- -- Contrôleus cachés et bouton submit -- -- -- -- -->
        <input type="text" id="type" name="type" value="<?php echo $_GET['type'];?>" hidden>
        <input type="reset" class="offset-xl-1 col-xl-3 submit" value="Vider">
        <input type="submit" class="offset-xl-1 col-xl-6 submit" value="Soumettre la question">
    </form>
<!-- -- -- -- -- Scripting dédié -- -- -- -- -->
    <script src="../scripts/js/contribution.js"></script>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>