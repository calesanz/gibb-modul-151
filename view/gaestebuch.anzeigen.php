<p><?php 
foreach($entries as $entry){
		echo "<li> $entry->User->Username : $entry->Text </li>";
	}
?></p>