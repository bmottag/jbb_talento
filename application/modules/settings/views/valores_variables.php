<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIÓN - VALORES VARIABLES POR TIPO DE PROCESO
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-users"></i> LISTA DE VALORES VARIABLES POR TIPO DE PROCESO - <strong><?php echo $info[0]['tipo_proceso']; ?></strong>
				</div>
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="text-center">Competencia</th>
								<th class="text-center">Variable</th>
								<th class="text-center">Sumatoria</th>
								<th class="text-center">Media</th>
								<th class="text-center">DS</th>
								<th class="text-center">Alto</th>
								<th class="text-center">Bajo</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									$alto = $lista['media'] + $lista['desviacion_estandar'];
									$bajo = $lista['media'] - $lista['desviacion_estandar'];

									echo "<tr>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $lista['id_competencias_relacion'] . "</strong></td>";
									echo "<td class='" . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $lista['competencia'] . "</strong></td>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $lista['sigla'] . '-' . $lista['descripcion'] . "<strong></td>";
									echo "<td class='" . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'>" . $lista['formula'] . "</td>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $lista['media'] . "<strong></td>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $lista['desviacion_estandar'] . "<strong></td>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $alto. "<strong></td>";
									echo "<td class='text-center " . $lista['estilo_texto']  . " text-" . $lista['estilo_texto'] . "'><strong>" . $bajo . "<strong></td>";
									echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 50
	});
});
</script>