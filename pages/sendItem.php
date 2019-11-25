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


// ***** ***** ***** PAGE HTML   ***** ***** *****
/* ***** ***** ***** En-tête HTML ***** ***** ***** */
fct_BuildHtmlHeader($objPageInfos);
// ***** ***** ***** Corps du contenu ***** ***** *****
print_r($_POST);
?>







<?php
/* ***** ***** ***** Footer HTML ***** ***** ***** */
fct_BuildHtmlFooter($objPageInfos);
?>