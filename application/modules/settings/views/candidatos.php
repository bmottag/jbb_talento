<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/settings/cargarModalCandidatos',
                data: {'idCandidato': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});

function seleccionar_todo(){
   for (i=0;i<document.form_disponibilidad.elements.length;i++)
      if(document.form_disponibilidad.elements[i].type == "checkbox")
         document.form_disponibilidad.elements[i].checked=1
} 


function deseleccionar_todo(){
   for (i=0;i<document.form_disponibilidad.elements.length;i++)
      if(document.form_disponibilidad.elements[i].type == "checkbox")
         document.form_disponibilidad.elements[i].checked=0
} 
</script>


<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-briefcase  fa-fw"></i> CONFIGURACIÓN - CANDIDATOS
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
					<i class="fa fa-briefcase"></i> LISTA DE CANDIDATOS
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills">
						<li <?php if($state == 1){ echo "class='active'";} ?>><a href="<?php echo base_url('settings/candidatos/1'); ?>">Lista de Candidatos Activos</a>
						</li>
						<li <?php if($state == 2){ echo "class='active'";} ?>><a href="<?php echo base_url('settings/candidatos/2'); ?>">Lista de Candidatos Inactivos</a>
						</li>
					</ul>
					<br>

					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Candidato
					</button><br>
<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
?>
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
<?php
	}
	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
?>
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
<?php
	}
?> 

				<?php
					if($infoCandidatos){
				?>				
<form  name="form_disponibilidad" id="form_disponibilidad" method="post" action="<?php echo base_url("settings/bloquear_candidatos/".$state); ?>">
				<p>
				<a href="javascript:seleccionar_todo()">Marcar Todos</a> |
				<a href="javascript:deseleccionar_todo()">Desmarcar Todos</a>
				</p>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
                                <th class='text-center'>Nombres</th>
                                <th class='text-center'>Apellidos</th>
                                <th class='text-center'>No. Identificación</th>
                                <th class='text-center'>Correo Electrónico</th>
                                <th class='text-center'>Nivel Académico</th>
                                <th class='text-center'>Proceso Actual</th>
                                <th class='text-center'>Editar</th>
                                <th class='text-center'>Estado<br>
<button type="submit" class="btn btn-primary btn-xs" id="btnSubmit2" name="btnSubmit2" >
	Bloquear/Desbloquear <span class="glyphicon glyphicon-edit" aria-hidden="true">
</button>
                                </th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoCandidatos as $lista):
								echo '<tr>';
                                echo '<td>' . $lista['nombres'] . '</td>';
                                echo '<td>' . $lista['apellidos'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td>' . $lista['correo'] . '</td>';
                                echo '<td class="text-center">' . $lista['nivel_academico'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_proceso'] . '</td>';
								echo '<td class="text-center">';
					?>
								<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_candidato']; ?>" >
									Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>
					<?php
								echo '</td>';
                                echo '<td class="text-center">';
                                switch ($lista['estado_candidato']) {
                                    case 1:
                                        $valor = 'ACTIVO';
                                        $clase = "text-success";
                                        $disponibilidad = TRUE;
                                        break;
                                    case 2:
                                        $valor = 'INACTIVO';
                                        $clase = "text-danger";
                                        $disponibilidad = FALSE;
                                        break;
                                }
                                echo '<p class="' . $clase . '"><strong>' . $valor . '</strong>';

								$data = array(
									'name' => 'disponibilidad[]',
									'id' => 'disponibilidad',
									'value' => $lista['id_candidato'],
									'checked' => $disponibilidad,
									'style' => 'margin:10px'
								);
								echo form_checkbox($data);

                                echo '</p></td>';
                                echo '</tr>';
							endforeach;
						?>
						</tbody>
					</table>
</form>
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
		
				
<!--INICIO Modal para adicionar HAZARDS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar HAZARDS -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 100
	});
});
</script>