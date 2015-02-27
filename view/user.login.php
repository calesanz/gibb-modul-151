<div>
<div>
	<?php 
	if(isset($errorMessage))
		echo $errorMessage;
	?>
</div>

<form method="post" action="/user/login" >
	<input type="text" name="email" value="" >
	<input type="password" name="password" value="">
	<input type="submit" name="submit" value="Login">
	<?php 
		echo "<input type='hidden' name='backurl' value='$backurl'>";
	?>
</form>
</div>