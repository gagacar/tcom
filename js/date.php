<script>
	$(function() {
		$( "#released" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "-120:+0",
			showWeek: true,
			firstDay: 1
		});
		$( "#released" ).datepicker( "option", "dateFormat", "dd.mm.yy"  ); 
	}); 
</script>

