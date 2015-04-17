<!doctype html>
<html>
<head>
<meta charset="utf-8">

<title>Guestbook</title>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

<style>
body {
  padding-top: 60px;
}
@media (max-width: 979px) {
  body {
    padding-top: 35px;
  }
}
</style>
</head>
<body>
	<!-- Titlebar -->

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Guestbook</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			<?php if(isset($fullname)){
				//Logged In navigation
				?>
				<ul class="nav navbar-nav">
					<li ><a href="/">Home</a></li>
					<li><a href="/gaestebuch/bearbeiten">New Entry..</a></li>
					<li><a href="/user/logout">Logout</a></li>
				</ul> <?php }
				else {?>
				<ul class="nav navbar-nav">
					<li ><a href="/">Home</a></li>
					<li><a href="/user/login">Login</a></li>
					<li><a href="/user/register">Register</a></li>
				</ul>
				<?php } //End Else
				?>
			</div>
		
		</div>
	</nav>


	<!-- Main Content -->
	<div class="container">
		<div>
			<h1><?php echo $title; ?></h1>
		</div>
		<div>
					<?php $innercontent->display()?>
				
	</div>
	</div>

	<footer class="container navbar navbar-fixed-bottom">
		<p>Site by Elias Schmidhalter  <a href="https://github.com/calesanz/gibb-modul-151/">@Github</a></p>
		<script type="text/javascript" src="/assets/js/jquery-1.11.2.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</footer>

</body>
</html>