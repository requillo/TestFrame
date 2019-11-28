<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Nav 
{
	public $icon;
	public $subs;
	public $default_icon;
	function __construct()
	{
		$this->icon = array();
		$this->subs = array();
		$this->main = array();
		$this->names = array();
	}

	function icon($name,$icon){
		$nav = array();
		$nav[$name] = $icon;
		array_push($this->icon,$nav);
	}

	public function main($link,$name,$icon = NULL){
		$main = array();
		$names = array();
		$main[$name]['link'] = $link;
		$main[$name]['icon'] = $icon;
		$names[$link] = $name;
		$this->main = array_merge($this->main, $main);
		$this->names = array_merge($this->names, $names);
	}

	public function sub($link,$name){
		$nav = array();
		$nav[$name] = $link;
		$this->subs = array_merge($this->subs,$nav);
	}

	public function default_icon($icon){
		$this->default_icon = $icon;
	}
}