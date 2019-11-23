<?php
/*************************************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   mainView.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/paging/mainView.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   vue principale du jeu
 *   Date mise en oeuvre :   22/11/2019
 *          Dernière MàJ :   23/11/2019
 *************************************************************************************************/

// Fonction d'extraction de toutes les questions
//       Paramètres  :
//      arrQuestions : tableau de toutes les questions
//     arrCategories : tableau de toutes les catégories
//         strPartie : type de partie
//      intAskNumber : numéro de la question en cours dans la liste des questions de la partie
//     strPlayerName : nom du joueur
//  Valeur de retour : none
function fctDisplayGameView($arrQuestion, $arrCategories, $strPartie, $intAskNumber, $strPlayerName){
    $intCategories = count($arrCategories);
    $intNextAsk = $intAskNumber + 1;
    switch ($strPartie) {      // Controller : type de partie
        case $GLOBALS['str10SuiteName']:
            $intProgAim = 10;
            break;
        case $GLOBALS['strFriendsBattleName']:
            $intProgAim = 20;
            break;
        case $GLOBALS['strScoreBattleName']:
            $intProgAim = 20;
            break;
    }
    if ( isset($_POST['score']) ) {
        $intScore = $_POST['score'];
    } else {
        $intScore = 0;
    }
    $strSeasonBgClass = "season".$arrQuestion['Season'];
?>
    <section id="mainView">

<!-- -- -- -- Section Hud -- -- -- -->
        <section id="secHud" class="row">
<!-- -- -- -- Bloc 'question' -- -- -- -->
            <article id="hudQuestion" class="col-xl-6">
<!-- -- -- -- Numéro de la question -- -- -- -->
                <div class="row">
                    <label for="hqNumber" id="hqNumLabel" class="col-xl-5">Question</label>
                    <div id="hqNumber" class="col-xl-7">
                        <span class="badge" id="askCounter"><?php echo $intAskNumber;?></span>
                    </div>
                </div>
<!-- -- -- -- Niveau de la question -- -- -- -->
                <div class="row">
                    <label for="hqLevel" id="hqLevelLabel" class="col-xl-5">Niveau</label>
                    <div id="hqLevel" class="col-xl-7">
                        <meter min="0" max="3" low="1" high="2" optimum="0" value="<?php echo $arrQuestion['Level'];?>"></meter>
                    </div>
                </div>
<!-- -- -- -- Catégorie de la question -- -- -- -->
                <div class="row">
                    <label for="hqCategory" id="hqCatLabel" class="col-xl-5">Catégorie</label>
                    <div id="hqCategory" class="col-xl-7 <?php echo $arrQuestion['CatSlug'];?>"><?php echo $arrQuestion['Category'];?></div>
                </div>
            </article>
<!-- -- -- -- Bloc 'partie' -- -- -- -->
            <article id="hudGame" class="col-xl-6">
<!-- -- -- -- Avancement de la partie -- -- -- -->
                <div class="row">
                    <label for="hgState" id="hgStateLabel" class="col-xl-12">Partie</label>
                    <div id="hgState" class="col-xl-12">
                        <progress max="<?php echo $intProgAim;?>" value="<?php echo $intAskNumber;?>"></progress>
                    </div>
<!-- -- -- -- Score de la partie -- -- -- -->
                    <label for="hgScore" id="hgScoreLabel" class="col-xl-8">Score</label>
                    <div id="hgScore" class="col-xl-4">
                        <span class="badge" id="gameScore"><?php echo $intScore;?></span>
                    </div>
                </div>
            </article>
        </section>

<!-- -- -- -- Section 'question' -- -- -- -->
        <section id="secAsk" class="row">
<!-- -- -- -- Bloc 'présentation' -- -- -- -->
            <article id="askInfos" class="col-xl-12">
<!-- -- -- -- row 'saison' -- -- -- -->
                <div id="seasonRow" class="row">
                    <label for="aiSeason" class="col-xl-4">Saison</label>
                    <div id="aiSeason" class="col-xl-8">
                        <div class="row">
<?php
    for ( $i = 1 ; $i < 11 ; $i++) {?>
                            <div class="col-xl-1 <?php echo "season".$i;?>"><?php echo $i;?></div>
<?php
    }?>
                        </div>
                    </div>
                </div>
<!-- -- -- -- row 'episode' -- -- -- -->
                <div id="episodeRow" class="row">
                    <label for="aiEpisode" class="col-xl-4">&Eacute;pisode <?php echo $arrQuestion['EpisodeNumber'];?></label>
                    <div class="col-xl-8">
                        <div id="aiTitleFr" class="col-xl-12"><?php echo $arrQuestion['EpisodeNameFr'];?></div>
                        <div id="aiTitleUs" class="col-xl-12"><?php echo $arrQuestion['EpisodeNameUs'];?></div>
                    </div>
                </div>
            </article>
<!-- -- -- -- Bloc 'media' -- -- -- -->
            <article id="askMedia" class="col-xl-8">

            </article>
<!-- -- -- -- Bloc 'texte de la question' -- -- -- -->
            <article id="askText" class="col-xl-4">

            </article>
<!-- -- -- -- Bloc 'question' -- -- -- -->
            <article id="askForReal" class="col-xl-12">

            </article>
        </section>
<!-- -- -- -- Formulaire 'réponse' -- -- -- -->
        <form id="frmAnswer">
        
        </form>
    </section>
<?php
}?>