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
 *          Dernière MàJ :   02/12/2019
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
              <a href="friendopedia.php?show=episode&item=<?php echo $arrEpiSeason[$j]['Id'];?>" title="<?php echo $strEpisodeLinkAlt;?>"><?php echo $arrEpiSeason[$j]['Title'];?></a>
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
// Fonction de construction de la fiche d'un épisode
//       Paramètres  :
//             intId : id de l'épisode sélectionné
//  Valeur de retour : none
function fctDisplayEpisodeFiche($intId){
    $arrEpisode = fct_SelectEpisodeById($intId);
    $strSeasonPicture = "cover_" . $arrEpisode['Season'] . ".jpg";
    $strSeasonClass = "col-xl-6 season" . $arrEpisode['Season'];
    $arrAppearances = fct_SelectAppearancesFromEpisodeById($intId);
    $intAppearances = count($arrAppearances);
    if ( $arrEpisode['Description'] != "" ) {
        $strDescription = $arrEpisode['Description'];
    } else {
        $strDescription = "Aucune description disponible.";
    }
?>
<!-- -- -- -- -- Fiche de l'épisode :  -- -- -- -- -->
        <section class="row" id="fop_episode">
         <div class="col-xl-12" id="fopepi_title">
          <div class="row">
           <label class="col-xl-8"><?php echo $arrEpisode['NameFr'];?></label>
           <label class="col-xl-4">#&nbsp;<?php echo $arrEpisode['Id'];?></label>
          </div>
         </div>
<!-- -- -- -- -- Section : principale -- -- -- -- -->
         <section class="col-xl-8" id="fopepi_main">
          <div class="row">
           <div class="<?php echo $strSeasonClass;?>">Saison&nbsp;<?php echo $arrEpisode['Season'];?></div>
           <div class="col-xl-6 fepiTitle">&Eacute;pisode&nbsp;<?php echo $arrEpisode['Number'];?></div>
          </div>
<!-- -- -- -- -- Description de l'épisode -- -- -- -- -->
          <article class="row" id="epiText_bloc">
           <label for="epiText_bloc" class="col-xl-12 cliste_label">Ce qui s'est passé</label>
           <div class="offset-xl-1 col-xl-10" id="epiText">
            <p><?php echo $strDescription;?><p>
           </div>
          </article>
<?php
    if ( is_array($arrAppearances) ) {?>
<!-- -- -- -- -- Liste des apparitions -- -- -- -- -->
          <div class="row" id="characliste_bloc">
           <label for="charac_liste" class="col-xl-12 cliste_label">Ceux qui étaient invités</label>
           <div class="offset-xl-1 col-xl-10" id="charac_liste">
            <div class="row cliste">
<?php
        for ( $i = 1 ; $i <= $intAppearances ; $i++ ) {
            $strCompleteName = $arrAppearances[$i]['FirstName'] . " " . $arrAppearances[$i]['LastName'];
            $strCharacterUrl = "friendopedia.php?show=character&item=" . $arrAppearances[$i]['ActorId'];
            if ( preg_match("/^[AEIOUY]/", $arrAppearances[$i]['FirstName']) ) {
                $strImgAlt = "Photo d'" . $strCompleteName . "'";
                $strCharacterLinkText = "Voir la fiche d'" . $strCompleteName;
            } else {
                $strImgAlt = "Photo de " . $strCompleteName . "'";
                $strCharacterLinkText = "Voir la fiche de " . $strCompleteName;
            }
            
?>
            <div class="col-xl-12">
             <div class="row cliste_item">
              <div class="col-xl-2">
               <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrAppearances[$i]['Portrait'];?>" title="<?php echo $strCompleteName;?>" alt="<?php echo $strImgAlt;?>">
              </div>
              <div class="offset-xl-1 col-xl-9">
               <a href="<?php echo $strCharacterUrl;?>" title="<?php echo $strCharacterLinkText;?>"><?php echo $strCompleteName;?></a>
              </div>
             </div>
            </div>
<?php
        }?>
            </div>
           </div>
          </div>
<?php
    } else {?>
          <div class="row" id="characliste_bloc">
           <label for="charac_liste" class="col-xl-12 cliste_label">Ceux qui étaient invités</label>
           <div id="nocharac" class="offset-xl-1 col-xl-10">Pas d'invité dans cet épisode.</div>
          </div>
<?php
    }?>
         </section>
<!-- -- -- -- -- Section : media -- -- -- -- -->
         <section class="col-xl-4" id="fopepi_media">
          <img class="img-fluid" src="../media/pics/seasons/<?php echo $strSeasonPicture;?>" alt="Couverture du dvd de la saison <?php echo $arrEpisode['Season'];?>">
         </section>
<!-- -- -- -- -- Fin : liste des épisodes -- -- -- -- -->
        </section>
<?php
}