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
 *          Dernière MàJ :   24/11/2019
 *********************************************************************************************/
/* *** *** *** DECLARATIONS *** *** *** */
// ids des blocs de réponse
var divAnswer1 = document.getElementById("answer1");
var divAnswer2 = document.getElementById("answer2");
var divAnswer3 = document.getElementById("answer3");
var divAnswer4 = document.getElementById("answer4");

// Numéro de la saison de la question courante
var intCurrentSeason = document.getElementById('seasonRow').getElementsByTagName('a')[0].innerHTML;
// Nom de la classe de la saison sélectionnée
var strSelectedSeasonClass = "season" + intCurrentSeason;
// Sélection de l'élément à modifier
var divCurrentSeason = document.getElementsByClassName(strSelectedSeasonClass)[0];
// Modification de l'élément
divCurrentSeason.style.border = "4px inset #000";
divCurrentSeason.style.fontSize = "xx-large";
divCurrentSeason.style.color = "#000";
divCurrentSeason.style.textShadow = "2px 2px 4px #999";

/* *** *** *** FONCTIONS *** *** *** */
//  Fonction de changement de la classe de la réponse sélectionnée
//  EvenListener        : click
//  Paramètres          :
//  
//  Valeur de retour    : none
function fctSeeGoodAnswer(divSelectedAnswer){
    switch (divSelectedAnswer){
        case divAnswer1:
            divAnswer1.className = "col-xl-5 ansSelected";
            divAnswer2.className = "col-xl-5 ansUnselected";
            divAnswer3.className = "col-xl-5 ansUnselected";
            divAnswer4.className = "col-xl-5 ansUnselected";
            break;
        case divAnswer2:
            divAnswer1.className = "col-xl-5 ansUnselected";    
            divAnswer2.className = "col-xl-5 ansSelected";
            divAnswer3.className = "col-xl-5 ansUnselected";
            divAnswer4.className = "col-xl-5 ansUnselected";
            break;
        case divAnswer3:
            divAnswer1.className = "col-xl-5 ansUnselected";    
            divAnswer2.className = "col-xl-5 ansUnselected";
            divAnswer3.className = "col-xl-5 ansSelected";
            divAnswer4.className = "col-xl-5 ansUnselected";
            break;
        case   divAnswer4:
            divAnswer1.className = "col-xl-5 ansUnselected";    
            divAnswer2.className = "col-xl-5 ansUnselected";
            divAnswer3.className = "col-xl-5 ansUnselected";
            divAnswer4.className = "col-xl-5 ansSelected";
            break;
    }

}

/* *** *** *** EVENT LISTENERS *** *** *** */
divAnswer1.addEventListener("click", function(){fctSeeGoodAnswer(divAnswer1);});
divAnswer2.addEventListener("click", function(){fctSeeGoodAnswer(divAnswer2);});
divAnswer3.addEventListener("click", function(){fctSeeGoodAnswer(divAnswer3);});
divAnswer4.addEventListener("click", function(){fctSeeGoodAnswer(divAnswer4);});