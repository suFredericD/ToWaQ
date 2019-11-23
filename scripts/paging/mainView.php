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
 *          Dernière MàJ :   22/11/2019
 *************************************************************************************************/

// Fonction d'extraction de toutes les questions
//       Paramètres  :
//      arrQuestions : tableau de toutes les questions
//     arrCategories : tableau de toutes les catégories
//         strPartie : type de partie
//      intAskNumber : numéro de la question en cours dans la liste des questions de la partie
//  Valeur de retour : none
function fctDisplayGameView($arrQuestions, $arrCategories, $strPartie, $intAskNumber){
    $intCategories = count($arrCategories);
?>
    <section id="mainView">

<!-- -- -- -- Section Hud -- -- -- -->
        <section id="secHud" class="row">
<!-- -- -- -- Bloc 'question' -- -- -- -->
            <article id="hudQuestion" class="col-xl-6">
<!-- -- -- -- Numéro de la question -- -- -- -->
                <div class="row">
                    <label for="hqNumber" id="hqNumLabel" class="col-xl-5">Question</label>
                    <div id="hqNumber" class="col-xl-7"><span><?php echo $intAskNumber;?></span></div>
                </div>
<!-- -- -- -- Niveau de la question -- -- -- -->
                <div class="row">
                    <label for="hqLevel" id="hqLevelLabel" class="col-xl-5">Niveau</label>
                    <div id="hqLevel" class="col-xl-7"><meter min="0" max="3" low="2" high="2" optimum="0" value="0"></meter></div>
                </div>
<!-- -- -- -- Catégorie de la question -- -- -- -->
                <div class="row">
                    <label for="hqCategory" id="hqCatLabel" class="col-xl-5">Catégorie</label>
                    <div id="hqCategory" class="col-xl-7"></div>
                </div>
            </article>
<!-- -- -- -- Bloc 'partie' -- -- -- -->
            <article id="hudGame" class="col-xl-6">
<!-- -- -- -- Avancement de la partie -- -- -- -->
                <div class="row">
                    <label for="hgState" id="hgStateLabel" class="col-xl-12">Avancement</label>
                    <div id="hgState" class="col-xl-12"><progress max="10" value="1"></progress></div>
<!-- -- -- -- Score de la partie -- -- -- -->
                    <label for="hgScore" id="hgScoreLabel" class="col-xl-5">Score</label>
                    <div id="hgScore" class="col-xl-7"><span></span></div>
                </div>
            </article>
        </section>

<!-- -- -- -- Section 'question' -- -- -- -->
        <section id="secAsk">
<!-- -- -- -- Bloc 'media' -- -- -- -->
            <article id="askMedia">

            </article>
<!-- -- -- -- Bloc 'question' -- -- -- -->
            <article id="askText">

            </article>
        </section>
<!-- -- -- -- Formulaire 'réponse' -- -- -- -->
        <form id="frmAnswer">
        
        </form>
    </section>
<?php
}?>