<footer id="main-footer"><div class="footer-pads">All products and company names are trademarks™ or registered® trademarks of their respective holders</div></footer>
<?php $this->admin_footer_scripts();?>
	<script type="text/javascript">
	var hh = $('#main-header').innerHeight();
	var ff = $('#main-footer').height();
	var b = $(window).innerHeight();
	var c = b - hh - ff;
	$('#main-content').css('min-height',c);
</script>
</body>

</html>