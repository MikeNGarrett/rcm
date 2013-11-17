
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


		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf8">

		$(document).ready(function(){
		  $('#caseTable').dataTable();
		});
		</script>
            </div>
	</body>

</html>
