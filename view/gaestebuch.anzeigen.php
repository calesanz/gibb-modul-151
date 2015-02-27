
<ul>
<?php
foreach ( $entries as $entry ) {
	?>
	<div class="row">

		<div class="large-10 columns panel">
			<div>
	<?php
	echo "[ $entry->CreatedAt ] <strong>" . $entry->User->FullName . ": </strong>";
	echo "<p>$entry->Text </p>";
	?>
							
			</div>
			<ul class="inline-list">
				<li><a href="">Edit</a></li>

			</ul>

		</div>
	</div>
	
	<?php
}
?>
</ul>
