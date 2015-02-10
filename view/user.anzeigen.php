<ul>
<?php 
	foreach($users as $user){
		echo "<li> $user->id  $user->username $user->email</li>";
	}
?>

</ul>