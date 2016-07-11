<div class="flash-container">
	<p><?php echo $message ?></p>
</div>

<script type="text/javascript">
	setTimeout(function () {
		$(".flash-container").slideUp();
	}, 1500);
</script>