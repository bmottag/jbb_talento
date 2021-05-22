<script type="text/javascript" src="<?php echo base_url("assets/js/validate/formulario/aspectos.js"); ?>"></script>

<script>
function valid_inconvenientes() 
{

        var elementos = document.getElementsByName("pregunta[1]");
        var valor1 = 0;
        var valor2 = 0;
        var valor3 = 0;
        var valor4 = 0;
        var valor5 = 0;
        for(var i=0; i<elementos.length; i++) {
              if(elementos[i].checked){
                    valor1 = parseInt(elementos[i].value);
              }
        }

        var elementos = document.getElementsByName("pregunta[2]");
        for(var i=0; i<elementos.length; i++) {
              if(elementos[i].checked){
                     valor2 = parseInt(elementos[i].value);
              }
        }

        var elementos = document.getElementsByName("pregunta[3]");
        for(var i=0; i<elementos.length; i++) {
              if(elementos[i].checked){
                     valor3 = parseInt(elementos[i].value);
              }
        }

        var elementos = document.getElementsByName("pregunta[4]");
        for(var i=0; i<elementos.length; i++) {
              if(elementos[i].checked){
                     valor4 = parseInt(elementos[i].value);
              }
        }

        var elementos = document.getElementsByName("pregunta[5]");
        for(var i=0; i<elementos.length; i++) {
              if(elementos[i].checked){
                     valor5 = parseInt(elementos[i].value);
              }
        }

        sumar1 = document.getElementById('pregunta_1').value = valor1+valor2+valor3+valor4+valor5;

        if(sumar1 !== 15 && valor1 > 0 && valor2 > 0 && valor3 > 0 && valor4 > 0 && valor5 > 0 ){
            alert('Error en la pregunta 1. Solo se permite una respuesta por columna en cada pregunta.');
        }

}
</script>

<div id="page-wrapper">
	<br>	
	<!-- /.row -->

    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="<?php echo base_url('formulario'); ?>" class="btn btn-outline btn-default btn-block">
                    <i class="fa fa-user"></i> Información del Candidato
                </a>
                <a href="<?php echo base_url('formulario/habilidades'); ?>" class="btn btn-outline btn-default btn-block">
                    <i class="fa fa-edit"></i> Cuestionario Habilidades Sociales
                </a>
                <a href="<?php echo base_url('formulario/aspectos'); ?>" class="btn btn-success btn-block">
                    <i class="fa fa-edit"></i> Cuestionario Aspectos de Interes
                </a>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> <strong>Información del Proceso</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <p class="text-info"><strong> No. Proceso:</strong>
                            <span class="pull-right text-muted small"><?php echo $infoProceso[0]['numero_proceso']; ?>
                            </span>
                        </p>

                        <p class="text-info"><strong> Tipo Proceo:</strong>
                            <span class="pull-right text-muted small"><?php echo $infoProceso[0]['tipo_proceso']; ?>
                            </span>
                        </p>

                        <p class="text-info"><strong> Dependencia:</strong>
                            <span class="pull-right text-muted small"><?php echo $infoProceso[0]['dependencia']; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12">
