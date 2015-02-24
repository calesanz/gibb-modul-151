<!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Guestbook</title>
<link rel="stylesheet" href="css/foundation.css" />
<script src="js/vendor/modernizr.js"></script>
</head>
<body>
	<!-- Titlebar -->
	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
				<h1><?php echo $title; ?></h1>
			</div>
		</div>
	</div>
	<div class="row">

		<div class="large-8 columns">
			<!-- Main Content -->
			<div class="row">
				<div>
					<?php $innercontent->display()?>
				</div>



			</div>
		</div>
		<aside class="large-4 columns ">
			<form>
				<input type="text"> <input type="text"> <input type="text">
			</form>
		</aside>

	</div>

	<footer class="row">
		<div class="large-12 columns">
			<hr />
			<div class="row">
				<div class="large-5 columns">
					<p>&copy; Copyright no one at all. Go to town.</p>
				</div>
				<div class="large-7 columns">
					<ul class="inline-list right">
						<li><a href="#">Section 1</a></li>
						<li><a href="#">Section 2</a></li>
						<li><a href="#">Section 3</a></li>
						<li><a href="#">Section 4</a></li>
						<li><a href="#">Section 5</a></li>
						<li><a href="#">Section 6</a></li>
					</ul>
				</div>
			</div>
		</div>




		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
      		$(document).foundation();
    		</script>
	</footer>

</body>
</html>