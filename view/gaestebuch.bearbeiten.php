<ul>
	<?php
	if(isset($errors)) 
	
			echo $errors;
		
	?>
</ul>
<form action="/gaestebuch/bearbeiten" method="post">
<input type="text" name="inhalt" value="<?php if(isset($guestbookentry)) echo $guestbookentry->Text; ?> ">
<input type="hidden" name="id" value="<?php if(isset($guestbookentry)) echo $guestbookentry->Id; ?> ">
<input type="submit" value="submit"> 
</form>