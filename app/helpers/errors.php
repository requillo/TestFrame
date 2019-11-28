<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
* 
*/
class Errors 
{
	
	function __construct()
	{
		# code...
	}

	public function no_class($class){
		$class = str_replace('-', '_', $class);
		$app = App::config('app');
		$res = '<div class="app-error app-class-error">'.__('The class').' <strong>'.ucfirst($class).'</strong> '.__('does not exists.').'</div>';
		$res .= '<div class="app-error app-file-error">'. __('Create a file').' <strong>'.$class.'.php</strong> '.__('in folder:').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If you want to create a main controller').'</em><br>';
		$res .= str_replace('\\','/',$app['controllers-path']).'</div>';
		$res .= '<div class="app-error">'.__('or').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If you want to create a plugin').'</em><br>';
		$res .= str_replace('\\','/',$app['plugins-path']).$class.'/</div>';
		$res .= '<div class="app-error"><em>'.__('File contents').'</em></div>';
		$res .= '<div class="app-error app-error-content">';
		$res .= '<div class="class-holder"><em>// '.__('Create this Class').'</em></div>';
		$res .= '<div class="class-holder"><span class="text-info">class</span> '.ucfirst($class).' <span class="text-danger">extends</span> <span class="text-success">Controller</span></div>';
		$res .= '<div class="class-holder">{</div>';
		$res .= '<div class="method-holder"><span class="text-info">function __construct</span>()</div>';
		$res .= '<div class="method-holder">{</div>';
		$res .= '<div class="method-call"><span class="text-info">parent</span><span class="text-danger">::</span>__construct()</div>';
		$res .= '<div class="method-holder">}</div>';		
		$res .= '<div class="method-holder"><span class="text-info">function</span> <span class="text-success">admin_index</span>()</div>';
		$res .= '<div class="method-holder">{</div>';
		$res .= '<div class="method-call"><em>// '.__('Your awesome code goes here').'</em></div>';
		$res .= '<div class="method-holder"> }</div>';
		$res .= '<div class="class-holder">}</div></div>';
		return $res;

	}

	public function no_method($class,$method)
	{
		$class = str_replace('-', '_', $class);
		$method = str_replace('-', '_', $method);
		$app = App::config('app');
		$res = '<div class="app-error app-method-error">'.__('This method').' <strong>'.$method.'</strong> '.__('does not exists.').'</div>';
		$res .= '<div class="app-error app-file-error">'. __('Add method to file').' <strong>'.$class.'.php</strong> '.__('in folder:').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If this is a main controller').'</em><br>';
		$res .= str_replace('\\','/',$app['controllers-path']).'</div>';
		$res .= '<div class="app-error">'.__('or').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If this is a plugin').'</em><br>';
		$res .= str_replace('\\','/',$app['plugins-path']).$class.'/</div>';
		$res .= '<div class="app-error"><em>'.__('File contents').'</em></div>';
		$res .= '<div class="app-error app-error-content">';
		$res .= '<div class="class-holder"><span class="text-info">class</span> '.ucfirst($class).' <span class="text-danger">extends</span> <span class="text-success">Controller</span></div>';
		$res .= '<div class="class-holder">{</div>';
		$res .= '<div class="method-holder"><span class="text-info">function __construct</span>()</div>';
		$res .= '<div class="method-holder">{</div>';
		$res .= '<div class="method-call"><span class="text-info">parent</span><span class="text-danger">::</span>__construct()</div>';
		$res .= '<div class="method-holder">}</div>';
		$res .= '<div class="method-holder"><em>// '.__('Create this Method').'</em></div>';
		$res .= '<div class="method-holder"><span class="text-info">function</span> <span class="text-success">'.$method.'</span>()</div>';
		$res .= '<div class="method-holder">{</div>';
		$res .= '<div class="method-call"><em>// '.__('Your awesome code goes here').'</em></div>';
		$res .= '<div class="method-holder"> }</div>';
		$res .= '<div class="class-holder">}</div></div>';
		return $res;

	}

	public function no_view($class,$method)
	{
		$app = App::config('app');
		$class = str_replace('-', '_', $class);
		$method = str_replace('-', '_', $method);
		$res = '<div class="app-error app-view-error">'.__('No view file found for method').' <strong>'.$method.'</strong> '.'</div>';
		$res .= '<div class="app-error app-file-error">'.__('Create a file').' <strong>'.$method.'.php</strong> '.__('in folder').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If this is a main controller').'</em><br>';
		$res .= str_replace('\\','/',$app['views-path']).$class.'/</div>';
		$res .= '<div class="app-error">'.__('or').'</div>';
		$res .= '<div class="app-error app-folder-error"><em>'.__('If this is a plugin').'</em><br>';
		$res .= str_replace('\\','/',$app['plugins-path']).$class.'/views/'.'</div>';
		return $res;
	}

}