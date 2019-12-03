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
 *          Dernière MàJ :   03/12/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de construction de la liste de toutes les saisons
//       Paramètres  : none
//  Valeur de retour : none
function fctDisplaySeasonsList(){
    $arrSeasons = fct_SelectAllSeasons();       // Tableau des informations des saisons
    $intSeasons = count($arrSeasons);           // Nombre de saisons
?>
    <!-- -- -- -- -- Liste de toutes les saisons -- -- -- -- -->
        <section class="row" id="fop_seasons">
         <div class="col-xl-12" id="fopsea_title">
          <div class="row">
           <label class="col-xl-8">Toutes les saisons</label>
           <label class="col-xl-4"><?php echo $intSeasons;?></label>
          </div>
         </div>
<!-- -- -- -- -- Section : principale -- -- -- -- -->
         <section class="col-xl-8" id="fopsea_main">
<?php
    for ( $i = 1 ; $i <= $intSeasons ; $i++ ) {
        $strSeasonClass = "col-xl-4 season" . $i;
        $strBlocId = "season_bloc" . $i;
        $strLabelId = "season" . $i;
        $strListeId = "season_liste" . $i;
        $strLabelDescription = "Voir les détails de la saison " . $i;       // Attribut title du bouton de la saison
        $strWikiLink = $arrSeasons[$i]['Wiki'];                             // Lien Wikipedia
        $strWikiLabel = "Consulter Wikipedia : saison " . $i;               // Label du lien wikipédia
        $arrParagraphs = preg_split("/<br>/", $arrSeasons[$i]['Text']);     // Split de la description en paragraphes
        $intParagraphs = count($arrParagraphs);                             // Nombre de paragraphres
        $datDiffusionUsStart = new DateTime($arrSeasons[$i]['DiffusionStart']);
        $datDiffusionUsEnd = new DateTime($arrSeasons[$i]['DiffusionEnd']);
        $strDiffusionUs = $datDiffusionUsStart->format("Y") . " - " . $datDiffusionUsEnd->format("Y");
?>
<!-- -- -- -- -- Bloc : saison n°<?php echo $i;?> -- -- -- -- -->
          <article class="row" id="<?php echo $strBlocId;?>">
           <label class="<?php echo $strSeasonClass;?>" id="<?php echo $strLabelId;?>" title="<?php echo $strLabelDescription;?>">Saison&nbsp;<?php echo $i;?></label>
           <div class="offset-xl-1 col-xl-10" id="<?php echo $strListeId;?>">
            <div class="row sea_details">
             <div class="col-xl-7"></div>
             <label class="offset-xl-1 col-xl-5">Nombre d'épisodes</label>
             <div class="col-xl-6"><?php echo $arrSeasons[$i]['EpisodesNumber'];?></div>
             <div class="offset-xl-1 col-xl-1"><span class="fa fa-chalkboard-teacher fa-lg"></span></div>
             <label class="col-xl-5">US</label>
             <div class="col-xl-4"><?php echo $strDiffusionUs;?></div>
             <div class="offset-xl-1 col-xl-1"><span class="fa fa-compact-disc fa-lg"></span></div>
             <label class="col-xl-5">Sortie France</label>
             <div class="col-xl-4"><?php echo $arrSeasons[$i]['DvdFr'];?></div>
<!-- -- -- -- -- Bloc : description saison n°<?php echo $i;?> -- -- -- -- -->
             <div class="offset-xl-1 col-xl-10 sea_description">
              <div class="row">
               <label class="col-xl-12 sea_textlabel">Ce qui s'est passé...</label>
               <div class="col-xl-12">
<?php   for ( $j = 0 ; $j < $intParagraphs ; $j++ ) {
?>
<!-- -- -- -- -- Description saison <?php echo $i;?> : paragraphe <?php echo $j;?> -- -- -- -- -->
                <p class="sea_para"><?php echo $arrParagraphs[$j];?></p>
<?php   }?>
               </div>
              </div>
             </div>
             <div class="offset-xl-1 col-xl-10 sea_wikilink">
              <a href="<?php echo $strWikiLink;?>" target="_blank"><?php echo $strWikiLabel;?></a>
             </div>
            </div>
           </div>
          </article>
<?php
    }?>
<!-- -- -- -- -- Fin : section principale -- -- -- -- -->
         </section>
<!-- -- -- -- -- Section : media -- -- -- -- -->
         <section class="col-xl-4" id="fopsea_media">
          <div class="row">
           <div class="offset-xl-1 col-xl-10" id="media_picture">
            <img class="img-fluid img-thumbnail" src="../media/pics/backgrounds/start_01.gif" alt="Photo d'illustration">
           </div>
           <div class="offset-xl-1 col-xl-10" id="media_cover">
            <img class="img-fluid" src="../media/pics/backgrounds/Friends_logo_02.jpg" alt="Photo d'illustration">
           </div>
          </div>
         </section>
<!-- -- -- -- -- Fin : liste des saisons -- -- -- -- -->
        </section>
<?php
}
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
        $datDiffUsStart = new DateTime($arrSeasons[$i]['DiffusionStart']);
