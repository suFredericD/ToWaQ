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
         <label class="col-xl-8" id="fopepi_title">Tous les épisodes</label>
         <label class="col-xl-4" id="fopepi_title"><?php echo $intEpisodes;?></label>
<!-- -- -- -- -- Section : principale -- -- -- -- -->
         <section class="col-xl-8" id="fopepi_main">
<?php
    for ( $i = 1 ; $i <= $intSeasons ; $i++ ) {
        $arrEpiSeason = fct_SelecEpisodesFromSeason($i);        // Tableau des informations des épisodes de la saison
        $strSeasonClass = "col-xl-4 season" . $i;
        $strLabelId = "season" . $i;
        $strBlocId = "season_liste" . $i;
?>
         <article class="row">
          <label class="<?php echo $strSeasonClass;?>" id="<?php echo $strLabelId;?>">Saison&nbsp;<?php echo $i;?></label>
          <div class="col-xl-12" id="<?php echo $strBlocId;?>">
           <div class="row">
<?php
        for ( $j = 1 ; $j <= $arrSeasons[$i]['EpisodesNumber'] ; $j++ ) {
            
?>
            <div class="col-xl-1"><?php echo $j;?></div>
            <div class="col-xl-11"><?php echo $arrEpiSeason[$j]['Title'];?></div>
<?php
        }?>
           </div>
          </div>
         </article>
<?php
    }?>
         </section>
<!-- -- -- -- -- Section : media -- -- -- -- -->
         <section class="col-xl-8" id="fopepi_media">

         </section>
<!-- -- -- -- -- Fin : liste des épisodes -- -- -- -- -->
        </section>
<?php    
}
