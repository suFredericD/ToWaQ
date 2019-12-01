<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   viewEpisodes.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/viewEpisodes.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de construction des vues 'Epiosdes'
 *   Date mise en oeuvre :   01/12/2019
 *          Dernière MàJ :   01/12/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de construction de la liste de tous les épisodes
//       Paramètres  : none
//  Valeur de retour : none
function fctDisplayEpisodeList(){
    $arrEpisodes = fct_SelectAllEpisodes();     // Tableau des informations des épisodes
    $intEpisodes = count($arrEpisodes);         // Nombre d'épisodes
    $arrSeasons = fct_SelectAllSeasons();       // Tableau des informations des saisons
    $intSeasons = count($arrSeasons);           // Nombre de saisons
?>
<!-- -- -- -- -- Liste de tous les épisodes -- -- -- -- -->
        <section class="row" id="fop_episodes">
         <div class="col-xl-12" id="fopepi_title">
          <div class="row">
           <label class="col-xl-8">Tous les épisodes</label>
           <label class="col-xl-4"><?php echo $intEpisodes;?></label>
          </div>
         </div>
<!-- -- -- -- -- Section : principale -- -- -- -- -->
         <section class="col-xl-8" id="fopepi_main">
<?php
    for ( $i = 1 ; $i <= $intSeasons ; $i++ ) {
        $arrEpiSeason = fct_SelecEpisodesFromSeason($i);        // Tableau des informations des épisodes de la saison
        $strSeasonClass = "col-xl-4 season" . $i;
        $strBlocId = "season_bloc" . $i;
        $strLabelId = "season" . $i;
        $strListeId = "season_liste" . $i;
        $strLabelDescription = "Voir la liste des épisodes";
?>
          <article class="row" id="<?php echo $strBlocId;?>">
           <label class="<?php echo $strSeasonClass;?>" id="<?php echo $strLabelId;?>" title="<?php echo $strLabelDescription;?>">Saison&nbsp;<?php echo $i;?></label>
           <div class="offset-xl-1 col-xl-10" id="<?php echo $strListeId;?>">
            <div class="row">
<?php
        for ( $j = 1 ; $j <= $arrSeasons[$i]['EpisodesNumber'] ; $j++ ) {
            $strEpisodeLinkAlt = "Voir la fiche de « " . $arrEpiSeason[$j]['Title'] . " »";
            if ( $j != 1 ) {?>
             <div class="col-xl-1 epiNumber"><?php echo $j;?></div>
<?php
            } else {?>
             <div class="col-xl-7"></div>
             <div class="col-xl-1 epiNumber"><?php echo $j;?></div>
<?php
            }?>
             <div class="col-xl-11 epiTitle">
              <a title="<?php echo $strEpisodeLinkAlt;?>"><?php echo $arrEpiSeason[$j]['Title'];?></a>
             </div>
<?php
        }?>
            </div>
           </div>
          </article>
<?php
    }?>
         </section>
<!-- -- -- -- -- Section : media -- -- -- -- -->
         <section class="col-xl-4" id="fopepi_media">
          <img class="img-fluid" src="../media/pics/backgrounds/Friends_logo_02.jpg" alt="Photo d'illustration">
         </section>
<!-- -- -- -- -- Fin : liste des épisodes -- -- -- -- -->
        </section>
<?php    
}
