<?php 
namespace BO;



class BOGuestBook extends BO_Base{
	
	static function find($id){
		$entry = \DA\DAGuestBookEntry::find($id);
		$entry->User = \BO\BOUser::find($entry->UserId);
		// TODO: Attachments
	}
	
	static function findAll(){
		$entries = \DA\DAGuestBookEntry::findAll();
		foreach ($entries as $entry) 
			$entry->User = \BO\BOUser::find($entry->UserId);
		return $entries;	
	}
	
	static function save(\BEGuestBookEntry $entry){
		$error= $this->validate($entry);

		if ($error!=""){
			\DA\DAGuestBookEntry::save($entry);
		}
		return  $error;
	}
	
	static function validate(\BEGuestBookEntry $entry){
		$message ="";
		
		if($userId == 0)
			$message .= "<li>User cannot be null!</li>";	
		if(!isset($text) || $text == "" )
			$message .= "<li>Text cannot be empty!</li>";
		if(!isset($createdAt))
			$message .= "<li>Date cannot be empty!</li>";
		return $message;
		
	}
	
	
	
}

