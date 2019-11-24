<?php
/**************************************************************************************
 *		EmtZahella Projetcs Inc.
 *                Projet :   ToWaQ
 *                  Page :   selectItems.php
 *                Chemin :   https://127.0.0.1/ToWaQ/scripts/tools/selectItems.php
 *                  Type :   page de scripts
 *              Contexte :   Php 7.3
 *              Fonction :   fonctions de sélection des questions
 *   Date mise en oeuvre :   22/11/2019
 *          Dernière MàJ :   24/11/2019
 **************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de sélection de la prochaine question
//  Paramètres          : none
//  Valeur de retour    :
//            arrReturn : tableau des infos de la prochaine question
function fctSelectNextQuestion($strPlayerName){
    $arrAlreadyAsked = fct_SelectBannedQuestions($strPlayerName);
    $arrNotAsked = fct_selectNotAskedQuestions($arrAlreadyAsked);

    $intRandomMax = count($arrNotAsked);
    echo "intRandomMax : " . $intRandomMax."<br>";
    $intRandomId = random_int(1, $intRandomMax);
    echo "intRandomId : " . $intRandomId."<br>";
    $arrReturn = fct_SelectOneQuestionById($arrNotAsked[$intRandomId]['Id']);
    return $arrReturn;
}
?>