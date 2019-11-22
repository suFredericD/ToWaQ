<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   partieConfig.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/partieConfig.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de cration d'une partie
 *   Date mise en oeuvre :   12/11/2019
 *          Dernière MàJ :   13/11/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/
require("../scripts/admin/variables.php");                          // Variables globales du site
require("../scripts/admin/bdd.php");                                // Gestion des accès base de donnée
require("../scripts/classes/page.php");                             // Script de définition de la classe 'Page'
require("../scripts/paging/htmlPaging.php");                        // Script de pagination html
require("../scripts/tools/calcscripts.php");                        // Scripts utilitaires (calculs divers)

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
$arrPlayers = fct_SelectAllPlayers();           // Tableau des joueurs de la base de données
$intPlayers = count($arrPlayers);               // Nombre de joueurs de la base de données
// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
     <section class="row" id="pconf_header">
      <div class="col-xl-12 col-lg-12" id="pconf_title">T<span class="fa fa-circle red"></span>o<span class="fa fa-circle blue"></span>W<span class="fa fa-circle yellow"></span>a<span class="fa fa-circle red"></span>Q</div>
      <div class="col-xl-12 col-lg-12" id="pconf_subtitle">The One Who Asks Questions</div>
     </section>
<!-- -- -- -- -- Section principale -- -- -- -- -->
     <section class="row" id="pconf_main">
<!-- -- -- -- -- Formulaire de configuration de la partie -- -- -- -- -->
      <label for="pconf_form" class="offset-xl-1 col-xl-10 col-lg-12"><h1>Configuration de la partie</h1></label>
      <form class="offset-xl-1 col-xl-10 col-lg-12" id="pconf_form" action="gameMain.php" method="post">
<!-- -- -- -- -- Sélection d'un joueur -- -- -- -- -->
       <fieldset class="form-row">
        <label for="selectPlayer" class="col-form-label col-xl-8 col-lg-8"><h2>Choississez un joueur</h2></label>
        <select class="col-form-control offset-xl-3 col-xl-5" id="selectPlayer" name="selectPlayer" required>
<?php
    for ( $i = 1 ; $i <= $intPlayers ; $i++ ) {?>
         <option value="<?php echo $arrPlayers[$i]['Id'];?>"><?php echo $arrPlayers[$i]['Pseudo'];?></option>
<?php
    }?>
        </select>
       </fieldset>
<!-- -- -- -- -- Sélection d'un type de partie -- -- -- -- -->
       <fieldset class="form-row">
        <label for="selectPartieType" class="col-form-label col-xl-8 col-lg-8"><h2>Type de partie</h2></label>
        <div class="form-check row" id="selectPartieType" name="selectPartieType">
<!-- -- -- -- -- Partie : 10 à la suite -- -- -- -- -->
         <div class="col-xl-10 optItem">
          <input type="radio" class="col-form-check-input offset-xl-1 col-xl-1 offset-lg-1 col-lg-1" id="optPartie1" name="optPartie" value="10questions" required>
          <label class="col-form-check-label col-xl-8 col-lg-8" for="optPartie1"><h3>Dix à la suite</h3><p>Répondez à une suite de 10 questions de difficulté aléatoire.</p></label>
         </div>
<!-- -- -- -- -- Partie : défi "Friends" -- -- -- -- -->
         <div class="col-xl-10 optItem">
          <input type="radio" class="col-form-check-input offset-xl-1 col-xl-1 offset-lg-1 col-lg-1" id="optPartie2" name="optPartie" value="defifriends" required>
          <label class="col-form-check-label col-xl-8 col-lg-8" for="optPartie1"><h3>Dèfi "Friends"</h3><p>Répondez à 20 questions à la suite, de difficulté progressive.</p></label>
         </div>
<!-- -- -- -- -- Partie : défi "Score" -- -- -- -- -->
         <div class="col-xl-10 optItem">
          <input type="radio" class="col-form-check-input offset-xl-1 col-xl-1 offset-lg-1 col-lg-1" id="optPartie3" name="optPartie" value="defiscore" required>
          <label class="col-form-check-label col-xl-8 col-lg-8" for="optPartie1"><h3>Dèfi "Score"</h3>
           <p>L'ultime défi : les questions sont tirées parmi tous les niveaux de difficulté.</p>
           <p>Répondez juste : marquez des points...</p>
           <p>Une mauvaise réponse : vous perdez des points...</p>
           <p>La partie est gagnée quand vous atteignez 20 points.</p>
          </label>
         </div>
        </div>
       </fieldset>
<!-- -- -- -- -- Bouton d'envoi du formulaire -- -- -- -- -->
       <fieldset class="row">
        <input type="submit" class="offset-xl-8 col-xl-3" id="launchGame" value="Jouer">
        <button class="offset-xl-1 col-xl-3"><a href="../index.php" title="Retourner à l'accueil"><span class="fa fa-arrow-alt-circle-left fa-lg"></span>&nbsp;&nbsp;Accueil</a></button>
       </fieldset>
      </form>
     </section>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>