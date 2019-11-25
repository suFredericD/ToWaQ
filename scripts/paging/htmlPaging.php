<?php
/*******************************************************************************************
 *   EmtZahella Incorporated
 *                Projet :   ToWaQ
 *                  Page :   htmlPaging.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/paging/htmlPaging.php
 *                  Type :   page de scripts
 *              Contexte :   Php 7.3
 *              Fonction :   page de définition de la classe page
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   25/11/2019
 *******************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    DECLARATIONS   ***** *****/

/***** *****    FONCTIONS   ***** *****/
// Fonction de construction du header html
//      Paramètres :
//    objPageInfos : objet contenant les informations de la page
//          Retour : none
function fct_BuildHtmlHeader($objPageInfos){
    $arrFileName = preg_split("/\./", $objPageInfos->getName());    // Split du nom complet du fichier en tableau
    $strFileCss = $arrFileName[0] . ".css";                          // Nom du css associé au fichier
?>
<html lang="fr">
<!-- -- -- -- -- Header Html -- -- -- -- -->
    <head>
        <title><?php echo $GLOBALS['strSiteName'];?> - <?php echo $objPageInfos->getTitle();?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no"><!-- Viewport pour media queries -->
        <meta name="description" content="<?php echo $objPageInfos->getDescription();?>"><!-- Description -->
        <meta name="author" content="<?php echo $GLOBALS['strAuthor'];?>"><!-- Auteur du site -->
        <link href="<?php echo $objPageInfos->getCssPath() . "bootstrap/" . $GLOBALS['strBootStrapCss'];?>" rel="stylesheet"><!-- Css BootStrap -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
        <meta name="keywords" content="<?php echo $GLOBALS['strKeywords'];?>"><!-- Mots-clés -->
        <meta name="robots" content="all">
        <link href="<?php echo $objPageInfos->getCssPath();?>general.css" rel="stylesheet" type="text/css"><!-- Css général -->
<?php   if ( $objPageInfos->getName() != "index.php" ) {?>
        <link href="<?php echo $objPageInfos->getCssPath().$strFileCss;?>" rel="stylesheet" type="text/css"><!-- Css associé au fichier -->
<?php       if ( $objPageInfos->getName() === "gameMain.php" ) {?>
        <link href="<?php echo $objPageInfos->getCssPath();?>mainView.css" rel="stylesheet" type="text/css"><!-- Css de la vue principale -->
<?php       }
        }?>
        <link rel="icon" type="image/ico" href="<?php echo $objPageInfos->getPicturesPath().$GLOBALS['strSiteIcon'];?>"><!-- Icône du site -->
        <link href="<?php echo $objPageInfos->getConfigPath();?>fontawesome/css/all.css" rel="stylesheet"><!-- Lien FontAwesome -->
    </head>
<!-- -- -- -- -- Corps du contenu -- -- -- -- -->
    <body>
     <section class="container" id="site-container">
<?php
}
// Fonction de construction du footer html
//      Paramètres :
//    objPageInfos : objet contenant les informations de la page
//          Retour : none
function fct_BuildHtmlFooter($objPageInfos){
?>
<!-- -- -- -- -- Fin de corps du contenu -- -- -- -- -->
     </section>
    </body>
    
<!-- -- -- -- -- Footer Html -- -- -- -- -->
    <footer class="container">
     <address>
      <p id="footer_author"><?php echo $GLOBALS['strAuthor'];?>&nbsp;&copy;&nbsp;2019</p>
      <p id="footer_rights">All rights reserved</p>
     </address>
    </footer>
</html>
<?php
}
?>