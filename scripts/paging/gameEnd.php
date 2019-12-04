<?php
/*************************************************************************************************
 *   EmtZahella Projects Incorporated
 *                Projet :   ToWaQ
 *                  Page :   gameEnd.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/paging/gameEnd.php
 *                  Type :   page utilisateur
 *              Contexte :   Php 7.3
 *              Fonction :   vue de fin de partie
 *   Date mise en oeuvre :   24/11/2019
 *          Dernière MàJ :   03/12/2019
 *************************************************************************************************/
// Fonction d'affichage d'une question
//       Paramètres  : none
//  Valeur de retour : none
function fctDisplayEndGame($arrLevels){
    $arrPlayer = fct_SelectOnePlayerById($_POST['selectPlayer']);
    $arrCategories = fct_SelectAllCategories();
// Controller : type de partie
    switch ($_POST['optPartie']) {
        case $GLOBALS['str10SuiteCode']:
            $intMaxScore = 10;
            break;
        case $GLOBALS['strFriendsBattleCode']:
            $intMaxScore = 20;
            break;
        case $GLOBALS['strScoreBattleCode']:
            $intMaxScore = 20;
            break;
    }
    $intRightAnswers = intval($_POST['ansright']);
    $intWrongAnswers = intval($_POST['answrong']);
    $intQuestionsTotal = $intRightAnswers + $intWrongAnswers;
    $intRightRate = round($intRightAnswers/$intQuestionsTotal*100,0,PHP_ROUND_HALF_UP);
    $intWrongRate = round($intWrongAnswers/$intQuestionsTotal*100,0,PHP_ROUND_HALF_UP);
    $strRightRate = $intRightRate . " %";
    $strWrongRate = $intWrongRate . " %";
    // Totaux des questions par niveaux
    $intTotalLevel1 = intval($arrPlayer['Level1G']) + intval($arrPlayer['Level1B']);
    $intTotalLevel2 = intval($arrPlayer['Level2G']) + intval($arrPlayer['Level2B']);
    $intTotalLevel3 = intval($arrPlayer['Level3G']) + intval($arrPlayer['Level3B']);
    $intTotalLevelsG = intval($arrPlayer['Level1G']) + intval($arrPlayer['Level2G']) + intval($arrPlayer['Level3G']);
    $intTotalLevelsB = intval($arrPlayer['Level1B']) + intval($arrPlayer['Level2B']) + intval($arrPlayer['Level3B']);
    $intTotalQuestions = $intTotalLevel1 + $intTotalLevel2 + $intTotalLevel3;
    // Totaux des questions par catégories
    $intTotalCat1 = intval($arrPlayer['Cat1G']) + intval($arrPlayer['Cat1B']);
    $intTotalCat2 = intval($arrPlayer['Cat2G']) + intval($arrPlayer['Cat2B']);
    $intTotalCat3 = intval($arrPlayer['Cat3G']) + intval($arrPlayer['Cat3B']);
    $intTotalCat4 = intval($arrPlayer['Cat4G']) + intval($arrPlayer['Cat4B']);
    // Inclinaison de la balance
    if ( $strRightRate > $intWrongRate ) {
        $strBalance = "fa fa-balance-scale-right";
    } else if ( $strRightRate < $intWrongRate ) {
        $strBalance = "fa fa-balance-scale-left";
    } else {
        $strBalance = "fa fa-balance-scale";
    }
?>
<!-- -- -- -- Section : principale -- -- -- -->
    <section id="game_end" class="row">
<!-- -- -- -- Bloc : Partie -- -- -- -->
        <section id="gend_partie" class="offset-xl-1 col-xl-10">
            <div class="row">
             <div id="gend_score" class="offset-xl-1 col-xl-10">
              <label for="gend_score" class="col-xl-12">Statistiques de la partie</label>
              <div class="row">
<!-- -- -- -- Le score -- -- -- -->
               <div class="col-xl-6 gend_gamelabels">Score</div>
               <div class="col-xl-6 gend_numbersbig"><?php echo $_POST['score'];?>&nbsp;/&nbsp;<?php echo $intMaxScore;?></div>
<!-- -- -- -- Les questions -- -- -- -->
               <div class="col-xl-6 gend_gamelabels">Questions posées</div>
               <div class="col-xl-6 gend_numbersbig"><?php echo $intQuestionsTotal;?></div>
               <div class="col-xl-5 gend_labels">Mauvaises réponses</div>
               <div class="offset-xl-2 col-xl-5 gend_labels">Bonnes réponses</div>
               <div class="col-xl-3 gend_numbers"><?php echo $strWrongRate;?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intWrongAnswers;?></div>
               <div class="col-xl-2 gend_labels"><span class="<?php echo $strBalance;?>"></span></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intRightAnswers;?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $strRightRate;?></div>
              </div>
             </div>
            </div>
        </section>
<!-- -- -- -- Bloc : Joueur -- -- -- -->
        <section id="gend_player" class="offset-xl-1 col-xl-10">
            <div class="row">
             <div id="gend_playerstats" class="offset-xl-1 col-xl-10">
              <label for="gend_playerstats" class="col-xl-12">Statistiques de <?php echo $arrPlayer['Pseudo'];?></label>
              <div class="row">
<!-- -- -- -- Labels -- -- -- -->
               <div class="offset-xl-4 col-xl-3 gend_labels">Bonnes</div>
               <div class="col-xl-3 gend_labels">Mauvaises</div>
               <div class="col-xl-2 gend_labels">Total</div>
<!-- -- -- -- Stats : totaux -- -- -- -->
               <div class="col-xl-4 gend_labels">Réponses</div>
               <div class="col-xl-3 gend_numbers"><?php echo $intTotalLevelsG;?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $intTotalLevelsB;?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalQuestions;?></div>
<!-- -- -- -- Stats : niveaux -- -- -- -->
               <div class="col-xl-12 gend_rublabels">Par niveaux</div>
<!-- -- -- -- Niveau 1 -- -- -- -->
               <div class="col-xl-4 meter"><meter min="0" max="3" low="1" high="2" optimum="0" value="1"></meter></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level1G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level1B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalLevel1;?></div>
<!-- -- -- -- Niveau 2 -- -- -- -->
               <div class="col-xl-4 meter"><meter min="0" max="3" low="1" high="2" optimum="0" value="2"></meter></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level2G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level2B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalLevel2;?></div>
<!-- -- -- -- Niveau 3 -- -- -- -->
               <div class="col-xl-4 meter"><meter min="0" max="3" low="1" high="2" optimum="0" value="3"></meter></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level3G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Level3B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalLevel3;?></div>
<!-- -- -- -- Stats : catégories -- -- -- -->
               <div class="col-xl-12 gend_rublabels">Par catégories</div>
<!-- -- -- -- Catégorie : Peur et bétes noires (1) -- -- -- -->
               <div class="col-xl-4" id="gend_catlabel1"><?php echo $arrCategories['1']['Name'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat1G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat1B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalCat1;?></div>
<!-- -- -- -- Catégorie : Histoire ancienne (2) -- -- -- -->
               <div class="col-xl-4" id="gend_catlabel2"><?php echo $arrCategories['2']['Name'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat2G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat2B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalCat2;?></div>
<!-- -- -- -- Catégorie : Littérature (3) -- -- -- -->
               <div class="col-xl-4" id="gend_catlabel3"><?php echo $arrCategories['3']['Name'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat3G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat3B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalCat3;?></div>
<!-- -- -- -- Catégorie : Ça concerne la famille (4) -- -- -- -->
               <div class="col-xl-4" id="gend_catlabel4"><?php echo $arrCategories['4']['Name'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat4G'];?></div>
               <div class="col-xl-3 gend_numbers"><?php echo $arrPlayer['Cat4B'];?></div>
               <div class="col-xl-2 gend_numbers"><?php echo $intTotalCat4;?></div>
<!-- -- -- -- Fin : bloc Joueur -- -- -- -->
              </div>
             </div>
            </div>
<!-- -- -- -- Fin : bloc Partie -- -- -- -->
        </section>
<!-- -- -- -- -- Bouton : Retour à l'accueil -- -- -- -- -->
        <div class="col-xl-12">
         <div class="row">
          <a class="col-xl-4" href="../index.php" title="Retour à l'accueil de ToWaQ">
           <button><span class="fa fa-arrow-circle-left"></span>&nbsp;Accueil</button>
          </a>
          <a class="col-xl-4" href="partieConfig.php" title="Rejouer à ToWaQ">
           <button><span class="fa fa-redo"></span>&nbsp;Rejouer</button>
          </a>
         </div>
        </div>
<!-- -- -- -- Fin : section principale -- -- -- -->
    </section>
<?php
}