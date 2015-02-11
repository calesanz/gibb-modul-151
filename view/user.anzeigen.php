<ul>
<?php 
	foreach($users as $user){
		echo "<li>ID: '$user->id' <br> Username: '$user->username' <br> Email: '$user->email' <br> Compare String: ' $user->compareString '</li>";
	}
?>

</ul>