<?php
/*******************************************************************************************
 *   EmtZahella Projetcs Incorporated
 *                Projet :   ToWaQ
 *                  Page :   variables.php
 *                Chemin :   https://127.0.0.1/ToWaQ/scripts/admin/variables.php
 *                  Type :   page de scripts
 *              Contexte :   Php 7.3
 *              Fonction :   page de définition des variables du site
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   23/11/2019
 *******************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    DECLARATIONS   ***** *****/
//  Informations auteur et site
$strAuthor = "EmtZahella";
$strCompagny = "EmtZahella Projects Incorporated";
$strSiteName = "ToWaQ";
$strKeywords = " jeux, quizz, friends, episodes, series, tv, show";
$strMainCss = "general.css";
$strBootStrapCss = "css/bootstrap.min.css";
$strBootStrapJs = "js/bootstrap.min.js";
$strAjax = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js";
$strLogoSite = "";
$strSiteIcon = "logo_icon.ico";

//  Informations arborescence du site
$strMediaPath = "media/";
$strPicturesPath = $strMediaPath . "pics/";

$strConfigPath = "config/";
$strCssPath = $strConfigPath . "css/";
$strBootStrapPath = $strCssPath . "bootstrap/";

$strScriptsPath = "scripts/";

//  Informations serveur
$strServer = $_SERVER["SERVER_SOFTWARE"];
$strServerProtocol = $_SERVER["SERVER_PROTOCOL"];
$strGateWay = $_SERVER["GATEWAY_INTERFACE"];
$strHttpHost = $_SERVER["HTTP_HOST"];

//  Informations base de données
$strHost = "127.0.0.1";
$strUser = "root";
$strPass = "sErpico33";
$strBase = "friends";

//  Informations sur le jeu
$str10SuiteName = "Dix à la suite";
$str10SuiteCode = "10questions";
$strFriendsBattleName = "Dèfi \"Friends\"";
$strFriendsBattleCode = "defifriends";
$strScoreBattleName = "Dèfi \"Score\"";
$strScoreBattleCode = "defiscore";

// Tableau des id des questions déjà posées

?>