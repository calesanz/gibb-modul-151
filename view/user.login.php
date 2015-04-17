<div>

	<?php
if (isset ( $errorMessage ) && $errorMessage != "")
		echo "	<div class='alert alert-danger'>". $errorMessage . "</div>";
	?>


	<form class="form-signin" method="post" action="/user/login">
		<input class="form-control" type="text" name="email" value="" placeholder="email"> 
		
		<input type="password"  class="form-control"
			name="password" value="" placeholder="password"> 
		<div class="inline-list">
			<input class="btn btn-success" type="submit" name="submit" value="Login"> <a
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