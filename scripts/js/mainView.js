/*********************************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   mainView.js
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/js/mainView.js
 *        Page référente :   pages/gameMain.php
 *                  Type :   page de script
 *              Contexte :   JavaScript
 *              Fonction :   script de dynamisation de la page de jeu
 *   Date mise en oeuvre :   23/11/2019
 *          Dernière MàJ :   23/11/2019
 *********************************************************************************************/
// Numéro de la saison de la question courante
var intCurrentSeason = document.getElementById('seasonRow').getElementsByTagName('a')[0].innerHTML;
var strSelectedSeasonClass = "season" + intCurrentSeason;
var divCurrentSeason = document.getElementsByClassName(strSelectedSeasonClass)[0];

divCurrentSeason.style.border = "4px inset #000";
divCurrentSeason.style.fontSize = "xx-large";
divCurrentSeason.style.color = "#000";
divCurrentSeason.style.textShadow = "2px 2px 4px #999";