?>
          <article class="row" id="<?php echo $strBlocId;?>">
           <label class="<?php echo $strSeasonClass;?>" id="<?php echo $strLabelId;?>" title="<?php echo $strLabelDescription;?>">Saison&nbsp;<?php echo $i;?></label>
           <div class="offset-xl-1 col-xl-10" id="<?php echo $strListeId;?>">
            <div class="row">
             <div class="offset-xl-1 col-xl-7 timelabel">Première diffusion US</div>
             <div class="col-xl-4 timelabel"><?php echo $datDiffUsStart->format("Y");?></div>
<?php
        for ( $j = 1 ; $j <= $arrSeasons[$i]['EpisodesNumber'] ; $j++ ) {
            $strEpisodeLinkAlt = "Voir la fiche de « " . $arrEpiSeason[$j]['Title'] . " »";
            if ( $j != 1 ) {?>
             <div class="col-xl-1 epiNumber"><?php echo $j;?></div>
<?php
            } else {?>
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
          <div class="row">
           <div class="offset-xl-1 col-xl-10" id="media_picture">
            <img class="img-fluid img-thumbnail" src="../media/pics/backgrounds/start_01.gif" alt="Photo d'illustration">
           </div>
           <div class="offset-xl-1 col-xl-10" id="media_cover">
            <img class="img-fluid" src="../media/pics/backgrounds/Friends_logo_02.jpg" alt="Photo d'illustration">
           </div>
          </div>
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
    if ( $arrEpisode['Picture'] != "" ) {
        $strEpisodePicture = $arrEpisode['Picture'];
    } else {
        $strEpisodePicture = $strSeasonPicture;
    }
    $strSeasonClass = "col-xl-6 season" . $arrEpisode['Season'];
    $arrAppearances = fct_SelectAppearancesFromEpisodeById($intId);
    $intAppearances = count($arrAppearances);
    if ( $arrEpisode['Description'] != "" ) {
        $strDescription = $arrEpisode['Description'];
    } else {
        $strDescription = "Aucune description disponible.";
    }
    $arrQuestions = fct_SelectQuestionsFromEpisode($arrEpisode['Id']);
?>
<!-- -- -- -- -- -- -- - - -- -- -- -- -- -- -- -- -->
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
               <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrAppearances[$i]['Portrait'];?>" alt="<?php echo $strImgAlt;?>">
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
<!-- -- -- -- -- Liste des questions -- -- -- -- -->
<?php
    if ( is_array($arrQuestions) ) {
        $intQuestions = count($arrQuestions);
?>
          <div class="row" id="questions_bloc">
           <label for="questions_bloc" class="col-xl-12 cliste_label">Questions en rapport :&nbsp;<?php echo $intQuestions;?></label>
<?php
    for ( $i = 1 ; $i <= $intQuestions ; $i++ ) {
        $strQuestionItemId = "que_item" . $i;
        $strQuestionLevelDiv = "que_itemrow" . $i;
?>
<!-- -- -- -- -- Question n°<?php echo $i;?> -- -- -- -- -->
            <div class="col-xl-12">
             <div class="row que_item">
              <div class="col-xl-1 que_itemnum"><?php echo $i;?></div>
<!-- -- -- -- -- Niveau question n°<?php echo $i;?> -- -- -- -- -->
              <div class="col-xl-2" id="<?php echo $strQuestionLevelDiv;?>">
               <div class="row">
                <label for="<?php echo $strQuestionItemId;?>" class="col-xl-12">Niveau</label>
                <div id="<?php echo $strQuestionItemId;?>" class="col-xl-12">
                 <meter min="0" max="3" low="1" high="2" optimum="0" value="<?php echo $arrQuestions[$i]['Level'];?>"></meter>
                </div>
               </div>
              </div>
<!-- -- -- -- -- Catégorie question n°<?php echo $i;?> -- -- -- -- -->
              <div class="offset-xl-2 col-xl-5 <?php echo $arrQuestions[$i]['CatSlug'];?>"><?php echo $arrQuestions[$i]['Category'];?></div>
             </div>
            </div>
<?php
    }?>
          </div>
<?php
    } else {?>
          <div class="row" id="questions_bloc">
           <label for="charac_liste" class="col-xl-12 cliste_label">Questions en rapport</label>
           <div id="noquestion" class="offset-xl-1 col-xl-10"><?php echo $arrQuestions;?></div>
          </div>
<?php
    }?>
<!-- -- -- -- -- Section : fiche section principale -- -- -- -- -->
         </section>
<!-- -- -- -- -- Section : media -- -- -- -- -->
         <section class="col-xl-4" id="fopepi_media">
          <div class="row">
           <div class="offset-xl-1 col-xl-10">
            <img class="img-fluid" src="../media/pics/seasons/<?php echo $strEpisodePicture;?>" alt="Couverture du dvd de la saison <?php echo $arrEpisode['Season'];?>">
           </div>
          </div>
         </section>
<!-- -- -- -- -- Fin : vue 'Fiche' -- -- -- -- -->
        </section>
<?php
}