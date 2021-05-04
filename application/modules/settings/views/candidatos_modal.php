<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/candidato.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Candidatos
	<br><small>Adicionar/Editar Candidato</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Nombres: *</label>
					<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $information?$information[0]["nombres"]:""; ?>" placeholder="Nombres" required >
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Apellidos: *</label>
					<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $information?$information[0]["apellidos"]:""; ?>" placeholder="Apellidos" required >
				</div>
			</div>
		
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="numeroIdentificacion">No. Identificación: *</label>
					<input type="text" id="numeroIdentificacion" name="numeroIdentificacion" class="form-control" value="<?php echo $information?$information[0]["numero_identificacion"]:""; ?>" max="2147483647" placeholder="No. Identificación" required >
				</div>
			</div>
		</div>

		<div class="row">	
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="email">Correo electrónico: *</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["correo"]:""; ?>" placeholder="Correo" />
				</div>
			</div>				
	
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Número Celular: *</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["numero_celular"]:""; ?>" placeholder="Número Celular" required >
				</div>
			</div>
				
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="id_role">Edad:</label>					
					<select name="edad" id="edad" class="form-control">
						<option value='' >Select...</option>
						<?php
						for ($i = 18; $i < 62; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $information[0]["edad"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
								<?php } ?>									
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="nivelAcademico">Último nivel académico alcanzado: </label>
					<select name="nivelAcademico" id="nivelAcademico" class="form-control">
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($nivelAcademico); $i++) { ?>
							<option value="<?php echo $nivelAcademico[$i]["id_nivel_academico"]; ?>" <?php if($information && $information[0]["fk_id_nivel_academico"] == $nivelAcademico[$i]["id_nivel_academico"]) { echo "selected"; }  ?>><?php echo $nivelAcademico[$i]["nivel_academico"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="profesion">Profesión: </label>
					<input type="text" id="profesion" name="profesion" class="form-control" value="<?php echo $information?$information[0]["profesion"]:""; ?>" placeholder="Profesión" >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="ciudad">Ciudad: </label>
					<input type="text" id="ciudad" name="ciudad" class="form-control" value="<?php echo $information?$information[0]["ciudad"]:""; ?>" placeholder="Ciudad" >
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="numeroProceso">Número Proceso: *</label>
					<select name="numeroProceso" id="numeroProceso" class="form-control" required>
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($procesos); $i++) { ?>
							<option value="<?php echo $procesos[$i]["id_proceso"]; ?>" <?php if($information && $information[0]["fk_id_proceso"] == $procesos[$i]["id_proceso"]) { echo "selected"; }  ?>><?php echo $procesos[$i]["numero_proceso"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
	<?php if($information){ ?>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="state">Estado: *</label>
					<select name="state" id="state" class="form-control" required>
						<option value=''>Seleccione...</option>
						<option value=1 <?php if($information[0]["estado_candidato"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado_candidato"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
	<?php } ?>
		
		</div>
		
		<div class="form-group">
			<div id="div_load" style="display:none">		
				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
						<span class="sr-only">45% completado</span>
					</div>
				</div>
			</div>
			<div id="div_error" style="display:none">			
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
			</div>	
		</div>

		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
						Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
				</div>
			</div>
		</div>
			
	</form>
</div>