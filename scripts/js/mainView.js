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
 *          Dernière MàJ :   03/12/2019
 *********************************************************************************************/
/* *** *** *** DECLARATIONS *** *** *** */
// Type de partie
const strPartie = document.getElementById("optPartie").getAttribute('value');
var intMaxItems = 0;
switch (strPartie){
    case "10questions":
        intMaxItems = 10;
        break;
    case "defifriends":
        intMaxItems = 20;
        break;
    case "defiscore":
        intMaxItems = 0;
}
// Blocs d'affichage des réponse
const divAnswer1 = document.getElementById("answer1");
const divAnswer2 = document.getElementById("answer2");
const divAnswer3 = document.getElementById("answer3");
const divAnswer4 = document.getElementById("answer4");
// Récupération de l'élément caché : nombre de bonnes réponses
const inpAnswerRight = document.getElementById("ansright");
// Récupération de l'élément caché : nombre de mauvaises réponses
const inpAnswerWrong = document.getElementById("answrong"); 
// Statut de la question est cours : réponse possible
var strState = "on";
// Numéro de la saison de la question courante
var intCurrentSeason = document.getElementById('seasonRow').getElementsByTagName('a')[0].innerHTML;
// Nom de la classe de la saison sélectionnée
var strSelectedSeasonClass = "season" + intCurrentSeason;
// Sélection de l'élément à modifier
var divCurrentSeason = document.getElementsByClassName(strSelectedSeasonClass)[0];
// Mise en forme de l'élément
divCurrentSeason.style.border = "4px inset #000";
divCurrentSeason.style.fontSize = "xx-large";
divCurrentSeason.style.color = "#000";
divCurrentSeason.style.textShadow = "2px 2px 4px #C1C1C1";
divCurrentSeason.style.boxShadow = "2px 2px 4px #000";

