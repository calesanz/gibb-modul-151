<div>

	<?php
	if (isset ( $errorMessage ) && $errorMessage != "")
		echo "<ul class='alert alert-danger'>" . $errorMessage . "</ul>";
	?>


	<form class="form-signin"  method="post" action="/user/register">
		<div>
			<input type="text" name="fullname" value="<?php if(isset($fullname)) echo $fullname; ?>" placeholder="full name" class="form-control">
		</div>
		
		<div>
			<input type="text" name="email" value="<?php if(isset($email)) echo $email; ?>" placeholder="email" class="form-control">
		</div>
		<div>
			<input type="password" name="password" value="" class="form-control"
				placeholder="password">
		</div>
		<div>
			<input type="password" name="password2" value="" class="form-control"
				placeholder="repeat password">
		</div>
		<div class="inline-list">
			<input class="btn btn-success" type="submit" name="submit" value="Register"> <a
				class="btn btn-warning"
				href="<?php if(isset($backurl)) echo $backurl;?>">Cancel</a>
		</div>
	<?php
	
	if (isset ( $backurl )) {
		echo "<input type='hidden' name='backurl' value='$backurl'>";
	}
	?>
</form>
</div>