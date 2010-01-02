<?php

class Events {
	const REMOVE_HANDLER = 'remove';
	
	private $map;
	var $CI;
	private $param_counts;
	
	/**
	 * The constructor for the event system.
	 *
	 * @return void
	 * @author Rich Cavanaugh
	 **/
	function __construct () {
		$this->CI =& get_instance();
		$this->map = $this->initialize_map();
		$this->param_counts = array();
	}
	
	/**
	 * Send a message through the event system.
	 *
	 * @return void
	 * @author Rich Cavanaugh
	 **/
	function send ($message, $object=NULL) {
		// return early if we have nothing to do
		if (empty($this->map[$message])) return;
		
		$remove = array();
		foreach ($this->map[$message] as $i => $val) {
			// extract and format the values from this event handler mapping
			list($type, $library, $method, $args) = $this->values_for_handler($val);
						
			if (!isset($this->CI->$library)) $this->CI->load->$type($library);
			
			// extract the appropriate amount of parameters to be passed
			// to the handler method
			$params = $this->params_for_method($this->CI->$library, $method, $object, $args, $message);
			
			// call the handler method with the parameters
			$rv = call_user_func_array(array($this->CI->$library, $method), $params);
			
			if ($rv == Events::REMOVE_HANDLER) $remove[] = $i;
		}
		
		foreach ($remove as $key) unset($this->map[$message][$key]);
	}
	
	/**
	 * append a handler to the stack
	 *
	 * @return void
	 * @author Rich Cavanaugh
	 **/
	function append ($message, $handler) {
	  if (!isset($this->map[$message])) $this->map[$message] = array();
	  array_push($this->map[$message], $handler);
	}
	
	/**
	 * Load the configuration file and initialize
	 * some internal data structures from the values.
	 *
	 * @return array
	 * @author Rich Cavanaugh
	 **/
	protected function initialize_map () {
		$this->CI->config->load('events', true);
		return $this->CI->config->config['events'];
	}
	
	/**
	 * This method sets up the params array to be passed to the
	 * handler method. It does this by reflecting the parameter 
	 * count for the method and passing the appropriate number.
	 *
	 * @return array
	 * @author Rich Cavanaugh
	 **/
	protected function params_for_method ($lib, $method, $object, $args, $message) {
		switch ($this->param_count_for_method($lib, $method)) {
			case 0:
				return array();
			case 1:
				return array($object);
			case 2:
				return array($object, $args);
			case 3:
			  return array($object, $args, $message);
		}
	}
	
	/**
	 * Sets up the handler values array. If there's no fourth item
	 * it creates one with a NULL value.
	 *
	 * @return array
	 * @author Rich Cavanaugh
	 **/
	protected function values_for_handler ($val) {
		if (count($val) == 3) array_push($val, NULL);
		return $val;
	}
	
	/**
	 * Count, cache and return the parameter count for a method.
	 *
	 * @return int
	 * @author Rich Cavanaugh
	 **/
	protected function param_count_for_method ($lib, $method) {
		$key = get_class($lib) . "-{$method}";
		
		if (!isset($this->param_counts[$key])) {
			$reflected = new ReflectionMethod($lib, $method);
			$this->param_counts[$key] = $reflected->getNumberOfParameters();
		}
		
		return $this->param_counts[$key];
	}
}