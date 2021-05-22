<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/puntajes.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Puntajes del Candidato
	<br><small>Adicionar/Editar Puntajes</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdCandidato" name="hddIdCandidato" value="<?php echo $idCandidato; ?>"/>
		<input type="hidden" id="hddIdPuntaje" name="hddIdPuntaje" value="<?php echo $infoPuntajes?$infoPuntajes[0]['id_puntaje']:""; ?>" />
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="puntajeRequisitosMinimos">Puntaje Requisitos Mínimos: </label>
					<input type="number" id="puntajeRequisitosMinimos" name="puntajeRequisitosMinimos" class="form-control" value="<?php echo $infoPuntajes?$infoPuntajes[0]["puntaje_requisitos_minimos"]:""; ?>" placeholder="Puntaje Requisitos Mínimos" >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="resultadoPruebaPsicotecnica">Resultado Prueba Psicotécnica: </label>
					<input type="number" id="resultadoPruebaPsicotecnica" name="resultadoPruebaPsicotecnica" class="form-control" value="<?php echo $infoPuntajes?$infoPuntajes[0]["resultado_prueba_psicotecnica"]:""; ?>" placeholder="Resultado Prueba Psicotécnica" >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
						<small><br>
							<p class="text-danger text-left">Hasta 90 por la escala máxima establecida.
								<br>Puntaje sobre 20%
							</p>
						</small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="reultadoEntrevista">Resultado Entrevista: </label>
					<input type="number" id="reultadoEntrevista" name="reultadoEntrevista" class="form-control" value="<?php echo $infoPuntajes?$infoPuntajes[0]["resultado_entrevista"]:""; ?>" placeholder="Resultado Entrevista" >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
						<small><br>
							<p class="text-danger text-left">Hasta 80 por la escala máxima establecida.
								<br>Puntaje sobre 30%
							</p>
						</small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="criterioEtnias">Criterio Dif. Etnias: </label>
					<input type="number" id="criterioEtnias" name="criterioEtnias" class="form-control" value="<?php echo $infoPuntajes?$infoPuntajes[0]["criterio_etnias"]:""; ?>" placeholder="Criterio Dif. Etnias" >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
						<small><br>
							<p class="text-danger text-left">Hasta 10 por la escala máxima de afinidad.
								<br>Puntaje sobre 10%
							</p>
						</small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="criterioDesarrollo">Criterio Dif. Desarrollo Objeto: </label>
					<input type="number" id="criterioDesarrollo" name="criterioDesarrollo" class="form-control" value="<?php echo $infoPuntajes?$infoPuntajes[0]["criterio_desarrollo"]:""; ?>" placeholder="Criterio Dif. Desarrollo Objeto" >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
						<small><br>
							<p class="text-danger text-left">Hasta 10 por la escala máxima de afinidad.
								<br>Puntaje sobre 10%
							</p>
						</small>
				</div>
			</div>
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