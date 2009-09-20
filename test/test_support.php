<?php
require_once 'PHPUnit/Framework.php';
require_once 'Events.php';

class FakeCILoader {
}

class FakeCIConfig {
	var $config;
	
	function load($name, $namespace=false) {
	}
}

class FakeCIBase {
	private static $instance;
	
	function __construct() {
		self::$instance =& $this;
		$this->load = new FakeCILoader;
		$this->config = new FakeCIConfig;
		$this->events = new Events;
	}
	
	function model($name) {
	}
	
	function library($name) {
	}

	public static function &get_instance() {
		return self::$instance;
	}
}

function &get_instance() {
	return FakeCIBase::get_instance();
}

new FakeCIBase;
