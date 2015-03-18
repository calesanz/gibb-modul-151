<?php 
namespace BO;



class BOGuestBook extends BO_Base{
	
	static function find($id){
		$entry = \DA\DAGuestBookEntry::find($id);
		$entry->User = \BO\BOUser::find($entry->UserId);
		return  $entry;
	}
	
	static function findAll(){
		$entries = \DA\DAGuestBookEntry::findAll();
		foreach ($entries as $entry) 
			$entry->User = \BO\BOUser::find($entry->UserId);
		return $entries;	
	}
	
	static function save(\BE\BEGuestBookEntry $entry){
		$error= self::validate($entry);

		if ($error==""){
			$error = \DA\DAGuestBookEntry::save($entry);
		}
		
		return  $error;
	}
	
	static function validate(\BE\BEGuestBookEntry $entry){
		$message ="";
		
		if($entry->UserId == 0)
			$message .= "<li>User cannot be null!</li>";	
		if(!isset($entry->Text) || $entry->Text == "" )
			$message .= "<li>Text cannot be empty!</li>";
		if(!isset($entry->CreatedAt))
			$message .= "<li>Date cannot be empty!</li>";
		return $message;
		
	}
	
	
	
}

