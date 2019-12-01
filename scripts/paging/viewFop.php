<?php
/*********************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   viewFop.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/pages/viewFop.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   page de construction de la vue 'fiche'
 *   Date mise en oeuvre :   27/11/2019
 *          Dernière MàJ :   01/12/2019
 *********************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de construction de la page d'accueil de friendopedia
//       Paramètres  : none
//  Valeur de retour : none
function fctDisplayWelcome(){
    $intCharacters = fct_CountCharacters();
    $intActors = fct_CountActors();
    $intQuestions = fct_CountQuestions();
?>
<!-- -- -- -- --Friendopedia : accueil -- -- -- -- -->
    <section class="row" id="fop_accueil">
     <p class="col-xl-12" id="fopacc_title">Découvrez ou redécouvrez les secrets de Friends</p>
     <div class="col-xl-8" id="fopacc_infos">
      <div class="row">
       <p class="col-xl-12" id="fopacc_subtitle">
        Installez-vous confortablement et venez consulter l'immense mémoire de <span id="fopacc_towaq"><?php echo $GLOBALS['strTowaq'];?></span>&nbsp;:</p>
       <p class="col-xl-12">
        <ul>
         <li>les <strong>10</strong>&nbsp;saisons de la série,</li>
         <li><strong>236</strong>&nbsp;&eacute;pisodes au total,</li>
         <li><strong><?php echo $intActors;?></strong>&nbsp;acteurs au casting,</li>
         <li><strong><?php echo $intCharacters;?></strong>&nbsp;personnages secondaires,</li>
         <li><strong><?php echo $intQuestions;?></strong>&nbsp;questions pour tester vos connaissances</li>
        </ul>
       </p>
       <p class="col-xl-12">Et&nbsp;<strong>des heures</strong>&nbsp;passées avec nos amis préférés !!</p>
      </div>
     </div>
     <div class="col-xl-4" id="fopacc_img">
      <img class="img-fluid img-thumbnail" src="../media/pics/backgrounds/ohohoh.gif">
     </div>
    </section>
<?php
}
// Fonction de construction de la liste des acteurs
//       Paramètres  :
//       strTypeShow : type de liste d'acteurs sélectionnée
//  Valeur de retour : none
function fctDisplayActors($strTypeShow){
    switch ($strTypeShow){
        case "allactors":
            $arrActors = fct_SelectAllActors();
            $strMainLabel = "Tous Ceux qui jouent";
            break;
        case "factors":
            $arrActors = fct_SelectFriendsActors();
            $strMainLabel = "Ceux qui jouent nos Friends";
            break;
        case "oactors":
            $arrActors = fct_SelectOtherActors();
            $strMainLabel = "Ceux qui jouent les Autres";
            break;
    }
    $intItems = count($arrActors);
?>
<!-- -- -- -- -- Fiche : Informations -- -- -- -- -->
            <section class="row" id="fiche_title">
             <label class="col-xl-8"><?php echo $strMainLabel;?></label>
             <div class="col-xl-4"><?php echo $intItems;?> acteurs</div>
            </section>
<!-- -- -- -- -- Fiche : Articles -- -- -- -- -->
            <section class="row" id="fiche_section">
<?php
    for ( $i = 1 ; $i <= $intItems ; $i++ ) {
        $strCompleteName = $arrActors[$i]['FirstName'] . " " . $arrActors[$i]['LastName'];
        $strLinkText = "Voir la fiche de " . $strCompleteName;
        $strAltText = "Photo de " . $strCompleteName;
?>
             <div class="col-xl-4 act_cell">
              <img class="img-fluid img-thumbnail" src="../media/pics/actors/<?php echo $arrActors[$i]['Portrait'];?>" title="<?php echo $strLinkText;?>" alt="<?php echo $strAltText;?>">&nbsp;&nbsp;&nbsp;
              <a href="friendopedia.php?show=actor&item=<?php echo $arrActors[$i]['Id'];?>" title="<?php echo $strLinkText;?>"><?php echo $strCompleteName;?></a>
             </div>
<?php
    }?>
            </section>
<?php
}
// Fonction de la liste des personnages
//       Paramètres  :
//           strShow : type de liste 
//  Valeur de retour : none
function fctDisplayCharacters($strTypeShow){
    switch ($strTypeShow){
        case "allcharac":
            $arrCharacters = fct_SelectAllCharacters();
            $strMainLabel = "Tous les Friends";
            break;
        case "friends":
            $arrCharacters = fct_SelectFriendsCharacters();
            $strMainLabel = "Nos Friends";
            break;
        case "others":
            $arrCharacters = fct_SelectOtherCharacters();
            $strMainLabel = "Les Autres";
            break;
    }
    $intItems = count($arrCharacters);
?>
    <!-- -- -- -- -- Fiche : Informations -- -- -- -- -->
            <section class="row" id="fiche_title">
            <label class="col-xl-8"><?php echo $strMainLabel;?></label>
            <div class="col-xl-4"><?php echo $intItems;?> friends</div>
            </section>
<!-- -- -- -- -- Fiche : Articles -- -- -- -- -->
            <section class="row" id="fiche_section">
<?php
    for ( $i = 1 ; $i <= $intItems ; $i++ ) {
        $strCompleteName = $arrCharacters[$i]['FirstName'] . " " . $arrCharacters[$i]['LastName'];
        $strLinkText = "Voir la fiche de " . $strCompleteName;
        $strAltText = "Photo de " . $strCompleteName;
        $strFicheUrl = "friendopedia.php?show=";
        $strPortraitUrl = "../media/pics/";
        switch ($strTypeShow){
            case "allcharac":
                if ( $i > 6 ) {
                    $strFicheUrl .= "character";
                    $strPortraitUrl .= "persos/";
                } else {
                    $strFicheUrl .= "fcharac";
                    $strPortraitUrl .= "friends/";
                }
                break;
            case "friends":
                $strFicheUrl .= "fcharac";
                $strPortraitUrl .= "friends/";
                break;
            case "others":
                $strFicheUrl .= "character";
                $strPortraitUrl .= "persos/";
                break;
        }
        
        $strFicheUrl .= "&item=" . $arrCharacters[$i]['ActorId'];
        $strPortraitUrl .= $arrCharacters[$i]['Portrait'];
?>
             <div class="col-xl-4 act_cell">
              <img class="img-fluid img-thumbnail" src="<?php echo $strPortraitUrl;?>" title="<?php echo $strLinkText;?>" alt="<?php echo $strAltText;?>">&nbsp;&nbsp;&nbsp;
              <a href="<?php echo $strFicheUrl;?>" title="<?php echo $strLinkText;?>"><?php echo $strCompleteName;?></a>
             </div>
<?php
    }?>
            </section>
<?php
}
// Fonction de construction de la fiche d'un acteur par son id
//       Paramètres  :
//        intActorId : id de l'acteur sélectionné
//  Valeur de retour : none
function fctDisplayActorFile($intActorId){
    $arrActorFile = fct_SelectOneActorById($intActorId);
    $arrCharacter = fct_SelectCharacterByActorId($intActorId);
    $strActorName = $arrActorFile['FirstName'] . " " . $arrActorFile['LastName'];
    $strCharacterName = $arrCharacter['FirstName'] . " " . $arrCharacter['LastName'];
    if ( $arrActorFile['Gender'] != "M" ) {
        $strGenderLabel = "Celle qui jouait";
    } else {
        $strGenderLabel = "Celui qui jouait";
    }
    $datBirth = new DateTime($arrActorFile['Birth']);
    $strBirth = $datBirth->format("d/m/Y");
    $intyears = fct_CalcNbYearsFromNow($arrActorFile['Birth']);
    $arrZodiac = fct_FindZodiacFromBirth($datBirth);
    $strFicheCharacterMsg = "Voir la fiche de " . $arrCharacter['FirstName'];
    $strFicheCharacterUrl = "friendopedia.php?show=";
    if ( $intActorId > 6 ) {
        $strFicheCharacterUrl .= "character";
    } else {
        $strFicheCharacterUrl .= "fcharac";
    }
    $strFicheCharacterUrl .= "&item=" . $arrActorFile['Id'];
?>
<!-- -- -- -- -- Fiche : Informations -- -- -- -- -->
            <section class="row" id="fact_title">
             <div class="offset-xl-1 col-xl-1" id="fact_portrait">
              <img class="img-fluid img-thumbnail" src="../media/pics/actors/<?php echo $arrActorFile['Portrait'];?>">
             </div>
             <label class="col-xl-6"><?php echo $strActorName;?></label>
             <a class="col-xl-3" href="<?php echo $arrActorFile['Wiki'];?>" target="_blank">Son wikipedia</a>
            </section>
<!-- -- -- -- -- Fiche : Article -- -- -- -- -->
            <section class="row" id="fact_section">
<!-- -- -- -- -- Fiche : informations -- -- -- -- -->             
             <div class="col-xl-8" id="fct_infos">
              <div class="row">
               <label class="col-xl-5 subGender"><?php echo $strGenderLabel;?></label>
               <a class="col-xl-7" id="fact_characlink" href="<?php echo $strFicheCharacterUrl;?>" title="<?php echo $strFicheCharacterMsg;?>">
                <div class="row">
                 <label class="col-xl-12 subRole"><?php echo $arrCharacter['FirstName'];?></label>
                </div>
<?php
    if ( $arrCharacter['LastName'] != "" ) {?>
                <div class="row">
                 <label class="col-xl-12 subRole"><?php echo $arrCharacter['LastName'];?></label>
                </div>
<?php
    }?>
               </a>
<!-- -- -- -- -- Age actuel -- -- -- -- -->
               <div class="col-xl-3 fact_icons"><span class="fa fa-user-clock fa-2x"></span></div>
               <div class="col-xl-2 fact_age"><?php echo $intyears;?>&nbsp;ans</div>
<!-- -- -- -- -- Signe du zodiaque -- -- -- -- -->
               <div class="offset-xl-2 col-xl-1 fact_icons">
                <img class="img-fluid" src="../media/pics/zodiac/<?php echo $arrZodiac['Icon'];?>">
               </div>
               <div class="col-xl-3 fact_age"><?php echo $arrZodiac['Name'];?></div>
               <div class="col-xl-10">
<!-- -- -- -- -- Anniversaire -- -- -- -- -->
                <div class="row">
                 <div class="col-xl-3 fact_icons"><span class="fa fa-birthday-cake fa-3x"></span></div>
                 <div class="col-xl-7" id="fact_birth"><?php echo $strBirth;?></div>
                </div>
<!-- -- -- -- -- Ville de naissance -- -- -- -- -->
                <div class="row">
                 <div class="col-xl-3 fact_icons"><span class="fa fa-city fa-2x"></span></div>
                 <div class=" col-xl-7" id="fact_city"><?php echo $arrActorFile['City'];?></div>
                </div>
               </div>
<!-- -- -- -- -- Drapeau du pays de naissance -- -- -- -- -->
               <div class="col-xl-2" id="fact_flag">
                <img class="img-fluid" src="../media/pics/flags/<?php echo $arrActorFile['Flag'];?>">
               </div>
              </div>
             </div>
<!-- -- -- -- -- Fiche : grande photo -- -- -- -- -->
             <div class="col-xl-4" id="fact_bigphoto">
              <img class="img-fluid img-thumbnail" src="../media/pics/actors/<?php echo $arrActorFile['Portrait'];?>" alt="Photo de <?php echo $strActorName;?>">
             </div>
            </section>
<?php
}
// Fonction de construction de la fiche d'un personnage par son id
//       Paramètres  :
//        intActorId : id du personnage sélectionné
//  Valeur de retour : none
function fctDisplayCharacterFile($intActorId){
    $arrCharacter = fct_SelectCharacterByActorId($intActorId);
    $arrActorFile = fct_SelectOneActorById($arrCharacter['ActorId']);
    $strCharacterName = $arrCharacter['FirstName'] . " " . $arrCharacter['LastName'];
    $strActorName = $arrActorFile['FirstName'] . " " . $arrActorFile['LastName'];
    $strActorUrl = "friendopedia.php?show=actor&item=" . $arrActorFile['Id'];
    $strFicheActorMsg = "Voir la fiche de " . $strActorName;
    if ( $arrCharacter['Gender'] != "M" ) {
        $strGenderLabel = "Celle qui était joueé par";
    } else {
        $strGenderLabel = "Celui qui était joué par";
    }
    $arrAppearances = fct_CheckAppearanceById($arrCharacter['Id']);
    $intAppearances = count($arrAppearances);
    $intAppearancesLabel = $intAppearances . " épisode";
    if ( $intAppearances > 1 ) {
        $intAppearancesLabel .= "s";
    }
    $arrSeasons = fct_SelectAllSeasons();
    $intAllEpisodes = intval(fct_CountEpisodes());
    $floAppearanceRate = number_format(round(($intAppearances/$intAllEpisodes)*100, 1, PHP_ROUND_HALF_UP),1,","," ");
    $intLastSeason = $arrAppearances['1']['Season'];
    $intNumberSeasons = 1;
    for ( $i = 1 ; $i <= $intAppearances ; $i++ ) {
        $intCurrentSeason = $arrAppearances[$i]['Season'];
        if ( $intCurrentSeason != $intLastSeason ) {
            $intLastSeason = $intCurrentSeason;
            $intNumberSeasons++;
        }
    }
    $strSeasonNumbers = $intNumberSeasons . " saison";
    if ( $intNumberSeasons > 1 ) {
        $strSeasonNumbers .= "s";
    }
?>
<!-- -- -- -- -- Fiche : Informations -- -- -- -- -->
            <section class="row" id="fcha_title">
             <div class="col-xl-1" id="fcha_portrait">
              <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrCharacter['Portrait'];?>">
             </div>
             <label class="col-xl-6"><?php echo $strCharacterName;?></label>
             <button class="col-xl-5">
              <a id="fcha_actorlink" href="<?php echo $strActorUrl;?>" title="<?php echo $strFicheActorMsg;?>"><?php echo $strActorName;?></a>
             </button>
            </section>
<!-- -- -- -- -- Fiche : Article -- -- -- -- -->
            <section class="row" id="fcha_section">
<!-- -- -- -- -- Fiche : informations -- -- -- -- -->
             <div class="col-xl-8" id="fcha_infos">
              <div class="row">
               <label class="col-xl-5 subGender"><?php echo $strGenderLabel;?></label>
               <label class="col-xl-7" id="fcha_actorname"><?php echo $strActorName;?></label>
              </div>
<!-- -- -- -- -- Liste des apparitions -- -- -- -- -->
              <div class="col-xl-12" id="fcha_appearances">
               <div class="row" id="fcha_appheader">
                <label for="fcha_appearances" class="col-xl-12">Liste des apparitions</label>
                <div class="col-xl-3" id="fcha_seasonsnum"><?php echo $strSeasonNumbers;?></div>
                <div class="col-xl-7" id="fcha_episodesnum"><?php echo $intAppearancesLabel;?></div>
                <div class="col-xl-2" id="fcha_app_rate"><span class="fa fa-chart-pie"></span>&nbsp;<?php echo $floAppearanceRate;?>&nbsp;%</div>
               </div>
<?php
    for ( $i = 1 ; $i <= $intAppearances ; $i++ ) {
        $strSeasonClass = "season" . $arrAppearances[$i]['Season'];
?>
               <div class="row fcha_episodeitem">
                <div class="col-xl-1 <?php echo $strSeasonClass;?>"><?php echo $arrAppearances[$i]['Season'];?></div>
                <div class="col-xl-3 fcha_epinumber">Episode&nbsp;<?php echo $arrAppearances[$i]['Episode'];?></div>
                <div class="col-xl-8 fcha_epilabel" title="<?php echo $arrAppearances[$i]['NameUs'];?>"><?php echo $arrAppearances[$i]['NameFr'];?></div>
                </div>
<?php
    }?>
              </div>
             </div>
<!-- -- -- -- -- Fiche : grande photo -- -- -- -- -->
             <div class="col-xl-4" id="fcha_bigphoto">
              <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrCharacter['Portrait'];?>" alt="Photo de <?php echo $strCharacterName;?>">
             </div>
            </section>
<?php
}
// Fonction de construction de la fiche d'un friend par son id
//       Paramètres  :
//        intActorId : id du friend sélectionné
//  Valeur de retour : none
function fctDisplayFriendFile($intActorId){
    $arrCharacter = fct_SelectCharacterByActorId($intActorId);
    $arrActorFile = fct_SelectOneActorById($arrCharacter['ActorId']);
    // Informations du père
    $arrFather = fct_SelectCharacterById($arrCharacter['Father']);
    $strFatherName = $arrFather['FirstName'] . " ";
    if ( $arrFather['SecondName'] != "" ) {
        $strFatherName .= $arrFather['SecondName'] . " ";
    }
    $strFatherName .= $arrFather['LastName'];
    // Informations de la mère
    $arrMother = fct_SelectCharacterById($arrCharacter['Mother']);
    $strMotherName = $arrMother['FirstName'] . " ";
    if ( $arrMother['SecondName'] != "" ) {
        $strMotherName .= $arrMother['SecondName'] . " ";
    }
    $strMotherName .= $arrMother['LastName'];
    // Strings de label, url, description 
    $strCharacterName = $arrCharacter['FirstName'] . " " . $arrCharacter['LastName'];
    $strCompleteName = $arrCharacter['FirstName'] . " ";
    if ( $arrCharacter['SecondName'] != "" ) {
        $strCompleteName .= $arrCharacter['SecondName'] . " ";
    }
    $strCompleteName .= $arrCharacter['LastName'];
    // Informations de l'acteur
    $strActorName = $arrActorFile['FirstName'] . " " . $arrActorFile['LastName'];
    $strActorUrl = "friendopedia.php?show=actor&item=" . $arrActorFile['Id'];
    $strFicheActorMsg = "Voir la fiche de " . $strActorName;
    if ( $arrCharacter['Gender'] != "M" ) {
        $strGenderLabel = "Celle qui était joueé par";
    } else {
        $strGenderLabel = "Celui qui était joué par";
    }
    $datBirth = new DateTime($arrActorFile['Birth']);
    $strBirth = $datBirth->format("d/m/Y");
    $intyears = fct_CalcNbYearsFromNow($arrActorFile['Birth']);
    $arrZodiac = fct_FindZodiacFromBirth($datBirth);
    $strFicheCharacterMsg = "Voir la fiche de " . $arrCharacter['FirstName'];
?>
<!-- -- -- -- -- Fiche : Informations -- -- -- -- -->
            <section class="row" id="fcha_title">
             <div class="col-xl-1" id="fcha_portrait">
              <img class="img-fluid img-thumbnail" src="../media/pics/friends/<?php echo $arrCharacter['Portrait'];?>">
             </div>
             <label class="col-xl-6"><?php echo $strCharacterName;?></label>
             <button class="col-xl-5">
              <a id="fcha_actorlink" href="<?php echo $strActorUrl;?>" title="<?php echo $strFicheActorMsg;?>"><?php echo $strActorName;?></a>
             </button>
            </section>
<!-- -- -- -- -- Fiche : Article -- -- -- -- -->
            <section class="row" id="fcha_section">
<!-- -- -- -- -- Fiche : informations -- -- -- -- -->
             <div class="col-xl-9" id="fcha_infos">
              <div class="row">
<!-- -- -- -- -- Nom complet -- -- -- -- -->
               <div class="col-xl-3 fri_label">Nom complet</div>
               <div class="col-xl-7" id="second_name"><?php echo $strCompleteName;?></div>
<!-- -- -- -- -- Anniversaire -- -- -- -- -->
               <div class="col-xl-3 fact_icons"><span class="fa fa-birthday-cake fa-3x"></span></div>
               <div class="col-xl-7" id="fact_birth"><?php echo $strBirth;?></div>
<!-- -- -- -- -- Age actuel -- -- -- -- -->
               <div class="col-xl-3 fact_icons"><span class="fa fa-user-clock fa-2x"></span></div>
               <div class="col-xl-2 fact_age"><?php echo $intyears;?>&nbsp;ans</div>
<!-- -- -- -- -- Signe du zodiaque -- -- -- -- -->
               <div class="offset-xl-2 col-xl-1 fact_icons">
                <img class="img-fluid" src="../media/pics/zodiac/<?php echo $arrZodiac['Icon'];?>">
               </div>
               <div class="col-xl-3 fact_age"><?php echo $arrZodiac['Name'];?></div>
<!-- -- -- -- -- Père -- -- -- -- -->
               <div class="offset-xl-1 col-xl-3 fri_label">Père</div>
               <div class="col-xl-4" id="father">
                <a><?php echo $strFatherName;?></a>
               </div>
               <div class="col-xl-1">
                <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrFather['Portrait'];?>">
               </div>
<!-- -- -- -- -- Mére -- -- -- -- -->
               <div class="offset-xl-1 col-xl-3 fri_label">Mère</div>
               <div class="col-xl-4" id="mother">
                <a><?php echo $strMotherName;?></a>
               </div>
               <div class="col-xl-1">
                <img class="img-fluid img-thumbnail" src="../media/pics/persos/<?php echo $arrMother['Portrait'];?>">
               </div>
              </div>
             </div>
<!-- -- -- -- -- Fiche : grande photo -- -- -- -- -->
             <div class="col-xl-3" id="fcha_bigphoto">
              <img class="img-fluid img-thumbnail" src="../media/pics/friends/<?php echo $arrCharacter['Portrait'];?>" alt="Photo de <?php echo $strCharacterName;?>">
             </div>
            </section>
<?php
}