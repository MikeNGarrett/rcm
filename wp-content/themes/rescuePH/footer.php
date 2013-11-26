
<div id="push"></div>
</div>
<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="container">

					<nav role="navigation">
							<?php bones_footer_links(); ?>
					</nav>

					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Built at <a href="https://geekli.st/hackathon/52793a2660fb3f52d50001f8">Geeklist #hack4good 0.4</a></p>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf8">

		$(document).ready(function(){
		  if($('body').hasClass('home') || $('body').hasClass('archive')) {
			  var dTable = $('#caseTable').dataTable({
				"aoColumnDefs": [
				  { "bSortable": false, "aTargets": [ 0, 2, 5, 6 ] },
				  { "bSearchable": false, "aTargets": [ 0,1,3,4 ] },
				  { "sType": "date", "aTargets": [ 4 ] },
				  { "sType": "html", "aTargets": [ 2,5,6 ] },
				  { "sWidth": "25%", "aTargets": [ 2,4 ] },
				  { "sWidth": "10%", "aTargets": [ 3,5, 6 ] }
				] } );
	    	  dTable.fnSort( [ [4,'desc'] ] );
    	  }
		});
		</script>
		<script>
		  var nav = responsiveNav(".nav-collapse");
		</script>
            </div>
	</body>

</html>
