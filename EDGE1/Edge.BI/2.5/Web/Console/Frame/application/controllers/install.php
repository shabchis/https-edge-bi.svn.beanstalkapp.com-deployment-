<?php 
class Install extends Controller {
		
	function index()
	{
		
				 global $APPLICATION_ROOT;
	 if (!isset($_COOKIE['edgebi_wpf2'])) {
	 	setcookie("edgebi_wpf2",'true',time()+60*60*24*14,$APPLICATION_ROOT);
	
		
			
	 }
	/*else
		{
		delete_cookie("edgebi_wpf2",null,$APPLICATION_ROOT);
		
		}
	
		
	}*/
	
}

