<div>
	<ul>
	<?php
	if (isset ( $errorMessage ))
		echo $errorMessage;
	?>
</ul>

	<form method="post" action="/user/register">
		<div>
			<input type="text" name="fullname" value="" placeholder="full name">
		</div>
		<div>
			<input type="text" name="username" value="" placeholder="username">
		</div>
		<div>
			<input type="text" name="email" value="" placeholder="email">
		</div>
		<div>
			<input type="password" name="password" value="" placeholder="password">
		</div>
		<div>
			<input type="password" name="password2" value="" placeholder="repeat password">
		</div>
		<input type="submit" name="submit" value="Login">
	<?php
	
	if (isset ( $backurl )) {
		echo "<input type='hidden' name='backurl' value='$backurl'>";
	}
	?>
</form>
</div>