<?php if($infoFormulario && $infoFormulario[0]['numero_parte_formulario'] == 4){ ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-7">  
                                    <i class="fa fa-edit"></i> <strong>CUESTIONARIO ASPECTOS DE INTERES PARA EL DESEMPEÑO LABORAL</strong>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row" align="center">
                                        <div style="width:70%;" align="center">
                                            <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>
                                                Se registraron sus respuestas
                                                <br><strong>Cuestionario Aspectos de Interes</strong>
                                                <br><br>
                                                <?php
                                                    $fechaInicio = $infoFormulario[0]['fecha_registro_inicio'];
                                                    $fechaFin = $infoFormulario[0]['fecha_registro_fin'];
                                                    echo '<strong>Fecha: </strong>';
                                                    echo strftime("%b %d, %G",strtotime($fechaInicio));
                                                    echo '<br>';
                                                    echo '<strong>Hora incicio prueba: </strong>';
                                                    echo strftime("%I:%M:%S %p",strtotime($fechaInicio));
                                                    echo '<br>';
                                                    echo '<strong>Hora finalización prueba: </strong>';
                                                    echo strftime("%I:%M:%S %p",strtotime($fechaFin));
                                                    echo '<br>';
                                                    echo '<strong>Duración: </strong>';
                                                    $date1 = new DateTime($fechaInicio);
                                                    $date2 = new DateTime($fechaFin);
                                                    $diff = $date1->diff($date2);
                                                    echo $diff->i . ' minuto(s)';
                                                ?>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
<?php }else{ ?>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-7">  
                                    <i class="fa fa-edit"></i> <strong>CUESTIONARIO ASPECTOS DE INTERES PARA EL DESEMPEÑO LABORAL</strong>
                                </div>

                            </div>
                        </div>
                        <div class="panel-body">
                            <small>
                                <p>
                                Este cuestionario tiene por objeto recoger una idea sobre aquellos aspectos de trabajo que son de interes para Ud y sobre las acciones que esta dispuesto a realizar para conseguirlas.Todas las respuestas son importantes, no hay respuestas buenas o malas , lo que cuenta es su sinceridad.
                                </p>

                                <p>
                                Esta prueba esta dividida en tres partes de cinco (5) items cada una y cada item con 5 opciones que Ud debe escoger de 5 a 1, siendo 5 la de mayor importancia y 1 la que menos le interesa. Solo permite una respuesta por columna, si está repetida o incompleta se muestra una alerta. 
                                </p>
                                <p class="text-danger text-left">Los campos con * son obligatorios.</p>
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="progress progress-striped active">
                            <?php 
                                $numeroParte =  $preguntasAspectosInteres[0]['numero_parte']; 
                                switch ($numeroParte) {
                                    case 1:
                                        $porcentaje = 30;
                                        $trxtoBoton = "Guardar - Página 1 de 3";
                                        break;
                                    case 2:
                                        $porcentaje = 55;
                                        $trxtoBoton = "Guardar - Página 2 de 3";
                                        break;
                                    case 3:
                                        $porcentaje = 80;
                                        $trxtoBoton = "Guardar - Página 3 de 3";
                                        break;
                                }
                            ?>
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje;?>%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
                                Parte <?php echo $numeroParte; ?>, Página <?php echo $numeroParte; ?> de 3
                            </div>
                        </div>
                    </div>  

<!-- INICIO FORMULARIO -->
                    <form  name="form" id="form" class="form-horizontal" method="post">
                        <input type="hidden" id="hddIdCandidato" name="hddIdCandidato" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>
                        <input type="hidden" id="hddIdFormAspectos" name="hddIdFormAspectos" value="<?php echo $idFormularioAspectos; ?>"/>
                        <input type="hidden" id="hddIdFormNoParte" name="hddIdFormNoParte" value="<?php echo $numeroParte; ?>"/>
                        <input type="hidden" id="hddIdTipoProceso" name="hddIdTipoProceso" value="<?php echo  $information?$information[0]["fk_id_tipo_proceso"]:""; ?>"/>

                    <?php 
                    $noPreguntas = 0;
                    foreach ($preguntasAspectosInteres as $lista):
                        $nombrePregunta = $lista['id_pregunta_aspecto_interes'];
                    ?>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <strong><?php echo $lista['numero_pregunta_aspecto_interes'] . '. ' . $lista['pregunta_aspecto_interes']; ?></strong>
                        </div>
                        <div class="panel-body">
                            <?php
                                //opciones de las preguntas
                                $arrParam = array('idPregunta' => $lista['id_pregunta_aspecto_interes']);
                                $opcionesPreguntas = $this->general_model->get_opciones_preguntas_aspectos_interes($arrParam);
                                $noPreguntas = count($opcionesPreguntas) + $noPreguntas;//se utiliza al guardar las respuestas
                                $noProximaPregunta = $infoFormulario[0]['numero_proxima_pregunta']; //se utiliza para llevar control de la ultima pregunta que va el usuario
                            ?>
                            <small><p class="text-danger text-left">* 1 la de menor importancia, 5 la de mayor importancia.</p></small>
                            <?php 
                            foreach ($opcionesPreguntas as $opciones):
                                $nombreOpcion = $opciones['id_opciones_aspectos_interes'];
                            ?>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-7">
                                        <?php echo $opciones['opcion']; ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombreOpcion]"; ?>" id="<?php echo $nombreOpcion . '_1'; ?>" value=1 onclick="valid_inconvenientes()"><small class="text-primary"><strong>1</strong></small>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombreOpcion]"; ?>" id="<?php echo $nombreOpcion . '_2'; ?>" value=2 onclick="valid_inconvenientes()"><small class="text-primary"><strong>2</strong></small>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombreOpcion]"; ?>" id="<?php echo $nombreOpcion . '_3'; ?>" value=3 onclick="valid_inconvenientes()"><small class="text-primary"><strong>3</strong></small>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombreOpcion]"; ?>" id="<?php echo $nombreOpcion . '_4'; ?>" value=4 onclick="valid_inconvenientes()"><small class="text-primary"><strong>4</strong></small>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombreOpcion]"; ?>" id="<?php echo $nombreOpcion . '_5'; ?>" value=5 onclick="valid_inconvenientes()"><small class="text-primary"><strong>5</strong></small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php
                                endforeach;
                            ?>
                            <input type="hidden" name="<?php echo 'pregunta_' . $nombrePregunta; ?>" id="<?php echo 'pregunta_' . $nombrePregunta; ?>" />
                        </div>
                    </div>

                    <?php
                        endforeach;
                    ?>

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
                                    <div class="alert alert-danger" id="span_msj"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row" align="center">
                            <div style="width:50%;" align="center">
                                <button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-success'>
                                            <?php echo $trxtoBoton; ?> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hddNoPreguntas" name="hddNoPreguntas" value="<?php echo $noPreguntas; ?>"/>
                    <input type="hidden" id="hddNoProximaPregunta" name="hddNoProximaPregunta" value="<?php echo $noProximaPregunta; ?>"/>
                    </form>
<!-- FIN FORMULARIO -->
<?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->