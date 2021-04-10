<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<a class="btn btn-success btn-xs" href=" <?php echo base_url('dashboard/admin'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Dashboard </a> 
					<i class="fa fa-list-ul"></i> <strong>RESPUESTAS CUESTIONARIO ASPECTOS DE INTERES PARA EL DESEMPEÑO LABORAL</strong>
				</div>
				<div class="panel-body">
				
					<div class="alert alert-success">
						<strong>Candidato: </strong><?php echo $infoFormulario[0]['nombres']; ?>
						<br><strong>No. Identificación: </strong> <?php echo $infoFormulario[0]['numero_identificacion']; ?>
						<br><strong>No. Proceso: </strong> <?php echo $infoFormulario[0]['numero_proceso']; ?>
						<br><strong>No. Formulario: </strong> <?php echo $infoFormulario[0]['id_form_aspectos_interes']; ?>
						<br><strong>Fecha Registro </strong> <?php echo $infoFormulario[0]['fecha_registro_inicio']; ?>
						<?php if($infoFormulario){ ?>
						<br><strong>Descargar Respuestas: </strong>
						<a href='<?php echo base_url('reportes/generaReservaPDF/' . $infoFormulario[0]['id_candidato'] ); ?>' target="_blank">PDF <img src='<?php echo base_url_images('pdf.png'); ?>' ></a>
						<?php } ?>
					</div>
					<br>

				<?php
				    if(!$infoRespuestas){ 
				?>
				        <div class="col-lg-12">
				            <small>
				                <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No hay registros en la base de datos.</p>
				            </small>
				        </div>
				<?php
				    }else{
				?>

					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>#</th>
								<th class='text-center'>Pregunta</th>
								<th class='text-center'>Respuesta</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoRespuestas as $lista):
								echo '<tr>';
								echo '<td class="text-center">' . $lista['codigo'] . '</td>';
								echo '<td>' . $lista['opcion'] . '</td>';
								echo '<td class="text-center">' . $lista['respuesta_aspectos_interes'] . '</td>';
								echo '</tr>';
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>

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
		 "ordering": false,
		 paging: false,
		"searching": false,
		"info": false
    });
});
</script>