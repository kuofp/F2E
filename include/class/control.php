<?php

class Control {
	
	protected $act;
	
	function __construct(){
		
		$this->act = $_REQUEST['m'] ?? 'index';
	}
	
	function make(){
		
		$mod = \Box::val('mod');
		
		// Reduce session lock
		session_start();
		switch($this->act){
			case 'sys_login':
			case 'sys_index':
			case 'index':
				// Write session
				break;
			default:
				session_write_close();
				break;
		}
		
		if(class_exists($this->act)){
			// new obj directly
			return new $this->act;
			
		}elseif(class_exists($mod[$this->act] ?? '')){
			// new obj via module table
			return new $mod[$this->act];
			
		}elseif(file_exists($mod[$this->act] ?? '')){
			// include file
			require $mod[$this->act];
			exit;
		}
	}
}