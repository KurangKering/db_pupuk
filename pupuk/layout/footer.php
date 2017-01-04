     </div>
 </div>


 <footer class="footer">
 	<div class="container-fluid">

 		<p class="copyright pull-right">
 			&copy; 2016 Kelompok RPL
 		</p>
 	</div>
 </footer>
</div>
</div>

<!--===================================================-->
<script type="text/javascript" language="javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/jqueryui/jquery-ui.min.js"></script>
<script src="assets/plugins/dataTables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/dataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/chartjs/chart.js"></script>
<script src="assets/plugins/validator/validator.min.js"></script>



<script>
		$( function() {
			$( ".form-date" ).datepicker({
				yearRange: '1945:2016',
				changeYear: true,
				changeMonth: true,
				dateFormat: 'yy-mm-dd'
			});

		} );
</script>
<?php if (isset($js_tambahan)) echo $js_tambahan; ?>

</body>
</html>
