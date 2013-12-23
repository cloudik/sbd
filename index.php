<?php
require('namespace.php');

$title = 'Curling games and results';
show_header($title);

?>

			<div class="jumbotron">
				<h1>Aktualnie toczące się spotkania:</h1>
				<!--<p></p>
				<p><a class="btn btn-primary btn-lg" role="button">Learn more</a></p>-->
			</div>

		
			<div class="marketing">
			
			
<?php
	$zawody = new Tournament($dbms, $host, $database, $port, $username, $password);
	$status = 'live';
	$zawody->getGamesWithStatus($status);

?>
			
				<div class="row">
					<div class="col-lg-4">
						
					</div><!-- /.col-lg-4 -->
					<div class="col-lg-4">
						
					</div><!-- /.col-lg-4 -->
					<div class="col-lg-4">
						
					</div><!-- /.col-lg-4 -->
				</div>
			</div>

		
		
	
	<?php
	show_footer();
	
	?>