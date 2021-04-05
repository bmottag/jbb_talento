<script type="text/javascript" src="<?php echo base_url("assets/js/validate/formulario/candidato.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">

		<div class="col-lg-3">
				
			<div class="list-group">
				<a href="<?php echo base_url('formulario'); ?>" class="btn btn-success btn-block">
					<i class="fa fa-user"></i> Información del Candidato
				</a>
				<a href="<?php echo base_url('formulario/habilidades'); ?>" class="btn btn-outline btn-default btn-block">
					<i class="fa fa-tags"></i> Cuestionario Habilidades Sociales
				</a>
				<a href="<?php echo base_url('equipos/foto/'); ?>" class="btn btn-outline btn-default btn-block">
					<i class="fa fa-photo"></i> Cuestionario Aspectos de Interes
				</a>
			</div>


            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> INFO PROCESO
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag fa-fw"></i><strong> No. Proceso</strong>
                                <span class="pull-right text-muted small"><?php echo $infoProceso[0]['numero_proceso']; ?>
                                </span>
                            </p>
                        </a>

                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag  fa-fw"></i><strong> Tipo Proceo</strong>
                                <span class="pull-right text-muted small"><?php echo $infoProceso[0]['tipo_proceso']; ?>
                                </span>
                            </p>
                        </a>

                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag  fa-fw"></i><strong> Dependencia:</strong>
                                <span class="pull-right text-muted small"><?php echo $infoProceso[0]['dependencia']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                    <!-- /.list-group -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
		</div>

		<div class="col-lg-9">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-user"></i> <strong>INFORMACIÓN DEL CANDIDATO</strong>
                </div>
                <div class="panel-body">

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
                
				<form  name="form" id="form" class="form-horizontal" method="post">
				    <input type="hidden" id="hddIdCandidato" name="hddIdCandidato" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="numero_inventario">Nombres: *</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $information?$information[0]["nombres"]:""; ?>" placeholder="Nombres" required >
                            </div>

                            <div class="col-sm-4">
                                <label for="dependencia">Apellidos: *</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $information?$information[0]["apellidos"]:""; ?>" placeholder="Apellidos" required >
                            </div>

                            <div class="col-sm-4">
                                <label for="dependencia">No. Identificación: *</label>
                                <input type="text" id="numeroIdentificacion" name="numeroIdentificacion" class="form-control" value="<?php echo $information?$information[0]["numero_identificacion"]:""; ?>" placeholder="No. Identificación" disabled >
                            </div>  
                        </div>
                                                
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="marca">Correo: *</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["correo"]:""; ?>" placeholder="Correo" />
                            </div>
                            
                            <div class="col-sm-4">
                                <label for="modelo">Número Celular: *</label>
                                <input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["numero_celular"]:""; ?>" placeholder="Número Celular" required >
                            </div>  

                            <div class="col-sm-4">
                                <label for="modelo">Edad: *</label>
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

                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="numero_inventario">Último nivel académico alcanzado: *</label>
                                <select name="nivelAcademico" id="nivelAcademico" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php for ($i = 0; $i < count($nivelAcademico); $i++) { ?>
                                        <option value="<?php echo $nivelAcademico[$i]["id_nivel_academico"]; ?>" <?php if($information && $information[0]["fk_id_nivel_academico"] == $nivelAcademico[$i]["id_nivel_academico"]) { echo "selected"; }  ?>><?php echo $nivelAcademico[$i]["nivel_academico"]; ?></option>    
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="dependencia">Profesión: *</label>
                                <input type="text" id="profesion" name="profesion" class="form-control" value="<?php echo $information?$information[0]["profesion"]:""; ?>" placeholder="Profesión" >
                            </div>

                            <div class="col-sm-4">
                                <label for="dependencia">Ciudad: *</label>
                                <input type="text" id="ciudad" name="ciudad" class="form-control" value="<?php echo $information?$information[0]["ciudad"]:""; ?>" placeholder="Ciudad" >
                            </div>  
                        </div>

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
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
							</div>
						</div>	

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">							
									<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-success'>
										Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
									</button>
								</div>
							</div>
						</div>

					</form>

                </div>
            </div>
		</div>
		
					
	</div>
	
</div>
<!-- /#page-wrapper -->