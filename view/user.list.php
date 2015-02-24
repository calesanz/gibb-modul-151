<ul>
<?php 
	foreach($users as $user){
		echo "<li><a href='/user/detail/$user->Id' > $user->FullName </a></li>";
	}
?>

</ul>