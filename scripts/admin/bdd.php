<?php
/**************************************************************************************
 *		EmtZahella Projetcs Inc.
 *                Projet :   ToWaQ
 *                  Page :   bdd.php
 *                Chemin :   https://127.0.0.1/ToWaQ/scripts/admin/bdd.php
 *                  Type :   page de scripts
 *              Contexte :   Php 7.3
 *              Fonction :   fonctions BdD
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   22/11/2019
 **************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    DECLARATIONS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction d'exécution d'une requête
//  Paramètres  :
//      strRequest      : requête à exécuter
//  Valeur de retour    : objet link
function fct_RequestExec($strRequest){
    $mysqli = new mysqli($GLOBALS['strHost'],$GLOBALS['strUser'],$GLOBALS['strPass'],$GLOBALS['strBase']);
    if ($mysqli->connect_errno){
        echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }else{
        $mysqli->query("SET NAMES 'utf8';");                // Fixation de l'encodage des caractères
        $mysqli->query("SET lc_time_names = 'fr_FR';");     // Fixation de la localisation géographique
        $resLink = $mysqli->query($strRequest);
        return $resLink;
    }
}
// Fonction d'extraction de la liste de tous les joueurs
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations de tous les joueurs
function fct_SelectAllPlayers(){
    $strRequest = "SELECT * FROM `fri_Players`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Pseudo'] = $row['1'];
        $arrReturn[$i]['FirstName'] = $row['2'];
		$arrReturn[$i]['LastName'] = $row['3'];
        $arrReturn[$i]['Mail'] = $row['4'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations de tous les niveaux de difficulté
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations de tous les niveaux de difficulté
function fct_SelectAllLevels(){
    $strRequest = "SELECT * FROM `fri_AskLevel`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Name'] = $row['1'];
        $arrReturn[$i]['Color'] = $row['2'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations d'un niveau de difficulté
//       Paramètres  :
//             intId : id du niveau concerné
//  Valeur de retour :
//         arrReturn : tableau des informations d'un niveau de difficulté
function fct_SelectLevelFromId($intId){
    $strRequest = "SELECT * FROM `fri_AskLevel` WHERE `asl_Id`='" . $intId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Name'] = $row['1'];
    $arrReturn['Color'] = $row['2'];
    return $arrReturn;
}
// Fonction d'extraction de toutes les questions
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau de toutes les questions
function fct_SelectAllQuestions(){
    $strRequest = "SELECT * FROM `fri_questions` "
    . "INNER JOIN `fri_AskLevel` ON `asl_Id`=`que_Level` "
    . "INNER JOIN `fri_episodes` ON `epi_Id`=`que_Episode`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Level'] = $row['1'];
        $arrReturn[$i]['EpisodeId'] = $row['2'];
        $arrReturn[$i]['Text'] = $row['3'];
        $arrReturn[$i]['Question'] = $row['4'];
        $arrReturn[$i]['AnswerGood'] = $row['5'];
        $arrReturn[$i]['Answer2'] = $row['6'];
        $arrReturn[$i]['Answer3'] = $row['7'];
        $arrReturn[$i]['Answer4'] = $row['8'];
        $arrReturn[$i]['GoodText'] = $row['9'];
        $arrReturn[$i]['BadText'] = $row['10'];
        $arrReturn[$i]['PictureAsk'] = $row['11'];
        $arrReturn[$i]['PictureAnswer'] = $row['12'];
        $arrReturn[$i]['LevelName'] = $row['14'];
        $arrReturn[$i]['LevelColor'] = $row['15'];
        $arrReturn[$i]['Season'] = $row['17'];
        $arrReturn[$i]['EpisodeNumber'] = $row['18'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['19'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['20'];
        $arrReturn[$i]['EpisodeText'] = $row['21'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des questions d'un niveau de difficulté
//       Paramètres  :
//             intId : id du niveau concerné
//  Valeur de retour :
//         arrReturn : tableau des questions d'un niveau de difficulté
function fct_SelectQuestionsFromLevel($intLevel){
    $strRequest = "SELECT * FROM `fri_questions` "
                . "INNER JOIN `fri_AskLevel` ON `asl_Id`=`que_Level` "
                . "INNER JOIN `fri_episodes` ON `epi_Id`=`que_Episode` "
                . "WHERE `que_Level`='" . $intLevel . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Level'] = $row['1'];
        $arrReturn[$i]['EpisodeId'] = $row['2'];
        $arrReturn[$i]['Text'] = $row['3'];
        $arrReturn[$i]['Question'] = $row['4'];
        $arrReturn[$i]['AnswerGood'] = $row['5'];
        $arrReturn[$i]['Answer2'] = $row['6'];
        $arrReturn[$i]['Answer3'] = $row['7'];
        $arrReturn[$i]['Answer4'] = $row['8'];
        $arrReturn[$i]['GoodText'] = $row['9'];
        $arrReturn[$i]['BadText'] = $row['10'];
        $arrReturn[$i]['PictureAsk'] = $row['11'];
        $arrReturn[$i]['PictureAnswer'] = $row['12'];
        $arrReturn[$i]['LevelName'] = $row['14'];
        $arrReturn[$i]['LevelColor'] = $row['15'];
        $arrReturn[$i]['Season'] = $row['17'];
        $arrReturn[$i]['EpisodeNumber'] = $row['18'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['19'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['20'];
        $arrReturn[$i]['EpisodeText'] = $row['21'];
        $i++;
    }
    return $arrReturn;
}
?>