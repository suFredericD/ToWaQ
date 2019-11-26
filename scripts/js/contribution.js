/*********************************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   contribution.js
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/js/contribution.js
 *        Page référente :   pages/gameMain.php
 *                  Type :   page de script
 *              Contexte :   JavaScript
 *              Fonction :   script de dynamisation de la page de contribution
 *   Date mise en oeuvre :   25/11/2019
 *          Dernière MàJ :   25/11/2019
 *********************************************************************************************/
/* *** *** *** DECLARATIONS *** *** *** */
const arrEpiNumbers = new Array('24','24','25','24','24','25','24','24','24','18');
const intSeasons = arrEpiNumbers.length;
var intEpiNumber = 24;

const divEpiInfos = document.getElementById("epiInfos");        // Bloc des infos de l'épisode
const sltSeason = document.getElementById("season");            // Composant select : saisons

var intSelectedSeason = 1;                                      // Saison sélectionnée
var sltEpisode = document.getElementById("episode");            // Menu déroulant de sélection de l'épisode

/* *** *** *** EVENT LISTENERS *** *** *** */
sltSeason.addEventListener('change',function(){
    intSelectedSeason = sltSeason.options[sltSeason.selectedIndex].value;   // Saison sélectionnée
    intSelSeasonId = intSelectedSeason - 1;                                 // Id dans le tableau Javascript
    intEpiNumber = arrEpiNumbers[intSelSeasonId];                           // Nombre d'épisodes de la saison
    sltEpisode.innerHTML = "";                                              // Reset de la liste
    for ( i = 0 ; i < intEpiNumber ; i++ ) {
        var optToInsert = document.createElement('option');                 // Item à sélectionner
        intIndex = i + 1;
        optToInsert.className = "epiNum" + intIndex;
        optToInsert.value = intIndex;                                       // Valeur de l'éléement
        optToInsert.innerHTML = "&Eacute;pisode " + intIndex;               // Texte de l'élément
        sltEpisode.append(optToInsert);                                     // Insertion de l'élément
    }
});