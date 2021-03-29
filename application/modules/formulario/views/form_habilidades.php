<script type="text/javascript" src="<?php echo base_url("assets/js/validate/formulario/habilidades.js"); ?>"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
posicionarMenu();
 
$(window).scroll(function() {    
    posicionarMenu();
});
 
function posicionarMenu() {
    var altura_del_header = $('.header').outerHeight(true);
    var altura_del_menu = $('.menu').outerHeight(true);
 
    if ($(window).scrollTop() >= altura_del_header){
        $('.menu').addClass('fixed');
        $('.wrapper').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('.menu').removeClass('fixed');
        $('.wrapper').css('margin-top', '0');
    }
}
 
</script>

<script>
    var end = new Date();
    var sumarsesion = 15;
    var minutes = end.getMinutes();

    end.setMinutes(minutes + sumarsesion);//adiciono 5 min a la fecha actual
    
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
            $('#email').attr('disabled','-1');
            $('#confirmarEmail').attr('disabled','-1');
            $('#celular').attr('disabled','-1');
            $("#email").val('');
            $("#confirmarEmail").val('');
            $("#celular").val('');
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

<style type="text/css">
body, html{ margin:0; padding:0;}
    .header{ border-top:1px solid white;background:white; color:#333; height:150px; width:100%; font-family: 'Lobster', cursive; text-align:center}
    .menu{ height:80px; width:100%; background:#333; color:white; text-align:center}
    .wrapper{ height:2000px; width:100%; padding-top:20px}
     
    .fixed{position:fixed; top:0}
</style>

<div id="page-wrapper">
	<br>	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">	

            <div class="row" align="center">
                <div style="width:70%;" align="center">
                    <img src="<?php echo base_url('images/banner_principal.png'); ?>" class="img-rounded" width="770" height="120" alt="QR CODE" />
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <!-- /.col-lg-4 -->
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-7">  
                            <h4>CUESTIONARIO DE HABILIDADES SOCIALES</h4>
                        </div>
                        <div class="col-lg-5" align="right">  
                            <h4><div style="color:red; font-family: verdana, arial;" id="countdown"></div></h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <small>
                        <p>Proceso de valoración candidatos Jardín botánico de Bogotá
                        <br><br>
                        Este cuestionario tiene un tiempo límite de 15 minutos. Si ve que el tiempo se le agota, envíe sus respuestas (así no haya terminado) con el botón "enviar".
                        </p>
                    </small>
                </div>
                <div class="panel-footer">
                    <small><p class="text-danger text-left">Los campos con * son obligatorios.</p></small>
                </div>
            </div>
        </div>

        <div class="col-lg-2"></div>
    </div>
<form  name="form" id="form" class="form-horizontal" method="post">
    <input type="hidden" id="hddIdFormulario" name="hddIdFormulario" value=""/>
    <input type="hidden" id="hddIdCandidato" name="hddIdCandidato" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-book"></i> <strong>INFORMACIÓN DEL CANDIDATO</strong>
                    <br>Número Proceso: <strong><?php echo $information?$information[0]["numero_proceso"]:""; ?></strong>
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

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-info">
                <div class="panel-heading"><?php $information =false; ?>
                    A continuación encontrará una lista de habilidades que las personas usan en su vida diaria, señale su respuesta seleccionando una de las alternativas que se ubica en la columna derecha. Recuerde que su sinceridad es muy importante, no hay respuestas buenas ni malas, asegúrese de contestar todas.
                </div>
                <div class="panel-body">

                    <?php 
                    foreach ($preguntasHabilidades as $lista):
                        $nombrePregunta = $lista['id_pregunta_habilidad'];
                    ?>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-5 control-label" for="<?php echo $nombrePregunta; ?>"><ol start=<?php echo $lista['id_pregunta_habilidad']; ?>><li><?php echo $lista['pregunta_habilidad']; ?> </li></ol></label>
                            <div class="col-sm-7">
                                <label class="radio-inline">
                                    <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_1'; ?>" value=1 <?php if($information && $information[0][$nombrePregunta] == 1) { echo "checked"; }  ?>><small class="text-primary"><strong>Nunca</strong></small>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_2'; ?>" value=2 <?php if($information && $information[0][$nombrePregunta] == 2) { echo "checked"; }  ?>><small class="text-primary"><strong>Rara vez</strong></small>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_3'; ?>" value=3 <?php if($information && $information[0][$nombrePregunta] == 3) { echo "checked"; }  ?>><small class="text-primary"><strong>A veces</strong></small>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_4'; ?>" value=4 <?php if($information && $information[0][$nombrePregunta] == 4) { echo "checked"; }  ?>><small class="text-primary"><strong>A menudo</strong></small>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="<?php echo "pregunta[$nombrePregunta]"; ?>" id="<?php echo $nombrePregunta . '_5'; ?>" value=5 <?php if($information && $information[0][$nombrePregunta] == 5) { echo "checked"; }  ?>><small class="text-primary"><strong>Siempre</strong></small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
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
</form>

</div>
<!-- /#page-wrapper -->