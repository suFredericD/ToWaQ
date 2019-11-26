<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   sendItem.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/sendItem.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page d'envoi de la contribution d'un utilisateur
 *   Date mise en oeuvre :   25/11/2019
 *          Dernière MàJ :   26/11/2019
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
if ( $_POST['type'] === "question") {
    $arrFriend = fct_SelectOnePlayerById($_POST['friend']);
    $strFriend = $arrFriend['Pseudo'];
    $arrEpisode = fct_SelectEpisodeBySeasonAndNumber($_POST['season'], $_POST['episode']);
    $arrCategory = fct_SelectOneCategoryById($_POST['category']);
}
// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
    <section class="row" id="recap_header">
     <div class="offset-xl-1 col-xl-11">
      <p><span id="re_header">C<span class="fa fa-circle red"></span>o<span class="fa fa-circle blue"></span>n<span class="fa fa-circle yellow"></span>t<span class="fa fa-circle blue"></span>r<span class="fa fa-circle red"></span>i<span class="fa fa-circle blue"></span>b<span class="fa fa-circle yellow"></span>u<span class="fa fa-circle blue"></span>t<span class="fa fa-circle red"></span>i<span class="fa fa-circle blue"></span>o<span class="fa fa-circle yellow"></span>n<span class="fa fa-circle red"></span></span></p>
      <h1 class="col-xl-11">Nouvelle question de l'ami</h1>
      <h1 class="col-xl-11"><span><?php echo $strFriend;?></span></h1>
     </div>
    </section>
<?php
    // Controller : validation effectuée / en cours
if ( isset($_GET['validate']) ){
    $arrItem = array();
    $arrItem['0'] = $_POST['friend'];
    $arrItem['1'] = $_POST['level'];
    $arrItem['2'] = $_POST['category'];
    $arrItem['3'] = $_POST['episode'];
    $arrItem['4'] = $_POST['text'];
    $arrItem['5'] = $_POST['question'];
    $arrItem['6'] = $_POST['ansGood'];
    $arrItem['7'] = $_POST['choice1'];
    $arrItem['8'] = $_POST['choice2'];
    $arrItem['9'] = $_POST['choice3'];
    $arrItem['10'] = $_POST['msgGood'];
    $arrItem['11'] = $_POST['msgBad'];
    fct_InsertProposalQuestion($arrItem);
?>
    <section id="itemInserted" class="row">
     <label class="offset-xl-1 col-xl-10">Nouvelle contribution proposée</label>
     <h3 class="offset-xl-2 col-xl-8">Merci de participer à ToWaQ&nbsp;&nbsp;<span class="fa fa-grin-wink fa-lg"></span></h3>
     <button id="unDo" class="offset-xl-1 col-xl-3 submit">
      <a href="../index.php"><span class="fa fa-arrow-alt-circle-left fa-lg"></span>&nbsp;Accueil</a>
     </button>
     <button id="reDo" class="offset-xl-1 col-xl-6 submit">
      <a href="../index.php"><span class="fa fa-file-signature fa-lg"></span>&nbsp;Nouvelle contribution</a>
     </button>
    </section>
<?php
} else {?>
    <!-- -- -- -- -- Vue principale : formulaire d'ajout question -- -- -- -- -->
    <div class="row" id="recapInfos">
     <label for="recapInfos" class="col-xl-12">Les infos</label>
     <h2 class="col-xl-6">Saison :&nbsp;&nbsp;<span><?php echo $_POST['season'];?></span></h2>
     <h2 class="col-xl-6">&Eacute;pisode :&nbsp;&nbsp;<span><?php echo $_POST['episode'];?></span></h2>
     <h2 class="col-xl-12">" <?php echo $arrEpisode['NameFr'];?> "</h2>
     <h2 class="col-xl-3">Niveau :&nbsp;&nbsp;<span><?php echo $_POST['level'];?></span></h2>
     <h2 class="col-xl-9">Catégorie :&nbsp;&nbsp;<span><?php echo $arrCategory['Name'];?></span></h2>
    </div>
    <div class="row" id="recapQuestion">
     <label for="recapQuestion" class="col-xl-12">L'énigme</label>
     <h2 class="col-xl-4">Le contexte</h2>
     <div class="col-xl-8"><?php echo $_POST['text'];?></div>
     <h2 class="col-xl-4">La question</h2>
     <div class="col-xl-8"><?php echo $_POST['question'];?></div>
    </div>
    <div class="row" id="recapAnswers">
     <label for="recapAnswers" class="col-xl-12">Les réponses</label>
     <h2 class="col-xl-4">La bonne</h2>
     <div class="col-xl-8"><?php echo $_POST['ansGood'];?></div>
     <h2 class="col-xl-4">Le choix 1</h2>
     <div class="col-xl-8"><?php echo $_POST['choice1'];?></div>
     <h2 class="col-xl-4">Le choix 2</h2>
     <div class="col-xl-8"><?php echo $_POST['choice2'];?></div>
     <h2 class="col-xl-4">Le choix 3</h2>
     <div class="col-xl-8"><?php echo $_POST['choice3'];?></div>
    </div>
    <div class="row" id="recapMessages">
     <label for="recapMessages" class="col-xl-12">Le résultat</label>
     <h2 class="col-xl-12">Les félicitations</h2>
     <div class="offset-xl-1 col-xl-11"><?php echo $_POST['msgGood'];?></div>
     <h2 class="col-xl-12">Les vannes</h2>
     <div class="offset-xl-1 col-xl-11"><?php echo $_POST['msgBad'];?></div>
    </div>
    <form class="row" id="frmSendQuestion" action="sendItem.php?validate=ok" method="post">
     <label for="frmSendQuestion" class="col-xl-12">Validation</label>
<!-- -- -- -- Contrôleurs cachés -- -- -- -->
     <input type="text" id="type" name="type" value="<?php echo $_POST['type'];?>" hidden>
     <input type="number" id="friend" name="friend" value="<?php echo $_POST['friend'];?>" hidden>
     <input type="number" id="level" name="level" value="<?php echo $_POST['level'];?>" hidden>
     <input type="number" id="category" name="category" value="<?php echo $_POST['category'];?>" hidden>
     <input type="number" id="episode" name="episode" value="<?php echo $arrEpisode['Id'];?>" hidden>
     <input type="text" id="text" name="text" value="<?php echo $_POST['text'];?>" hidden>
     <input type="text" id="question" name="question" value="<?php echo $_POST['question'];?>" hidden>
     <input type="text" id="ansGood" name="ansGood" value="<?php echo $_POST['ansGood'];?>" hidden>
     <input type="text" id="choice1" name="choice1" value="<?php echo $_POST['choice1'];?>" hidden>
     <input type="text" id="choice2" name="choice2" value="<?php echo $_POST['choice2'];?>" hidden>
     <input type="text" id="choice3" name="choice3" value="<?php echo $_POST['choice3'];?>" hidden>
     <input type="text" id="msgGood" name="msgGood" value="<?php echo $_POST['msgGood'];?>" hidden>
     <input type="text" id="msgBad" name="msgBad" value="<?php echo $_POST['msgBad'];?>" hidden>
<!-- -- -- -- Boutons d'envoi -- -- -- -->
     <button id="unDo" class="offset-xl-1 col-xl-3 submit">
      <a href="../index.php"><span class="fa fa-arrow-alt-circle-left fa-lg"></span>&nbsp;Accueil</a>
     </button>
     <input type="submit" class="offset-xl-1 col-xl-6 submit" value="Soumettre la question">
    </form>
<?php
}
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>