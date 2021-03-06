<?php 

require_once ('application/libraries/EdgeApi.php');

class menuRouting{

	var $edgeapi;
	function __construct(){
		$this->edgeapi = new EdgeApi(); 
	}

	function index(){
		
		// If not session, we can't load the menu yet
		global $REQUEST_PATH;
		if($REQUEST_PATH == 'login')
			return;
		
		global $MENU_ROUTES;
		global $MENU_IFRAME_URLS;
		global $MENU_JSON;
		// Save menu for later
		
		$MENU_JSON = $this->edgeapi->Request('/menu');
		$MENU_IFRAME_URLS = array();
		
		$menuItems = json_decode($MENU_JSON);	
		$this->addRoutesFromMenuItems($menuItems);
		
		// Default routing when no path specified
		$MENU_ROUTES["accounts/(:num)/?$"] = 'pages/home/index/$1';
	}
	
	function addRoutesFromMenuItems(&$menuItems)
	{
		global $MENU_IFRAME_URLS;
		global $MENU_ROUTES;
	
		foreach($menuItems as $item)
		{
			if (isset($item->MetaData->Controller)) 
			{
				$MENU_ROUTES['accounts/(:num)/'.$item->Path] = 'pages/' . $item->MetaData->Controller . '/index/$1';			

				if(isset($item->MetaData->iFrameURL))
					$MENU_IFRAME_URLS[$item->Path] = $item->MetaData->iFrameURL;
			}
			
			if (isset($item->ChildItems))
				$this->addRoutesFromMenuItems($item->ChildItems);
		}
	}
	
}