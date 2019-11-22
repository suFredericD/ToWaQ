<?php
/*******************************************************************************************
 *   EmtZahella Projetcs Inc.
 *                Projet :   ToWaQ
 *                  Page :   paging.php
 *                Chemin :   https://127.0.0.1/ToWaQ/scripts/paging.php
 *                  Type :   page de scripts
 *              Fonction :   fonctions de calcul sur les données
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   11/11/2019
 *******************************************************************************************/
 /***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    DECLARATIONS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
//  Fonction de calcul du nombre de jours entre une date donnée en paramètre et la date actuelle
//  Paramètres  :
//		strStartTime	: date de comparaison
//  Valeur de retour    : integer
function fct_CalcNbDaysFromNow($strStartTime){
	$datStart = date_create($strStartTime);
	$datNow = new DateTime();
	$datDiff = date_diff($datStart, $datNow);
	return $datDiff->format('%a');
}