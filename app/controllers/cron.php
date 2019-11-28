<?php 
/**
* 
*/
class Cron extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function job($class,$method){
		$class = new $class;
		$method = 'cron_'.$method;
		if(method_exists($class,$method)) { 
			$class->$method();
		}
		
	}
}