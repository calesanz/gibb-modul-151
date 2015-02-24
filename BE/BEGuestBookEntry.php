<?php 
namespace BE;

class BEGuestBookEntry extends BE_Base{
	public $Id = 0;
	public $UserId = 0;
	public $Text = null;
	public $CreatedAt = null;
	public $Attachment = null;
	public $User = null;
	
	public function isNew(){
		return $this->id===0;
	}
	
	public function getCompareString(){
		$attachment = "";
		if(isset($this->attachment))
			$attachment = $this->Attachment->getCompareString();
		return "$this->Id $this->Text $this->CreatedAt $this->UserId $attachment";
	}
	
	
}

