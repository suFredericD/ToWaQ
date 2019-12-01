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
 *          Dernière MàJ :   30/11/2019
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
/***** ***** FONCTIONS DE COMPTAGE ***** *****/
// Fonction de comptage du nombre total d'épisodes dans la base
//        Paramètres : none
//  Valeur de retour :
//         intReturn : nombre total d'épisodes dans la base
function fct_CountEpisodes(){
    $strRequest = "SELECT COUNT(`epi_Id`) FROM `fri_episodes`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
}
// Fonction de comptage du nombre total de personnages dans la base
//        Paramètres : none
//  Valeur de retour :
//         intReturn : nombre total de personnages dans la base
function fct_CountCharacters(){
    $strRequest = "SELECT COUNT(`cha_Id`) FROM `fri_characters`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
}
// Fonction de comptage du nombre total d'acteurs dans la base
//        Paramètres : none
//  Valeur de retour :
//         intReturn : nombre total d'acteurs dans la base
function fct_CountActors(){
    $strRequest = "SELECT COUNT(`act_Id`) FROM `fri_Actors`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
}
// Fonction de comptage du nombre total de questions dans la base
//        Paramètres : none
//  Valeur de retour :
//         intReturn : nombre total de questions dans la base
function fct_CountQuestions(){
    $strRequest = "SELECT COUNT(`que_Id`) FROM `fri_questions`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
}
/***** ***** FONCTIONS D'UPDATE ***** *****/
// Fonction d'enregistrement des statistiques de réponse d'un joueur après une question
//       Paramètres :
//       intPlayerId : id du joueur sélectionné
//         strResult : résultat de la question
//          intLevel : niveau de la question
//       strCategory : nom de la catégorie de la question
//  Valeur de retour : none
function fct_UpdateStats($intPlayerId, $strResult, $intLevel, $strCategory){
    // Controller win or loose
    if ( $strResult != "win" ) {
        $strWinOrLoose = "B";
    } else {
        $strWinOrLoose = "G";
    }
    // Controller : catégorie
    $strRequest = "SELECT `cat_Id` FROM `fri_category` "
                . "WHERE `cat_Name`='" . $strCategory . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intCategory = $row['0'];
    // Nom du champ level à modifier
    $strFieldLevel = "pls_Level" . $intLevel . $strWinOrLoose;
    $intLevelInitValue = intval(fct_SelectStatValue($intPlayerId, $strFieldLevel)) + 1;
    // Nom du champ catégorie à modifier
    $strFieldCategory = "pls_Cat" . $intCategory . $strWinOrLoose;
    $intCatInitValue = intval(fct_SelectStatValue($intPlayerId, $strFieldCategory)) + 1;
    // Requête de modification
    $strRequest = "UPDATE `player_stats` "
                . "SET `" . $strFieldLevel . "`='" . $intLevelInitValue . "'"
                . ", `" . $strFieldCategory . "`='" . $intCatInitValue . "' "
                . "WHERE `pls_Player`='" . $intPlayerId ."';";
    fct_RequestExec($strRequest);
}
// Fonction de sélection d'une valeur de statistique d'un joueur
//       Paramètres :
//       intPlayerId : id du joueur sélectionné
//      strFieldStat : nom du champ de la statistique sélectionnée
//  Valeur de retour :
//         intReturn : valeur de la statistique du joueur
function fct_SelectStatValue($intPlayerId, $strFieldStat){
    $strRequest = "SELECT `" . $strFieldStat . "` FROM `player_stats` "
                . "WHERE `pls_Player`='" . $intPlayerId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $intReturn = $row['0'];
    return $intReturn;
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
        $arrReturn[$i]['LevelText'] = $row['17'];
        $arrReturn[$i]['Season'] = $row['19'];
        $arrReturn[$i]['EpisodeNumber'] = $row['20'];
        $arrReturn[$i]['EpisodeNameFr'] = $row['21'];
        $arrReturn[$i]['EpisodeNameUs'] = $row['22'];
        $arrReturn[$i]['EpisodeText'] = $row['23'];
        $arrReturn[$i]['EpisodePic'] = $row['24'];
        $arrReturn[$i]['Category'] = $row['26'];
        $arrReturn[$i]['CatColor'] = $row['27'];
        $arrReturn[$i]['CatUs'] = $row['28'];
        $arrReturn[$i]['CatSlug'] = $row['29'];
        $arrReturn[$i]['seaEpisodes'] = $row['31'];
        $arrReturn[$i]['seaDiffStart'] = $row['32'];
        $arrReturn[$i]['seaDiffEnd'] = $row['33'];
        $arrReturn[$i]['seaDvdFr'] = $row['34'];
        $arrReturn[$i]['seaColor'] = $row['35'];
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
    $arrReturn['LevelText'] = $row['17'];
    $arrReturn['Season'] = $row['19'];
    $arrReturn['EpisodeNumber'] = $row['20'];
    $arrReturn['EpisodeNameFr'] = $row['21'];
    $arrReturn['EpisodeNameUs'] = $row['22'];
    $arrReturn['EpisodeText'] = $row['23'];
    $arrReturn['EpisodePic'] = $row['24'];
    $arrReturn['Category'] = $row['26'];
    $arrReturn['CatColor'] = $row['27'];
    $arrReturn['CatUs'] = $row['28'];
    $arrReturn['CatSlug'] = $row['29'];
    $arrReturn['seaEpisodes'] = $row['31'];
    $arrReturn['seaDiffStart'] = $row['32'];
    $arrReturn['seaDiffEnd'] = $row['33'];
    $arrReturn['seaDvdFr'] = $row['34'];
    $arrReturn['seaColor'] = $row['35'];
    return $arrReturn;
}
// Fonction d'inserction des infos d'une proposition de question
//         Paramètre :
//           arrItem : tableaudes infos de la proposition de question
//  Valeur de retour : none
function fct_InsertProposalQuestion($arrItem){
    $strPattern = "'";
    $intItems = count($arrItem);
    for ( $i = 0 ; $i < $intItems ; $i++ ) {
        $arrItem[$i] = addcslashes($arrItem[$i], $strPattern);
    }
    $strRequest = "INSERT INTO `prop_questions` "
                     . "(`prop_Player`, `prop_Level`, `prop_Category`, `prop_Episode`, "
                     . "`prop_Text`, `prop_Question`, `prop_AnswerGood`, `prop_Answer2`, "
                     . "`prop_Answer3`, `prop_Answer4`, `prop_GoodText`, `prop_BadText`) "
                     . "VALUES ('" . $arrItem['0'] . "', '" . $arrItem['1'] . "', '" . $arrItem['2'] . "', '" . $arrItem['3'] . "', "
                     . "'" . $arrItem['4'] . "', '" . $arrItem['5'] . "', '" . $arrItem['6'] . "', "
                     . "'" . $arrItem['7'] . "', '" . $arrItem['8'] . "', '" . $arrItem['9'] . "', '" . $arrItem['10'] . "', '" . $arrItem['11'] . "');";
    fct_RequestExec($strRequest);
}
// Fonction d'extraction des infos d'une catégorie par son id
//         Paramètre :
//             intId : id de la catégorie sélectionnée
//  Valeur de retour :
//         arrReturn : tableau de la catégorie sélectionnée
function fct_SelectOneCategoryById($intId){
    $strRequest = "SELECT * FROM `fri_category` "
                . "WHERE `cat_Id`='" . $intId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Name'] = $row['1'];
    $arrReturn['Color'] = $row['2'];
    $arrReturn['NameUs'] = $row['3'];
    $arrReturn['Slug'] = $row['4'];
    return $arrReturn;
}
// Fonction d'extraction des infos d'un épisode par son numéro de saison et d'épisode
//         Paramètre :
//         intSeason : numéro de la saison sélectionnée
//  intEpisodeNumber : numéro de l'épisode
//  Valeur de retour :
//         arrReturn : tableau de l'épisode sélectionné
function fct_SelectEpisodeBySeasonAndNumber($intSeason, $intEpisodeNumber){
    $strRequest = "SELECT * FROM `fri_episodes` "
                . "WHERE `epi_Season`='" . $intSeason . "' "
                . "AND `epi_Number`='" . $intEpisodeNumber . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Season'] = $row['1'];
    $arrReturn['Number'] = $row['2'];
    $arrReturn['NameFr'] = $row['3'];
    $arrReturn['NameUs'] = $row['4'];
    $arrReturn['Description'] = $row['5'];
    $arrReturn['Picture'] = $row['6'];
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
// Fonction d'extraction des informations d'un joueur
//       Paramètres  :
//             intId : id du joueur sélectionné
//  Valeur de retour :
//         arrReturn : tableau des informations d'un joueur
function fct_SelectOnePlayerById($intId){
    $strRequest = "SELECT * FROM `fri_Players` "
                . "WHERE `pla_Id`='" . $intId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Pseudo'] = $row['1'];
    $arrReturn['FirstName'] = $row['2'];
	$arrReturn['LastName'] = $row['3'];
    $arrReturn['Mail'] = $row['4'];
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
        $arrReturn[$i]['Text'] = $row['3'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations de toutes les saisons
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations de toutes les saisons
function fct_SelectAllSeasons(){
    $strRequest = "SELECT * FROM `fri_seasons`;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['EpisodesNumber'] = $row['1'];
        $arrReturn[$i]['DiffusionStart'] = $row['2'];
        $arrReturn[$i]['DiffusionEnd'] = $row['3'];
        $arrReturn[$i]['DvdFrance'] = $row['4'];
        $arrReturn[$i]['Color'] = $row['5'];
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
    $arrReturn['Text'] = $row['3'];
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
        $arrReturn[$i]['EpisodePic'] = $row['23'];
        $arrReturn[$i]['Category'] = $row['25'];
        $arrReturn[$i]['CatColor'] = $row['26'];
        $arrReturn[$i]['CatUs'] = $row['27'];
        $arrReturn[$i]['CatSlug'] = $row['28'];
        $arrReturn[$i]['seaEpisodes'] = $row['30'];
        $arrReturn[$i]['seaDiffStart'] = $row['31'];
        $arrReturn[$i]['seaDiffEnd'] = $row['32'];
        $arrReturn[$i]['seaDvdFr'] = $row['33'];
        $arrReturn[$i]['seaColor'] = $row['34'];
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
        $arrReturn[$i]['EpisodePic'] = $row['23'];
        $arrReturn[$i]['Category'] = $row['25'];
        $arrReturn[$i]['CatColor'] = $row['26'];
        $arrReturn[$i]['CatUs'] = $row['27'];
        $arrReturn[$i]['CatSlug'] = $row['28'];
        $arrReturn[$i]['seaEpisodes'] = $row['30'];
        $arrReturn[$i]['seaDiffStart'] = $row['31'];
        $arrReturn[$i]['seaDiffEnd'] = $row['32'];
        $arrReturn[$i]['seaDvdFr'] = $row['33'];
        $arrReturn[$i]['seaColor'] = $row['34'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations de tous les acteurs
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations de tous les acteurs
function fct_SelectAllActors(){
    $strRequest = "SELECT * FROM `fri_Actors` "
                . "INNER JOIN `fri_Countries` ON `cou_Id`=`act_Country` "
                . "ORDER BY `act_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['FirstName'] = $row['1'];
        $arrReturn[$i]['LastName'] = $row['2'];
        $arrReturn[$i]['Wiki'] = $row['3'];
        $arrReturn[$i]['Portrait'] = $row['4'];
        $arrReturn[$i]['Gender'] = $row['5'];
        $arrReturn[$i]['City'] = $row['6'];
        $arrReturn[$i]['Country'] = $row['7'];
        $arrReturn[$i]['Birth'] = $row['8'];
        $arrReturn[$i]['CountryId'] = $row['9'];
        $arrReturn[$i]['CountryName'] = $row['10'];
        $arrReturn[$i]['Flag'] = $row['11'];
        $arrReturn[$i]['CountryCode'] = $row['12'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations des acteurs des 6 Friends
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations des acteurs des 6 Friends
function fct_SelectFriendsActors(){
    $strRequest = "SELECT * FROM `fri_Actors` "
                . "INNER JOIN `fri_Countries` ON `cou_Id`=`act_Country` "
                . "WHERE `act_Id` IN ('1','2','3','4','5','6') "
                . "ORDER BY `act_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['FirstName'] = $row['1'];
        $arrReturn[$i]['LastName'] = $row['2'];
        $arrReturn[$i]['Wiki'] = $row['3'];
        $arrReturn[$i]['Portrait'] = $row['4'];
        $arrReturn[$i]['Gender'] = $row['5'];
        $arrReturn[$i]['City'] = $row['6'];
        $arrReturn[$i]['Country'] = $row['7'];
        $arrReturn[$i]['Birth'] = $row['8'];
        $arrReturn[$i]['CountryId'] = $row['9'];
        $arrReturn[$i]['CountryName'] = $row['10'];
        $arrReturn[$i]['Flag'] = $row['11'];
        $arrReturn[$i]['CountryCode'] = $row['12'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations des acteurs des personnages secondaires
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des informations des acteurs des personnages secondaires
function fct_SelectOtherActors(){
    $strRequest = "SELECT * FROM `fri_Actors` "
                . "INNER JOIN `fri_Countries` ON `cou_Id`=`act_Country` "
                . "WHERE `act_Id`>'6' "
                . "ORDER BY `act_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['FirstName'] = $row['1'];
        $arrReturn[$i]['LastName'] = $row['2'];
        $arrReturn[$i]['Wiki'] = $row['3'];
        $arrReturn[$i]['Portrait'] = $row['4'];
        $arrReturn[$i]['Gender'] = $row['5'];
        $arrReturn[$i]['City'] = $row['6'];
        $arrReturn[$i]['Country'] = $row['7'];
        $arrReturn[$i]['Birth'] = $row['8'];
        $arrReturn[$i]['CountryId'] = $row['9'];
        $arrReturn[$i]['CountryName'] = $row['10'];
        $arrReturn[$i]['Flag'] = $row['11'];
        $arrReturn[$i]['CountryCode'] = $row['12'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction des informations d'un acteur par son id
//       Paramètres  :
//        intActorId : id de l'acteur sélectionné
//  Valeur de retour :
//         arrReturn : tableau des informations de l'acteur sélectionné
function fct_SelectOneActorById($intActorId){
    $strRequest = "SELECT * FROM `fri_Actors` "
                . "INNER JOIN `fri_Countries` ON `cou_Id`=`act_Country` "
                . "WHERE `act_Id`='" . $intActorId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['FirstName'] = $row['1'];
    $arrReturn['LastName'] = $row['2'];
    $arrReturn['Wiki'] = $row['3'];
    $arrReturn['Portrait'] = $row['4'];
    $arrReturn['Gender'] = $row['5'];
    $arrReturn['City'] = $row['6'];
    $arrReturn['Country'] = $row['7'];
    $arrReturn['Birth'] = $row['8'];
    $arrReturn['CountryId'] = $row['9'];
    $arrReturn['CountryName'] = $row['10'];
    $arrReturn['Flag'] = $row['11'];
    $arrReturn['CountryCode'] = $row['12'];
    return $arrReturn;
}
// Fonction d'extraction des informations d'un personnage par son id
//       Paramètres  :
//        intActorId : id du personnage sélectionné
//  Valeur de retour :
//         arrReturn : tableau des informations du personnage sélectionné
function fct_SelectCharacterById($intCharacterId){
    $strRequest = "SELECT * FROM `fri_characters` "
                . "WHERE `cha_Id`='" . $intCharacterId . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Gender'] = $row['1'];
    $arrReturn['FirstName'] = $row['2'];
    $arrReturn['LastName'] = $row['3'];
    $arrReturn['SecondName'] = $row['4'];
    $arrReturn['BirthName'] = $row['5'];
    $arrReturn['Birth'] = $row['6'];
    $arrReturn['Wiki'] = $row['7'];
    $arrReturn['ActorId'] = $row['8'];
    $arrReturn['Portrait'] = $row['9'];
    $arrReturn['Father'] = $row['10'];
    $arrReturn['Mother'] = $row['11'];
    return $arrReturn;
}
// Fonction d'extraction des informations d'un personnage par l'id de son acteur
//       Paramètres  :
//        intActorId : id de l'acteur sélectionné
//  Valeur de retour :
//         arrReturn : tableau des informations du personnage de l'acteur sélectionné
function fct_SelectCharacterByActorId($intActorId){
    if ( $intActorId > 6 ) {
        $strRequest = "SELECT * FROM `fri_characters` "
                    . "WHERE `cha_Actor`='" . $intActorId . "';";
    } else {
        $strRequest = "SELECT * FROM `fri_friends` "
                    . "WHERE `fri_Actor`='" . $intActorId . "';";
    }
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrReturn['Id'] = $row['0'];
    $arrReturn['Gender'] = $row['1'];
    $arrReturn['FirstName'] = $row['2'];
    $arrReturn['LastName'] = $row['3'];
    $arrReturn['SecondName'] = $row['4'];
    $arrReturn['BirthName'] = $row['5'];
    $arrReturn['Birth'] = $row['6'];
    $arrReturn['Wiki'] = $row['7'];
    $arrReturn['ActorId'] = $row['8'];
    $arrReturn['Portrait'] = $row['9'];
    $arrReturn['Father'] = $row['10'];
    $arrReturn['Mother'] = $row['11'];
    return $arrReturn;
}
// Fonction d'extraction des informations d'un signe astrologique en fonction d'une date de naissance
//       Paramètres  :
//          datBirth : date de naissance (objet 'DateTime')
//  Valeur de retour :
//         arrReturn : tableau des informations du signe astrologique sélectionné
function fct_FindZodiacFromBirth($datBirth){
    $strBirthMonth = $datBirth->format("m");
    $intBirthDay = intval($datBirth->format("d"));
    $strRequest = "SELECT * FROM `fri_Zodiac` "
                . "WHERE `zod_StartMonth`='" . $strBirthMonth . "';";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $row = $resLink->fetch_row();
    $arrFirstSign['Id'] = $row['0'];
    $arrFirstSign['Name'] = $row['1'];
    $arrFirstSign['StartMonth'] = $row['2'];
    $arrFirstSign['StartDay'] = $row['3'];
    $arrFirstSign['EndMonth'] = $row['4'];
    $arrFirstSign['EndDay'] = $row['5'];
    $arrFirstSign['Icon'] = $row['6'];
    if ( $intBirthDay >= intval($arrFirstSign['StartDay']) ) {
        $arrReturn = $arrFirstSign;
    } else {
        $strRequest = "SELECT * FROM `fri_Zodiac` "
                    . "WHERE `zod_EndMonth`='" . $strBirthMonth . "';";
        $resLink = fct_RequestExec($strRequest);
        $resLink->data_seek(0);
        $row = $resLink->fetch_row();
        $arrReturn['Id'] = $row['0'];
        $arrReturn['Name'] = $row['1'];
        $arrReturn['StartMonth'] = $row['2'];
        $arrReturn['StartDay'] = $row['3'];
        $arrReturn['EndMonth'] = $row['4'];
        $arrReturn['EndDay'] = $row['5'];
        $arrReturn['Icon'] = $row['6'];
    }
    return $arrReturn;
}
// Fonction d'extraction des épisodes d'apparition d'un personnage en fonction de son id
//       Paramètres  :
//             intId : id du personnage
//  Valeur de retour :
//         arrReturn : tableau des infos des épisodes où le personnage sélectionné apparaît
function fct_CheckAppearanceById($intId){
    $strRequest = "SELECT `app_Episode` FROM `fri_appearence` "
                . "WHERE `app_Character1`='" . $intId . "' "
                . "OR `app_Character2`='" . $intId . "' "
                . "OR `app_Character3`='" . $intId . "' "
                . "OR `app_Character4`='" . $intId . "' "
                . "OR `app_Character5`='" . $intId . "' "
                . "OR `app_Character6`='" . $intId . "' "
                . "OR `app_Character7`='" . $intId . "' "
                . "OR `app_Character8`='" . $intId . "' "
                . "ORDER BY `app_Episode` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrEpisodes[$i]['Id'] = $row['0'];
        $i++;
    }
    $intEpisodes = count($arrEpisodes);
    $strRequest = "SELECT * FROM `fri_episodes` "
                . "WHERE `epi_Id` IN (";
    for ( $i = 1 ; $i <= $intEpisodes ; $i++ ) {
        if ( $i < $intEpisodes ) {
            $strRequest .= "'" . $arrEpisodes[$i]['Id'] . "', ";
        } else {
            $strRequest .= "'" . $arrEpisodes[$i]['Id'] . "');";
        }
    }
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Season'] = $row['1'];
        $arrReturn[$i]['Episode'] = $row['2'];
        $arrReturn[$i]['NameFr'] = $row['3'];
        $arrReturn[$i]['NameUs'] = $row['4'];
        $arrReturn[$i]['Description'] = $row['5'];
        $arrReturn[$i]['Picture'] = $row['6'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction de tous les personnages de la base
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des infos des tous les personnages
function fct_SelectAllCharacters(){
    $strRequest = "SELECT * FROM `fri_friends` "
                . "INNER JOIN `fri_Actors` ON `act_Id`=`fri_Actor` "
                . "ORDER BY `fri_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Gender'] = $row['1'];
        $arrReturn[$i]['FirstName'] = $row['2'];
        $arrReturn[$i]['LastName'] = $row['3'];
        $arrReturn[$i]['SecondName'] = $row['4'];
        $arrReturn[$i]['BirthName'] = $row['5'];
        $arrReturn[$i]['Birth'] = $row['6'];
        $arrReturn[$i]['Wiki'] = $row['7'];
        $arrReturn[$i]['ActorId'] = $row['8'];
        $arrReturn[$i]['Portrait'] = $row['9'];
        $arrReturn[$i]['Father'] = $row['10'];
        $arrReturn[$i]['Mother'] = $row['11'];
        $arrReturn[$i]['ActorFirstName'] = $row['12'];
        $arrReturn[$i]['ActorLastName'] = $row['13'];
        $arrReturn[$i]['ActorWiki'] = $row['14'];
        $arrReturn[$i]['ActorPortrait'] = $row['15'];
        $arrReturn[$i]['City'] = $row['16'];
        $arrReturn[$i]['Country'] = $row['17'];
        $arrReturn[$i]['ActorBirth'] = $row['18'];
        $i++;
    }
    $strRequest = "SELECT * FROM `fri_characters` "
                . "INNER JOIN `fri_Actors` ON `act_Id`=`cha_Actor` "
                . "ORDER BY `cha_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Gender'] = $row['1'];
        $arrReturn[$i]['FirstName'] = $row['2'];
        $arrReturn[$i]['LastName'] = $row['3'];
        $arrReturn[$i]['SecondName'] = $row['4'];
        $arrReturn[$i]['BirthName'] = $row['5'];
        $arrReturn[$i]['Birth'] = $row['6'];
        $arrReturn[$i]['Wiki'] = $row['7'];
        $arrReturn[$i]['ActorId'] = $row['8'];
        $arrReturn[$i]['Portrait'] = $row['9'];
        $arrReturn[$i]['Father'] = $row['10'];
        $arrReturn[$i]['Mother'] = $row['11'];
        $arrReturn[$i]['ActorFirstName'] = $row['12'];
        $arrReturn[$i]['ActorLastName'] = $row['13'];
        $arrReturn[$i]['ActorWiki'] = $row['14'];
        $arrReturn[$i]['ActorPortrait'] = $row['15'];
        $arrReturn[$i]['City'] = $row['16'];
        $arrReturn[$i]['Country'] = $row['17'];
        $arrReturn[$i]['ActorBirth'] = $row['18'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction de tous les personnages principaux de la base
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des infos des tous les personnages principaux
function fct_SelectFriendsCharacters(){
    $strRequest = "SELECT * FROM `fri_friends` "
    . "INNER JOIN `fri_Actors` ON `act_Id`=`fri_Actor` "
    . "ORDER BY `fri_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Gender'] = $row['1'];
        $arrReturn[$i]['FirstName'] = $row['2'];
        $arrReturn[$i]['LastName'] = $row['3'];
        $arrReturn[$i]['SecondName'] = $row['4'];
        $arrReturn[$i]['BirthName'] = $row['5'];
        $arrReturn[$i]['Birth'] = $row['6'];
        $arrReturn[$i]['Wiki'] = $row['7'];
        $arrReturn[$i]['ActorId'] = $row['8'];
        $arrReturn[$i]['Portrait'] = $row['9'];
        $arrReturn[$i]['Father'] = $row['10'];
        $arrReturn[$i]['Mother'] = $row['11'];
        $arrReturn[$i]['ActorFirstName'] = $row['12'];
        $arrReturn[$i]['ActorLastName'] = $row['13'];
        $arrReturn[$i]['ActorWiki'] = $row['14'];
        $arrReturn[$i]['ActorPortrait'] = $row['15'];
        $arrReturn[$i]['City'] = $row['16'];
        $arrReturn[$i]['Country'] = $row['17'];
        $arrReturn[$i]['ActorBirth'] = $row['18'];
        $i++;
    }
    return $arrReturn;
}
// Fonction d'extraction de tous les personnages secondaires de la base
//       Paramètres  : none
//  Valeur de retour :
//         arrReturn : tableau des infos des tous les personnages secondaires
function fct_SelectOtherCharacters(){
    $strRequest = "SELECT * FROM `fri_characters` "
                . "INNER JOIN `fri_Actors` ON `act_Id`=`cha_Actor` "
                . "ORDER BY `cha_FirstName` ASC;";
    $resLink = fct_RequestExec($strRequest);
    $resLink->data_seek(0);
    $i = 1;
    while ($row = $resLink->fetch_row()) {
        $arrReturn[$i]['Id'] = $row['0'];
        $arrReturn[$i]['Gender'] = $row['1'];
        $arrReturn[$i]['FirstName'] = $row['2'];
        $arrReturn[$i]['LastName'] = $row['3'];
        $arrReturn[$i]['SecondName'] = $row['4'];
        $arrReturn[$i]['BirthName'] = $row['5'];
        $arrReturn[$i]['Birth'] = $row['6'];
        $arrReturn[$i]['Wiki'] = $row['7'];
        $arrReturn[$i]['ActorId'] = $row['8'];
        $arrReturn[$i]['Portrait'] = $row['9'];
        $arrReturn[$i]['Father'] = $row['10'];
        $arrReturn[$i]['Mother'] = $row['11'];
        $arrReturn[$i]['ActorFirstName'] = $row['12'];
        $arrReturn[$i]['ActorLastName'] = $row['13'];
        $arrReturn[$i]['ActorWiki'] = $row['14'];
        $arrReturn[$i]['ActorPortrait'] = $row['15'];
        $arrReturn[$i]['City'] = $row['16'];
        $arrReturn[$i]['Country'] = $row['17'];
        $arrReturn[$i]['ActorBirth'] = $row['18'];
        $i++;
    }
    return $arrReturn;
}
?>