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
 *          Dernière MàJ :   01/12/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
function fctDisplayFriendOpediaMenu($strMenuIconFile){
    
?>
    <nav class="row" id="navbarMain" role="navigation">
<!-- Section Acteurs -->
     <a class="col-xl-11 rub" href="friendopedia.php?show=allactors" title="Découvrez tous les acteurs de la série">Les Acteurs</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=factors" title="Découvrez ceux qui jouent nos 'Friends'">Nos Friends</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=oactors" title="Découvrez ceux qui jouent les autres">Leurs amis</a>
<!-- Section Personnages -->
     <a class="col-xl-12 rub" href="friendopedia.php?show=allcharac" title="Retrouvez tous les personnages de la série">Les Personnages</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=friends" title="Retrouvez nos 'Friends'">Nos Friends</a>
     <a class="offset-xl-1 col-xl-10 sub" href="friendopedia.php?show=others" title="Retrouvez tous les personnages secondaires">Leurs amis</a>
     <a class="col-xl-11 rub" title="Retrouvez toutes les saisons">Les Saisons</a>
     <a class="col-xl-11 rub" href="friendopedia.php?show=episodes" title="Retrouvez tous les épisodes">Les &Eacute;pisodes</a>
    </nav>
<?php
}?>