/* *** *** *** FONCTIONS *** *** *** */
//  Fonction de changement de la classe de la réponse sélectionnée
//  EvenListener        : click
//  Paramètres          :
//    divSelectedAnswer : bloc sélectionné par le joueur
//  Valeur de retour    : none
function fctFixSelection(divSelectedAnswer){
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
    // Modification des pointeurs de souris au survol
    divAnswer1.style.cursor = "not-allowed";
    divAnswer2.style.cursor = "not-allowed";
    divAnswer3.style.cursor = "not-allowed";
    divAnswer4.style.cursor = "not-allowed";
    strState = "off";           // Statut de la question est cours : réponse impossible
}
//  Fonction d'affichage du résultat
//  EvenListener        : click
//  Paramètres          :
//    divSelectedAnswer : div de la réponse sélectionnée par le joueur
//  Valeur de retour    : none
function fctSeeGoodAnswer(divSelectedAnswer){
    fctFixSelection(divSelectedAnswer);         // Changement des classes d'affichage des div de réponse
    var intScoreBonus = 0;                      // Bonus à appliquer au score après réponse
    // Récupération du score avant réponse
    var intCurrentScore = Number(document.getElementById("gameScore").innerHTML);
    // Récupération du texte de la bonne réponse
    var strGoodAnswer = document.getElementById("rightAnswer").innerHTML;
    // Récupération du texte réponse du joueur
    var strPlayerAnswer = divSelectedAnswer.innerHTML
    // Récupération de l'image à afficher après réponse
    var strPicAnswerFile = document.getElementById("picAnswer").innerHTML;
    if ( strPicAnswerFile != "" ) {
        // Sélection de l'élément à modifier
        var strAnswerPicPath = "../media/pics/askPics/" + strPicAnswerFile;
        var imgQuestionPicture = document.getElementById("imgIllustration");
        imgQuestionPicture.src = strAnswerPicPath;
    }
    // Création du bloc d'affichage des infos du résultat
    var divResponseBloc = document.createElement("div");
    divResponseBloc.id = "response_bloc";
    divResponseBloc.className = "col-xl-12";
    var rowResponseBloc = document.createElement("div");
    rowResponseBloc.className = "row";
    // Création des blocs d'affichage du résultat et du score
    var divResult = document.createElement("div");
    var divResultText = document.createElement("div");
    divResult.className = "col-xl-12";
    divResultText.className = "col-xl-12";
    // Création des paragraphes d'affichage des infos
    var paraResponseResultMsg = document.createElement("div");
    var paraResponseScore = document.createElement("div");
    var paraResponseResultText = document.createElement("div");
    paraResponseResultMsg.className = "col-xl-6";
    paraResponseResultText.id = "resultText";
    paraResponseResultText.className = "col-xl-12";
    paraResponseScore.className = "col-xl-6";
    // Controller : traitement de la réponse du joueur
    if ( strPlayerAnswer != strGoodAnswer ) {
        divResponseBloc.className = "col-xl-12 responseBad";
        paraResponseResultMsg.className += " perdu";
        paraResponseResultMsg.innerHTML = "Perdu !";
        paraResponseResultText.innerHTML = document.getElementById("badText").innerHTML;
        paraResponseScore.innerHTML = "Score + 0";
        intScoreBonus = 0;
        inpAnswerWrong.value = Number(inpAnswerWrong.value) + 1;
    } else {
        divResponseBloc.className = "col-xl-12 responseGood";
        paraResponseResultMsg.className += " bravo";
        paraResponseResultMsg.innerHTML = "Bravo !";
        paraResponseResultText.innerHTML = document.getElementById("goodText").innerHTML;
        paraResponseScore.innerHTML = "Score + 1";
        intScoreBonus = 1;
        inpAnswerRight.value = Number(inpAnswerRight.value) + 1;
    }
    // Insertion du bloc d'affichage du résultat
    divResponseBloc.appendChild(rowResponseBloc);
    rowResponseBloc.appendChild(divResult);
    rowResponseBloc.appendChild(divResultText);
    divResult.appendChild(paraResponseResultMsg);
    divResult.appendChild(paraResponseScore);
    divResultText.appendChild(paraResponseResultText);
    // Modification police du texte de la question
    var parQuestionText = document.getElementById("askText").getElementsByClassName('row')[0].getElementsByTagName('div')[0];
    parQuestionText.getElementsByTagName('p')[0].style.fontSize = "16px";
    // Insertion du bloc d'affichage du résultat complet
    document.getElementById("askText").getElementsByClassName('row')[0].append(divResponseBloc);
    // Calcul et affichage du nouveau score
    var intNewScore = intCurrentScore + intScoreBonus;
    document.getElementById("gameScore").innerHTML = intNewScore;
    // Modification du score à transmettre
    document.getElementById("score").setAttribute('value', intNewScore);
    // Création des éléments cachés pour passage des stats de la question
    var hidLevel = document.createElement("input");
    hidLevel.id = "level";
    hidLevel.name = "level";
    hidLevel.setAttribute('hidden',"");
    var hidCategory = document.createElement("input");
    hidCategory.id = "category";
    hidCategory.name = "category";
    hidCategory.setAttribute('hidden',"");
    var hidResult =  document.createElement("input");
    hidResult.id = "result";
    hidResult.name = "result";
    hidResult.setAttribute('hidden',"");
    // Récupération des valeurs à passer au formulaire
    hidLevel.setAttribute('value', document.getElementsByTagName('meter')[0].value);
    hidCategory.setAttribute('value', document.getElementById("hqCategory").innerHTML);
    if ( intScoreBonus > 0 ) {
        hidResult.setAttribute('value', "win");
    } else {
        hidResult.setAttribute('value', "loose");
    }
    // Insertion des éléments au formulaire
    document.getElementById("frmAnswer").append(hidLevel);
    document.getElementById("frmAnswer").append(hidCategory);
    document.getElementById("frmAnswer").append(hidResult);
    // Création du bouton vers la question suivante
    var btnSubmit = document.createElement("input");
    btnSubmit.type = "submit";
    if ( Number(document.getElementById("asknum").value) < Number(intMaxItems) ) {
        btnSubmit.className = "offset-xl-4 col-xl-6 nextQuestion";
        btnSubmit.value = "Question suivante     > > >";
    } else {
        btnSubmit.className = "offset-xl-2 col-xl-8 btngame_end";
        btnSubmit.value = "Partie terminée !";
        btnSubmit.setAttribute('title', "Vers l'écran de fin de partie");
    }
    
    document.getElementById("frmAnswer").prepend(btnSubmit);
}
/* *** *** *** EVENT LISTENERS *** *** *** */
var eveAnswer1 = divAnswer1.addEventListener("click", function(){
    if ( strState != "off" ) {
        fctSeeGoodAnswer(divAnswer1);
    }
});
var eveAnswer2 = divAnswer2.addEventListener("click", function(){
    if ( strState != "off" ) {
        fctSeeGoodAnswer(divAnswer2);
    }
});
var eveAnswer3 = divAnswer3.addEventListener("click", function(){
    if ( strState != "off" ) {
        fctSeeGoodAnswer(divAnswer3);
    }
});
var eveAnswer4 = divAnswer4.addEventListener("click", function(){
    if ( strState != "off" ) {
        fctSeeGoodAnswer(divAnswer4);
    }
});