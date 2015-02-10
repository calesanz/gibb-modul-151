<?php
namespace View;
class View
{
    private $viewfile 	= null;
    private $properties = array();

    public function __construct($viewfile = '', $properties = array())
    {
    	$this->properties = $properties;
    	
    	$viewfile = './view/' . $viewfile . '.php';
    	if (file_exists($viewfile))
	    {
	       $this->viewfile = $viewfile;
	    }
    }
    
    public function __set($property, $value)
    {
        if (!isset($this->$property))
        {
            $this->properties[$property] = $value;
        }
    }

    public function __get($property)
    {
        if (isset($this->properties[$property]))
        {
            return $this->properties[$property];
        }
    }

    public function display()
    {
        extract($this->properties);
        require_once($this->viewfile);
    }
    
   
}