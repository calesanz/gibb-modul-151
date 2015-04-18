<div>

	<?php
	if (isset ( $errorMessage ) && $errorMessage != "")
		echo "	<div class='alert alert-danger'>" . $errorMessage . "</div>";
	?>

	<p>Change password for <?php if(isset($email))echo $email;?></p>
	<form class="form-signin" method="post" action="/user/changepassword">
		<input class="form-control" type="hidden" name="email"
			value="<?php if(isset($email))echo $email;?>" placeholder="email">
			 <input
			type="password" class="form-control" name="oldpassword" value=""
			placeholder="oldpassword">
			 <input type="password"	class="form-control" name="newpassword"
			placeholder="new password">
			 <input type="password"
			class="form-control" name="newpassword2" value=""
			placeholder="repeat new password">
		<div class="inline-list">
			<input class="btn btn-success" type="submit" name="submit"
				value="Change Password"> <a class="btn btn-warning"
				href="<?php if(isset($backurl)) echo $backurl;?>">Cancel</a>
		</div>
	
	
	<?php
	
	if (isset ( $backurl )) {
		echo "<input type='hidden' name='backurl' value='$backurl'>";
	}
	?>
</form>
</div>