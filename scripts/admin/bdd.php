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
 *          Dernière MàJ :   24/11/2019
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
// Fonction de création de la table temporaire d'exclusion des questions de la partie en cours
//       Paramètres :
//     strPlayerName : nom du joueur pour céer le nom de la table
//  Valeur de retour : none
function fct_CreateGameTable($strPlayerName){
    $strRequest = "DROP TABLE IF EXISTS `game_". $strPlayerName . "`;";
    fct_RequestExec($strRequest);
    $strRequest = "CREATE TABLE `game_". $strPlayerName . "`("
                . "`gam_Id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT, "
                . "`gam_Question` bigint(20) unsigned NOT NULL"
                . ", PRIMARY KEY (`gam_Id`)" 
                . ", UNIQUE KEY `gam_Question` (`gam_Question`)"
                . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    fct_RequestExec($strRequest);
}
// Fonction de création de la table temporaire de la partie en cours
//       Paramètres :
//     strPlayerName : nom du joueur pour céer le nom de la table
//     intQuestionId : id de la question à ajouter à la table d'exclusion
//  Valeur de retour : none
function fct_UpdateGameTable($strPlayerName, $intQuestionId){
    $strTable = "game_" . $strPlayerName;
    $strRequest = "INSERT INTO `" . $strTable . "` "
                . "(`gam_Question`) "
                . "VALUES('" . $intQuestionId . "');";
    fct_RequestExec($strRequest);
}
// Fonction de récupération de la table temporaire d'exclusion de la partie en cours
//       Paramètres :
//     strPlayerName : nom du joueur pour céer le nom de la table
//  Valeur de retour :
//         arrReturn : tableau des questions bannies
function fct_SelectBannedQuestions($strPlayerName){
    $strTable = "game_" . $strPlayerName;
    $strRequest = "SELECT * FROM `" . $strTable . "`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    $arrReturn = array();
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['QuestionId'] = $row['1'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des questions pas encore posées durant la partie en cours
//       Paramètres :
//   arrAlreadyAsked : tableau des id des questions déjà posées
//  Valeur de retour :
//         arrReturn : tableau des questions pas encore posées
function fct_selectNotAskedQuestions($arrAlreadyAsked){
    $intAlreadyAsked = count($arrAlreadyAsked);
    $strRequest = "SELECT * FROM `fri_questions` "
                . "INNER JOIN `fri_AskLevel` ON `asl_Id`=`que_Level` "
                . "INNER JOIN `fri_episodes` ON `epi_Id`=`que_Episode` "
                . "INNER JOIN `fri_category` ON `cat_Id`=`que_Category` "
                . "INNER JOIN `fri_seasons` ON `sea_Id`=`epi_Season`";
    if ( $intAlreadyAsked > 0 ) {
        $strRequest .= " WHERE `que_Id` NOT IN(";
        for ( $i = 1; $i <= $intAlreadyAsked ; $i++ ) {
            $strRequest .= "'".$arrAlreadyAsked[$i]['QuestionId']."'";
            if ( $i != $intAlreadyAsked ) {
                $strRequest .= ",";
            }
        }
        $strRequest .= ");";
    } else {
        $strRequest .= ";";
    }
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Level'] = $row['1'];
        $arrReturn[$i]['CategoryId'] = $row['2'];
        $arrReturn[$i]['EpisodeId'] = $row['3'];
        $arrReturn[$i]['Text'] = $row['4'];
        $arrReturn[$i]['Question'] = $row['5'];
        $arrReturn[$i]['AnswerGood'] = $row['6'];
        $arrReturn[$i]['Answer2'] = $row['7'];
        $arrReturn[$i]['Answer3'] = $row['8'];
        $arrReturn[$i]['Answer4'] = $row['9'];
        $arrReturn[$i]['GoodText'] = $row['10'];
        $arrReturn[$i]['BadText'] = $row['11'];
        $arrReturn[$i]['PictureAsk'] = $row['12'];
        $arrReturn[$i]['PictureAnswer'] = $row['13'];
        $arrReturn[$i]['LevelName'] = $row['15'];
        $arrReturn[$i]['LevelColor'] = $row['16'];
        $arrReturn[$i]['Season'] = $row['18'];
        $arrReturn[$i]['EpisodeNumber'] = $row['19'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['20'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['21'];
        $arrReturn[$i]['EpisodeText'] = $row['22'];
        $arrReturn[$i]['Category'] = $row['24'];
        $arrReturn[$i]['CatColor'] = $row['25'];
        $arrReturn[$i]['CatUs'] = $row['26'];
        $arrReturn[$i]['CatSlug'] = $row['27'];
        $arrReturn[$i]['seaEpisodes'] = $row['29'];
        $arrReturn[$i]['seaDiffStart'] = $row['30'];
        $arrReturn[$i]['seaDiffEnd'] = $row['31'];
        $arrReturn[$i]['seaDvdFr'] = $row['32'];
        $arrReturn[$i]['seaColor'] = $row['33'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction d'une question sélectionnée par son id
//         Paramètre :
//             intId : id de la question sélectionnée
//  Valeur de retour :
//         arrReturn : tableau de la question sélectionnée
function fct_SelectOneQuestionById($intId){
    $strRequest = "SELECT * FROM `fri_questions` "
                . "INNER JOIN `fri_AskLevel` ON `asl_Id`=`que_Level` "
                . "INNER JOIN `fri_episodes` ON `epi_Id`=`que_Episode` "
                . "INNER JOIN `fri_category` ON `cat_Id`=`que_Category` "
                . "INNER JOIN `fri_seasons` ON `sea_Id`=`epi_Season` "
                . "WHERE `que_Id`='" . $intId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Level'] = $row['1'];
    $arrReturn['CategoryId'] = $row['2'];
    $arrReturn['EpisodeId'] = $row['3'];
    $arrReturn['Text'] = $row['4'];
    $arrReturn['Question'] = $row['5'];
    $arrReturn['AnswerGood'] = $row['6'];
    $arrReturn['Answer2'] = $row['7'];
    $arrReturn['Answer3'] = $row['8'];
    $arrReturn['Answer4'] = $row['9'];
    $arrReturn['GoodText'] = $row['10'];
    $arrReturn['BadText'] = $row['11'];
    $arrReturn['PictureAsk'] = $row['12'];
    $arrReturn['PictureAnswer'] = $row['13'];
    $arrReturn['LevelName'] = $row['15'];
    $arrReturn['LevelColor'] = $row['16'];
    $arrReturn['Season'] = $row['18'];
    $arrReturn['EpisodeNumber'] = $row['19'];
    $arrReturn['EpisodeNameFr'] = $row['20'];
    $arrReturn['EpisodeNameUs'] = $row['21'];
    $arrReturn['EpisodeText'] = $row['22'];
    $arrReturn['Category'] = $row['24'];
    $arrReturn['CatColor'] = $row['25'];
    $arrReturn['CatUs'] = $row['26'];
    $arrReturn['CatSlug'] = $row['27'];
    $arrReturn['seaEpisodes'] = $row['29'];
    $arrReturn['seaDiffStart'] = $row['30'];
    $arrReturn['seaDiffEnd'] = $row['31'];
    $arrReturn['seaDvdFr'] = $row['32'];
    $arrReturn['seaColor'] = $row['33'];
    return $arrReturn;
}
// Fonction d'extraction de comptage de toutes les questions de la base de données
//       Paramètres  : none
//  Valeur de retour :
//         intReturn : nombre de questions de la base de données
function fct_countAllQuestions(){
    $strRequest = "SELECT COUNT(`que_Id`) FROM `fri_questions`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
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
// Fonction d'extraction de toutes les catégories de questions
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau de toutes les catégories
function fct_SelectAllCategories(){
    $strRequest = "SELECT * FROM `fri_category`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Name'] = $row['1'];
        $arrReturn[$i]['Color'] = $row['2'];
        $arrReturn[$i]['NameUs'] = $row['3'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction de toutes les questions
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau de toutes les questions
function fct_SelectAllQuestions(){
    $strRequest = "SELECT * FROM `fri_questions` "
                . "INNER JOIN `fri_AskLevel` ON `asl_Id`=`que_Level` "
                . "INNER JOIN `fri_episodes` ON `epi_Id`=`que_Episode` "
                . "INNER JOIN `fri_category` ON `cat_Id`=`que_Category` "
                . "INNER JOIN `fri_seasons` ON `sea_Id`=`epi_Season` ";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Level'] = $row['1'];
        $arrReturn[$i]['CategoryId'] = $row['2'];
        $arrReturn[$i]['EpisodeId'] = $row['3'];
        $arrReturn[$i]['Text'] = $row['4'];
        $arrReturn[$i]['Question'] = $row['5'];
        $arrReturn[$i]['AnswerGood'] = $row['6'];
        $arrReturn[$i]['Answer2'] = $row['7'];
        $arrReturn[$i]['Answer3'] = $row['8'];
        $arrReturn[$i]['Answer4'] = $row['9'];
        $arrReturn[$i]['GoodText'] = $row['10'];
        $arrReturn[$i]['BadText'] = $row['11'];
        $arrReturn[$i]['PictureAsk'] = $row['12'];
        $arrReturn[$i]['PictureAnswer'] = $row['13'];
        $arrReturn[$i]['LevelName'] = $row['15'];
        $arrReturn[$i]['LevelColor'] = $row['16'];
        $arrReturn[$i]['Season'] = $row['18'];
        $arrReturn[$i]['EpisodeNumber'] = $row['19'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['20'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['21'];
        $arrReturn[$i]['EpisodeText'] = $row['22'];
        $arrReturn[$i]['Category'] = $row['24'];
        $arrReturn[$i]['CatColor'] = $row['25'];
        $arrReturn[$i]['CatUs'] = $row['26'];
        $arrReturn[$i]['CatSlug'] = $row['27'];
        $arrReturn[$i]['seaEpisodes'] = $row['29'];
        $arrReturn[$i]['seaDiffStart'] = $row['30'];
        $arrReturn[$i]['seaDiffEnd'] = $row['31'];
        $arrReturn[$i]['seaDvdFr'] = $row['32'];
        $arrReturn[$i]['seaColor'] = $row['33'];
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
                . "INNER JOIN `fri_category` ON `cat_Id`=`que_Category` "
                . "INNER JOIN `fri_seasons` ON `sea_Id`=`epi_Season` "
                . "WHERE `que_Level`='" . $intLevel . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Level'] = $row['1'];
        $arrReturn[$i]['CategoryId'] = $row['2'];
        $arrReturn[$i]['EpisodeId'] = $row['3'];
        $arrReturn[$i]['Text'] = $row['4'];
        $arrReturn[$i]['Question'] = $row['5'];
        $arrReturn[$i]['AnswerGood'] = $row['6'];
        $arrReturn[$i]['Answer2'] = $row['7'];
        $arrReturn[$i]['Answer3'] = $row['8'];
        $arrReturn[$i]['Answer4'] = $row['9'];
        $arrReturn[$i]['GoodText'] = $row['10'];
        $arrReturn[$i]['BadText'] = $row['11'];
        $arrReturn[$i]['PictureAsk'] = $row['12'];
        $arrReturn[$i]['PictureAnswer'] = $row['13'];
        $arrReturn[$i]['LevelName'] = $row['15'];
        $arrReturn[$i]['LevelColor'] = $row['16'];
        $arrReturn[$i]['Season'] = $row['18'];
        $arrReturn[$i]['EpisodeNumber'] = $row['19'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['20'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['21'];
        $arrReturn[$i]['EpisodeText'] = $row['22'];
        $arrReturn[$i]['Category'] = $row['24'];
        $arrReturn[$i]['CatColor'] = $row['25'];
        $arrReturn[$i]['CatUs'] = $row['26'];
        $arrReturn[$i]['CatSlug'] = $row['27'];
        $arrReturn[$i]['seaEpisodes'] = $row['29'];
        $arrReturn[$i]['seaDiffStart'] = $row['30'];
        $arrReturn[$i]['seaDiffEnd'] = $row['31'];
        $arrReturn[$i]['seaDvdFr'] = $row['32'];
        $arrReturn[$i]['seaColor'] = $row['33'];
        $i++;
    }
    return $arrReturn;
}
?>