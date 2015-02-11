<ul>
<?php 
	foreach($users as $user){
		echo "<li><a href='/user/detail/$user->id' > $user->username </a></li>";
	}
?>

</ul>