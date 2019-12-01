/***************************************************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   friendopedia.js
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/js/friendopedia.js
 *        Page référente :   pages/gameMain.php
 *                  Type :   page de script
 *              Contexte :   JavaScript
 *              Fonction :   script de dynamisation de la page de consultation de la base de données
 *   Date mise en oeuvre :   01/12/2019
 *          Dernière MàJ :   01/12/2019
 ***************************************************************************************************************/
/* *** *** *** DECLARATIONS *** *** *** */
const lblSeason1 = document.getElementById("season1");
const lblSeason2 = document.getElementById("season2");
const lblSeason3 = document.getElementById("season3");
const lblSeason4 = document.getElementById("season4");
const lblSeason5 = document.getElementById("season5");
const lblSeason6 = document.getElementById("season6");
const lblSeason7 = document.getElementById("season7");
const lblSeason8 = document.getElementById("season8");
const lblSeason9 = document.getElementById("season9");
const lblSeason10 = document.getElementById("season10");
const arrLabels = new Array(lblSeason1, lblSeason2, lblSeason3, lblSeason4, lblSeason5, lblSeason6, lblSeason7, lblSeason8, lblSeason9, lblSeason10);
const divSeason1 = document.getElementById("season_liste1");
const divSeason2 = document.getElementById("season_liste2");
const divSeason3 = document.getElementById("season_liste3");
const divSeason4 = document.getElementById("season_liste4");
const divSeason5 = document.getElementById("season_liste5");
const divSeason6 = document.getElementById("season_liste6");
const divSeason7 = document.getElementById("season_liste7");
const divSeason8 = document.getElementById("season_liste8");
const divSeason9 = document.getElementById("season_liste9");
const divSeason10 = document.getElementById("season_liste10");
const arrSections = new Array(divSeason1, divSeason2, divSeason3, divSeason4, divSeason5, divSeason6, divSeason7, divSeason8, divSeason9, divSeason10);
/* *** *** *** VARIABLES *** *** *** */
var arrDisplayed =  new Array(false, false, false, false, false, false, false, false, false, false);

/* *** *** *** FONCTIONS *** *** *** */
//  Fonction d'affichage de la saison sélectionnée
//  EvenListener        : click
//  Paramètres          :
//            intSeason : saison sélectionnée par le joueur
//  Valeur de retour    : none
function fctDisplayEpisodeListe(intSeason){
    for ( i = 0 ; i < arrSections.length ; i++ ) {
        if ( i != intSeason ) {
            arrSections[i].style.display = "none";
            arrDisplayed[i] = false;
        } else {
            if ( arrDisplayed[i] != true) {
                arrSections[i].style.display = "flex";
                arrDisplayed[i] = true;
            } else {
                arrSections[i].style.display = "none";
                arrDisplayed[i] = false;
            }
        }
    }
}
/* *** *** *** EVENT LISTENERS *** *** *** */
lblSeason1.addEventListener('click', function(){
    fctDisplayEpisodeListe('0');
});
lblSeason2.addEventListener('click', function(){
    fctDisplayEpisodeListe('1');
});
lblSeason3.addEventListener('click', function(){
    fctDisplayEpisodeListe('2');
});
lblSeason4.addEventListener('click', function(){
    fctDisplayEpisodeListe('3');
});
lblSeason5.addEventListener('click', function(){
    fctDisplayEpisodeListe('4');
});
lblSeason6.addEventListener('click', function(){
    fctDisplayEpisodeListe('5');
});
lblSeason7.addEventListener('click', function(){
    fctDisplayEpisodeListe('6');
});
lblSeason8.addEventListener('click', function(){
    fctDisplayEpisodeListe('7');
});
lblSeason9.addEventListener('click', function(){
    fctDisplayEpisodeListe('8');
});
lblSeason10.addEventListener('click', function(){
    fctDisplayEpisodeListe('9');
});