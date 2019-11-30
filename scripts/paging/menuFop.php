<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   menuFop.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/menuFop.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de construction du menu FriendOpedia
 *   Date mise en oeuvre :   26/11/2019
 *          Dernière MàJ :   30/11/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
function fctDisplayFriendOpediaMenu($strMenuIconFile){
    
?>
    <nav class="row" id="navbarMain" role="navigation">
<!-- Section Acteurs -->
     <a class="col-xl-11 rub" href="friendopedia.php?show=allactors">Les Acteurs</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=factors">Nos Friends</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=oactors">Leurs amis</a>
<!-- Section Personnages -->
     <a class="col-xl-12 rub" href="friendopedia.php?show=allcharac">Les Personnages</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=fcharac">Nos Friends</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=ocharac">Leurs amis</a>
     <a class="col-xl-11 rub">Les Saisons</a>
     <a class="col-xl-11 rub">Les &Eacute;pisodes</a>
    </nav>
<?php
}?>