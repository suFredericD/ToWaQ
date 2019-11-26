<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   index.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/index.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page d'accueil
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   25/11/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/
require("scripts/admin/variables.php");                             // Variables globales du site
require("scripts/admin/bdd.php");                                   // Gestion des accès base de donnée
require("scripts/classes/page.php");                                // Script de définition de la classe 'Page'
require("scripts/paging/htmlPaging.php");                           // Script de pagination html
require("scripts/tools/calcscripts.php");                           // Scripts utilitaires (calculs divers)

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

// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
?>
<!-- -- -- -- -- Header graphique -- -- -- -- -->
     <section class="row" id="accueil_header">
      <div class="col-xl-12 col-lg-12" id="site_title">T<span class="fa fa-circle red"></span>o<span class="fa fa-circle blue"></span>W<span class="fa fa-circle yellow"></span>a<span class="fa fa-circle red"></span>Q</div>
      <div class="col-xl-12 col-lg-12" id="site_subtitle">The One Who Asks Questions</div>
     </section>
<!-- -- -- -- -- Section principale -- -- -- -- -->
     <section class="row" id="accueil_main">
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10" id="accueil_title">Welcome my&nbsp;
       <span id="acc-friends">F<span class="fa fa-circle red"></span>R<span class="fa fa-circle blue"></span>I<span class="fa fa-circle yellow"></span>E<span class="fa fa-circle red"></span>N<span class="fa fa-circle yellow"></span>D<span class="fa fa-circle blue"></span>S</span>
      </div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10"><p><b>Fan de la série ?</b> C'est ce qu'on va voir...</p></div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10"><p>Alors comme ça, on croit tout savoir à propos des <b>meilleurs amis télévisés</b> qu'on n'a jamais eu...</p></div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10"><p><b>10</b> saisons, <b>236</b> épisodes, plus d'une <b>centaine</b> de guests, au total <b>248 heures</b> d'images...</p></div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10"><p>Installez-vous confortablement, reprenez un <b>café</b>...</p></div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10"><p><b>Concentrez-vous</b> et venez affrontez :</p></div>
      <div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10">
       <p id="acc-game-label">
        <span id="acc_towaq">
         T<span class="fa fa-circle red"></span>o<span class="fa fa-circle blue"></span>W<span class="fa fa-circle yellow"></span>a<span class="fa fa-circle red"></span>Q
        </span>
        <span id="acc_towaqsub">&nbsp;:&nbsp;Celui qui pose les questions !</span>
       </p>
      </div>
     </section>
<!-- -- -- -- -- Bouton de création de partie -- -- -- -- -->
     <section class="row">
      <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8" id="acc_col_play">
       <a href="pages/partieConfig.php" title="Jouer à ToWaQ"><button>Créer une partie</button></a>
      </div>
     </section>
<!-- -- -- -- -- Liens vers : FriendOpedia -- -- -- -- -->
    <section class="row" id="accueil_friendopedia">
     <a href="pages/friendopedia.php" class="offset-xl-1 col-xl-8" title="Parcourez l'encyclopédie de ToWaQ : 'FriendOpedia'">
      Découvrir Friends avec <em>FriendOpedia</em>
     </a>
    </section>
<!-- -- -- -- -- Liens vers : contributions -- -- -- -- -->
     <section class="row" id="accueil_contrib">
      <details class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10" id="goNewQuestion">
       <summary>Apporter sa contribution</summary>
       <a href="pages/contribution.php?type=question">
        <span class="fa fa-user-edit fa-lg"></span>&nbsp;&nbsp;Proposer une question
       </a>
      </details>
     </section>
<!-- -- -- -- -- Image de fin de page -- -- -- -- -->
     <section class="row" id="accueil_footer">
     </section>
<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>