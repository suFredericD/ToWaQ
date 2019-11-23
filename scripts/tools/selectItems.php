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
 *          Dernière MàJ :   22/11/2019
 **************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de sélection de la prochaine question
//  Paramètres          :
//      arrAlreadyAsked : tableau des id des questions déjà posées
//  Valeur de retour    :
//            arrReturn : tableau des infos de la prochaine question
function fctSelectNextQuestion($arrAlreadyAsked){
    $arrNotAsked = fct_selectNotAskedQuestions($arrAlreadyAsked);
    $intRandomMax = count($arrNotAsked);
    $intRandomId = random_int(1, $intRandomMax);
    $arrReturn = fct_SelectOneQuestionById($intRandomId);
    return $arrReturn;
}
?>