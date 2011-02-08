<div class="forum">

<?php if(isset($breadcrumbs)) { ?>
<div class="forum_meta">
	<div class="breadcrumbs">	
		<?php
		foreach($breadcrumbs as $name => $link)
		{
			print '<a href="'. $link. '">'. $name. '</a> &rsaquo; ';
		}
		?>
	</div>

	<div class="right">
		<?php if(isset($menu)) foreach($menu as $title => $link) print "<a href=\"$link\">$title</a> "; ?>
	</div>
</div>
<?php } ?>


<?php print $content; ?>

<?php /* Main Layout File Handles This
<?php if(isset($pagination)) { ?>
<div class="forum_meta">
	<?php print $pagination; ?>
</div>
<?php } ?>
*/ ?>

</div>