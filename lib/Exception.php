<?php

namespace Exception;
/*
 * Example from PHP manual http://php.net/manual/de/language.exceptions.php
 */
interface IException {
	/* Protected methods inherited from Exception class */
	public function getMessage(); // Exception message
	public function getCode(); // User-defined Exception code
	public function getFile(); // Source filename
	public function getLine(); // Source line
	public function getTrace(); // An array of the backtrace()
	public function getTraceAsString(); // Formated string of trace
	
	/* Overrideable methods inherited from Exception class */
	public function __toString(); // formated string for display
	public function __construct($message = null, $code = 0);
}
abstract class CustomException extends \Exception implements IException {
	protected $message = 'Unknown exception'; // Exception message
	private $string; // Unknown
	protected $code = 0; // User-defined exception code
	protected $file; // Source filename of exception
	protected $line; // Source line of exception
	private $trace; // Unknown
	public function __toString() {
		return get_class ( $this ) . " '{$this->message}'\n";
	}
}
class AccessDeniedException extends CustomException {
	protected $message = 'Access Denied!';
}
class UnknownException extends CustomException {
	protected $message = 'Unknown Error!';
}
class NotImplementedException extends CustomException {
	protected $message = 'This Funciton is not available by now. Wait for it or make a pullrequest on Github.';
}
class UserFaultException extends CustomException {
	protected $message = 'Something went wrong with your request!';
}
class MultiFaultException extends CustomException {
	protected $message = 'Multiple things went wrong with your request!';
	protected $messages = [ ];
	public function setMessages($messages = array()) {
		$this->message = "<ul><li>" . join ( "</li><li>", $messages ) . "</li></ul>";
	}
}