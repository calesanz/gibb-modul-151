
<ul>
<?php
foreach ( $entries as $entry ) {
	?>
	<div class="row">
		<div class="large-2 columns small-3">
			<img src="http://placehold.it/80x80&text=[img]" />
		</div>
		<div class="large-10 columns">
			<div class="panel">
	<?php
	echo "<strong>[ $entry->CreatedAt ] " . $entry->User->FullName . ": </strong>";
	echo "<p>$entry->Text </p>";
	?>
							
			</div>
			<ul class="inline-list">
				<li><a href="">Reply</a></li>
				<li><a href="">Share</a></li>
			</ul>

		</div>
	</div>
	
	<?php
}
?>
</ul>
