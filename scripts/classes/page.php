<?php
/*******************************************************************************************
 *   EmtZahella Incorporated
 *                Projet :   ToWaQ
 *                  Page :   page.php
 *                Chemin :   http://127.0.0.1:8080/ToWaQ/scripts/classes/page.php
 *                  Type :   page de scripts
 *              Contexte :   Php 7.3
 *              Fonction :   page de définition de la classe page
 *   Date mise en oeuvre :   11/11/2019
 *          Dernière MàJ :   12/11/2019
 *******************************************************************************************/
/***** *****    INCLUSIONS ET SCRIPTS   ***** *****/

/***** *****    DECLARATIONS   ***** *****/

/***** *****    CLASSES   ***** *****/
class Page{
	private $strName;			// Nom de la page avec extension
	private $strTitle;			// Titre de la page
	private $strDescription;	// Rôle de la page
	private $strPath;			// Chemin de la page
	private $strIndexPath;		// Chemin vers l'index
	private $strMediaPath;		// Chemin relatif vers medias/
	private $strPicturesPath;	// Chemin relatif vers medias/pics/
	private $strConfigPath;		// Chemin relatif vers config/
	private $strCssPath;		// Chemin relatif vers config/css/
	private $strBootStrapPath;	// Chemin relatif vers config/css/bootstrap/ 
	private $strScriptsPath;	// Chemin relatif vers scripts/
	
	//	***** ***** ***** SETTERS ***** ***** ***** //
	public function setName($strNewName){
		$this->strName = $strNewName;										// Nom de la page avec extension
		//  Informations pages du site
		$arrPages = array(
			"index.php" => array(
				"title" => "Accueil",
				"description" => "Accueil"),
			"partieConfig.php"=> array(
				"title" => "Configuration",
				"description" => "Configuration de la partie")
		);
		$this->setTitle($arrPages[$strNewName]['title']);					// Titre de la page
		$this->setDescription($arrPages[$strNewName]['description']);		// Rôle de la page
		if( $strNewName == "index.php" ){
			$this->strPath = "pages/";
			$this->strIndexPath = "";
			$this->strMediaPath = $GLOBALS['strMediaPath'];
			$this->strPicturesPath = $GLOBALS['strPicturesPath'];
			$this->strConfigPath = $GLOBALS['strConfigPath'];
			$this->strCssPath = $GLOBALS['strCssPath'];
			$this->strBootStrapPath = $GLOBALS['strBootStrapPath'];
			$this->strScriptsPath = $GLOBALS['strScriptsPath'];
		}else{
			$this->strPath = "";
			$this->strIndexPath = "../";
			$this->strMediaPath = "../".$GLOBALS['strMediaPath'];
			$this->strPicturesPath = "../".$GLOBALS['strPicturesPath'];
			$this->strConfigPath = "../".$GLOBALS['strConfigPath'];
			$this->strCssPath = "../".$GLOBALS['strCssPath'];
			$this->strBootStrapPath = "../".$GLOBALS['strBootStrapPath'];
			$this->strScriptsPath = "../".$GLOBALS['strScriptsPath'];
		}
	}
	public function setTitle($strNewTitle){
		$this->strTitle = $strNewTitle;
	}
	public function setDescription($strNewDescription){
		$this->strDescription = $strNewDescription;
	}
	//	***** ***** ***** GETTERS ***** ***** ***** //
	public function getName(){				// Extraction du nom
		return $this->strName;
	}
	public function getTitle(){				// Extraction du titre
		return $this->strTitle;
	}
	public function getDescription(){		// Extraction de la description
		return $this->strDescription;
	}
	public function getPath(){				// Extraction du chemin
		return $this->strPath;
	}
	public function getIndexPath(){			// Extraction du chemin vers l'index
		return $this->strIndexPath;
	}
	public function getMediaPath(){			// Extraction du chemin des medias
		return $this->strMediaPath;
	}
	public function getPicturesPath(){		// Extraction du chemin des images
		return $this->strPicturesPath;
	}
	public function getConfigPath(){		// Extraction du chemin des fichiers de configuration
		return $this->strConfigPath;
	}
	public function getCssPath(){			// Extraction du chemin des fichiers css
		return $this->strCssPath;
	}
	public function getBootStrapPath(){		// Extraction du chemin des scripts BootStrap
		return $this->strBootStrapPath;
	}
	public function getScriptsPath(){		// Extraction du chemin des scripts du site
		return $this->strScriptsPath;
	}
}?>