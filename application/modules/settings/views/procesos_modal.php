<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/proceso.js"); ?>"></script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Procesos
	<br><small>Adicionar/Editar Proceso</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_proceso"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="numeroProceso">Número Proceso: *</label>
					<input type="text" id="numeroProceso" name="numeroProceso" class="form-control" value="<?php echo $information?$information[0]["numero_proceso"]:""; ?>" placeholder="Número Proceso" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="id_tipo_proceso">Tipo Proceso: *</label>
					<select name="id_tipo_proceso" id="id_tipo_proceso" class="form-control" required>
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($tipoProceso); $i++) { ?>
							<option value="<?php echo $tipoProceso[$i]["id_tipo_proceso"]; ?>" <?php if($information && $information[0]["fk_id_tipo_proceso"] == $tipoProceso[$i]["id_tipo_proceso"]) { echo "selected"; }  ?>><?php echo $tipoProceso[$i]["tipo_proceso"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="id_dependencia">Dependencia: *</label>
					<select name="id_dependencia" id="id_dependencia" class="form-control" required>
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($dependencias); $i++) { ?>
							<option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if($information && $information[0]["fk_id_dependencia"] == $dependencias[$i]["id_dependencia"]) { echo "selected"; }  ?>><?php echo $dependencias[$i]["dependencia"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
	<?php if($information){ ?>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado: *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Seleccione...</option>
						<option value=1 <?php if($information[0]["estado_proceso"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado_proceso"] == 2) { echo "selected"; }  ?>>Inactivo</option>
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