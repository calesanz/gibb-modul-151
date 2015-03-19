<!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Guestbook</title>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

</head>
<body>
	<!-- Titlebar -->

	<div class="container">
		<h1><?php echo $title; ?></h1>
	</div>

	<!-- Main Content -->
	<div class="container">
		<div>
					<?php $innercontent->display()?>
				</div>
	</div>

	
	<footer>
	
	<script type="text/javascript" src="/assets/js/jquery-1.11.2.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</footer>

</body>
</html>