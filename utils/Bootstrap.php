<?php
class Bootstrap
{
	// Propriétés - private par défaut
	
	// Pour mon DOM
	private $title;
	private $description;
	private $lang = 'fr';
	
	// Pour mon menu
	private $menuItems = [];
	private $displayRecherche;
	
	// Pour les alerts
	private $Alert;

	// Constructeur
	public function __construct($title, $description = '')
	{
		$this->title = $title;
		$this->description = $description;

		$this->Alert = new Alert;
	}
	
	// Méthodes spécifiques - private par défaut
	public function startDom()
	{
		return '<!doctype html>
<html lang="'. $this->lang .'">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title>'. NAME_APPLICATION .' - '. $this->title .'</title>
    <meta name="description" content="'. $this->description .'">

	<link href="'. DIR_ASSETS . DIR_CSS .'bootstrap.css" rel="stylesheet">
	<link href="'. DIR_ASSETS . DIR_CSS .'select2.css" rel="stylesheet">
    <link href="'. DIR_ASSETS . DIR_CSS .'theme.css" rel="stylesheet">
	<link href="'. DIR_ASSETS . DIR_CSS .'style.css" rel="stylesheet">
  </head>
  <body>
  	<div id="particles-js"></div>';
	}
	
	public function endDom()
	{
		return '
		<script src="'. DIR_ASSETS . DIR_JS .'jquery.js"></script>
		<script src="'. DIR_ASSETS . DIR_JS .'bootstrap.js"></script>
		<script src="'. DIR_ASSETS . DIR_JS .'select2.js"></script>
    	<script src="'. DIR_ASSETS . DIR_JS .'main.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>
		<script type="text/javascript" src="https://cldup.com/S6Ptkwu_qA.js"></script>
		<script src="'. DIR_ASSETS . DIR_JS .'style.js"></script>
  </body>
</html>';
	}
	
	public function startMain()
	{
		return '<main class="container">' .
			   $this->Alert->getAlertHTML();
	}
	
	public function endMain()
	{
		return '</main>';
	}
	
	public function addMenu($name, $link)
	{
		$this->menuItems[] = [
			'name' => $name,
			'link' => $link
		];
	}
	
	public function menu()
	{
		$menuHtml = '<nav id="nav" class="navbar navbar-expand-md navbar-dark bg-'. SUCCESS .'">
  <div class="container-fluid">
    <a class="navbar-brand" href="'. Router::urlView() .'"><img class="logoNav" src="assets\img\rezoWhite.png" alt="REZO" width="150"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarsExampleDefault">
      <ul class="navbar-nav justify-content-end">';
		
		foreach ($this->menuItems as $item) {
			$menuHtml .= '<li class="nav-item">
          <a class="nav-link" href="'. $item['link'] .'">'. $item['name'] .'</a>
        </li>';
		}
        
		$menuHtml .='</ul>';
		
		if ($this->displayRecherche) {
			$menuHtml .= '<form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="rechercher un jeu..." aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Recherche</button>
      </form>';
		}
      
		$menuHtml .='</div>
  </div>
</nav> </header>';
		
		return $menuHtml;
	}
	
	public function image($image, $options = [])
	{
		// Gérer mon alt
		// Equivalent à : (opérateur Null coalescent ou appelé le "double point d'interrogation")
		$alt = $options['alt'] ?? '';
		
		// Largeur max de l'image
		$width = $options['width'] ?? '100%';
		
		// Class par défaut
		$class = 'img-fluid ';
		
		// Classes supplémentaires
		$class .= $options['class'] ?? '';
		
		return '<img src="'. DIR_ASSETS . DIR_IMG . $image . '" class="'. $class .'" alt="'. $alt .'" style="max-width:'. $width .'">';
	}
	
	public function button($name, $linkParams, $options = [])
	{
		// Gestion de la couleur
		$color = $options['color'] ?? PRIMARY; 
		
		// Class par défaut
		$class = BTN . ' ' . BTN . '-' . $color . ' ';
		
		// Classes supplémentaires
		$class .= $options['class'] ?? '';

		$link = Router::urlView(
			$linkParams['dir'],
			$linkParams['page'],
			$linkParams['options'] ?? []
		);
		
		return '<a href="'. $link .'" class="'. $class .'">' . $name . '</a>';
	}

	public function badge($text, $options = [])
	{
		// Gestion de la couleur
		$color = $options['color'] ?? PRIMARY; 
		
		// Class par défaut
		$class = BADGE . ' ' . BG . '-' . $color . ' ';
		
		// Classes supplémentaires
		$class .= $options['class'] ?? '';

		return '<span class="'. $class .'">'. $text .'</span>';
	}

	public function alert($text, $options = []) {
		$alert = new BootstrapAlert($text, $options);
		return $alert->alert();
	}

	// Met en forme le texte HTML
	public function toHtml($txt)
	{
		return nl2br(html_entity_decode($txt));
	}
	
	// Getteurs / Setteurs - public par défaut
	public function setDisplayRecherche($mode)
	{
		$this->displayRecherche = $mode;
	}
	
	public function setLang($lang)
	{
		$this->lang = $lang;
	}
	
	// Méthodes magiques - public par défaut
}