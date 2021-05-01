<script type="text/javascript" src="<?php echo base_url("assets/js/validate/formulario/habilidades.js"); ?>"></script>

<script>
    var end = new Date();
    var sumarsesion = 15;
    var minutes = end.getMinutes();

    end.setMinutes(minutes + sumarsesion);//adiciono 15 min a la fecha actual
    
    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();

        var distance = end - now;
        if (distance < 0) 
        {
            clearInterval(timer);
            //habilitar horario
            var idHorario = $('#hddIdHorario').val();
            $.ajax ({
                type: 'POST',
                url: base_url + 'calendario/habilitar',
                data: {'idHorario': idHorario},
                cache: false,
                success: function (data)
                {
                    $('#company').html(data);
                }
            });
            //deshabilitar y limpiar campos
            $('#btnSubmit').attr('disabled','-1');
            document.getElementById('countdown').innerHTML = 'Su sesión expiró!';
            alert("Su sesión expiró.");

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        seconds = actualizarHora(seconds);    

        //document.getElementById('countdown').innerHTML = days + ' dias, ';
        //document.getElementById('countdown').innerHTML += hours + ' horas, ';
        document.getElementById('countdown').innerHTML = 'Tiempo Restante: ' + minutes + ':' + seconds;
        //document.getElementById('countdown').innerHTML += seconds + ' segundos';
    }

    function actualizarHora(i) {
        if (i<10) {i = "0" + i};  // Añadir el cero en números menores de 10
            return i;
    }

    timer = setInterval(showRemaining, 1000);
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
                <a href="<?php echo base_url('formulario/habilidades'); ?>" class="btn btn-success btn-block">
                    <i class="fa fa-edit"></i> Cuestionario Habilidades Sociales
                </a>
                <a href="<?php echo base_url('formulario/aspectos'); ?>" class="btn btn-outline btn-default btn-block">
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
<?php if($infoFormulario && $infoFormulario[0]['numero_parte_formulario'] == 2){ ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-7">  
                                    <i class="fa fa-edit"></i> <strong>CUESTIONARIO DE HABILIDADES SOCIALES</strong>
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
                                                <br><strong>Cuestionario de Habilidades Sociales</strong>
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
                                    <i class="fa fa-edit"></i> <strong>CUESTIONARIO DE HABILIDADES SOCIALES</strong>
                                </div>
                                <div class="col-lg-5" align="right">  
                                    <div style="color:red; font-family: verdana, arial;" id="countdown"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <small>
                                <p>Proceso de valoración candidatos Jardín botánico de Bogotá
                                <br>
                                Este cuestionario tiene un tiempo límite de 15 minutos. Si ve que el tiempo se le agota, envíe sus respuestas (así no haya terminado) con el botón "Enviar".
                                </p>
                                <p class="text-danger text-left">Los campos con * son obligatorios.</p>
                            </small>
                        </div>
                    </div>

<!-- INICIO FORMULARIO -->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            A continuación encontrará una lista de habilidades que las personas usan en su vida diaria, señale su respuesta seleccionando una de las alternativas que se ubica en la columna derecha. 
                            <br>Recuerde que su sinceridad es muy importante, no hay respuestas buenas ni malas, asegúrese de contestar todas.
                        </div>
                        <div class="panel-body">

                        <form  name="form" id="form" class="form-horizontal" method="post">
                            <input type="hidden" id="hddIdCandidato" name="hddIdCandidato" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>
                            <input type="hidden" id="hddIdFormHabilidades" name="hddIdFormHabilidades" value="<?php echo $idFormularioHabilidades; ?>"/>
                            <input type="hidden" id="hddIdTipoProceso" name="hddIdTipoProceso" value="<?php echo  $information?$information[0]["fk_id_tipo_proceso"]:""; ?>"/>
                            <input type="hidden" id="hddIdFormNoParte" name="hddIdFormNoParte" value=1 />
                            <input type="hidden" id="hddIdNoPreguntas" name="hddIdNoPreguntas" value="<?php echo $noPreguntas; ?>"/>
                            <?php 
                            foreach ($preguntasHabilidades as $lista):
                                $nombrePregunta = $lista['id_pregunta_habilidad'];
                            ?>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <ol start=<?php echo $lista['id_pregunta_habilidad']; ?>><li><?php echo $lista['pregunta_habilidad']; ?> </li></ol>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_1'; ?>" value=<?php echo $lista['valor_nunca']; ?>><strong>Nunca</strong>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_2'; ?>" value=<?php echo $lista['valor_rara_vez']; ?> ><strong>Rara vez</strong>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_3'; ?>" value=<?php echo $lista['valor_a_veces']; ?> ><strong>A veces</strong>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_4'; ?>" value=<?php echo $lista['valor_a_menudo']; ?> ><strong>A menudo</strong>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_5'; ?>" value=<?php echo $lista['valor_siempre']; ?> ><strong>Siempre</strong>
                                        </label>
                                    </div>
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
                                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                            <div class="form-group">
                                <div class="row" align="center">
                                    <div style="width:100%;" align="center">                            
                                        <button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-success'>
                                            Enviar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        </div>
                    </div>
<!-- FIN FORMULARIO -->
<?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->