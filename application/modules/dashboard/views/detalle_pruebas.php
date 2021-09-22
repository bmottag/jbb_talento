<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){
    $(".btn-info").click(function () {
        var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
            url: base_url + 'dashboard/cargarModalPuntajes',
            data: {'idCandidato': oID, 'idPuntaje': 'x'},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
    });
    $(".btn-default").click(function () {
        var oID = $(this).attr("id");
        $.ajax ({
            type: 'POST',
            url: base_url + 'dashboard/cargarModalPuntajes',
            data: {'idCandidato': '', 'idPuntaje': oID},
            cache: false,
            success: function (data) {
                $('#tablaDatos').html(data);
            }
        });
    });
});
</script>

<div id="page-wrapper">
    <div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD / Puntajes Candidatos / No. Proceso: <strong><?php echo  $infoProcesos[0]['numero_proceso']; ?></strong>
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
    </div>
								
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-list-ul"></i> <strong>CANDIDATOS ACTIVOS</strong>
                    <div class="pull-right">
                        <div class="btn-group">
<a class="btn btn-primary btn-xs" href='<?php echo base_url('reportes/generaReporteFinalXLS/' . $infoProcesos[0]['id_proceso']) ?>' target='_blank'><i class="fa fa-file-excel-o"></i> Descargar Reporte Final</a>
                        </div>
                    </div>                       
                </div>
                <!-- /.panel-heading -->
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


<?php
    if(!$infoCandidatos){ 
?>
        <div class="col-lg-12">
            <small>
                <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No hay Procesos activos.</p>
            </small>
        </div>
<?php
    }else{
?>                      

                    <table width="100%" class="table table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th class='text-center'>No. Identificación</th>
                                <th class='text-center'>Puntaje Experiencia Profesional</th>
                                <th class='text-center'>Puntaje Estudios Adicionales</th>
                                <th class='text-center'>Resultado Prueba Psicotécnica</th>
                                <th class='text-center'>Resultado Entrevista</th>
                                <th class='text-center'>Criterio Dif. Etnias</th>
                                <th class='text-center'>Criterio Dif. Desarrollo Objeto</th>
                                <th class='text-center'>Puntaje TOTAL</th>
                                <th class='text-center'>% TOTAL</th>
                                <th class='text-center'>Subir Puntajes</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            foreach ($infoCandidatos as $lista):
                                $puntajeTotal = $lista['puntaje_experiencia'] + $lista['puntaje_adicionales'] + $lista['resultado_prueba_psicotecnica'] + $lista['resultado_entrevista'] + $lista['criterio_etnias'] + $lista['criterio_desarrollo'];
                                $porcetajeExperiencia = $lista['puntaje_experiencia'] * 20 / 70;
                                $porcentajePsicotecnica = $lista['resultado_prueba_psicotecnica'] * 20 / 90;
                                $porcentajeEntrevista = $lista['resultado_entrevista'] * 30 / 80;
                                $porcentajeTotal = $porcetajeExperiencia + $lista['puntaje_adicionales'] + $porcentajePsicotecnica + $porcentajeEntrevista + $lista['criterio_etnias'] + $lista['criterio_desarrollo'];

                                echo '<tr>';
                                echo '<td>' . $lista['nombres'] . ' ' . $lista['apellidos'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td class="text-center">';
                                echo number_format($lista['puntaje_experiencia'],1);
                                echo '<br>' .  number_format($porcetajeExperiencia, 1) . '%';
                                echo '</td>';
                                echo '<td class="text-center">';
                                echo number_format($lista['puntaje_adicionales'],1);
                                echo '<br>' .  number_format($lista['puntaje_adicionales'], 1) . '%';
                                echo '</td>';
                                echo '<td class="text-center">';
                                echo number_format($lista['resultado_prueba_psicotecnica'],1);
                                echo '<br>' .  number_format($porcentajePsicotecnica, 1) . '%';
                                echo '</td>';
                                echo '<td class="text-center">';
                                echo number_format($lista['resultado_entrevista'],1);
                                echo '<br>' .  number_format($porcentajeEntrevista, 1) . '%';
                                echo '</td>';

                                echo '<td class="text-center">';
                                echo number_format($lista['criterio_etnias'],1);
                                echo '<br>' .  number_format($lista['criterio_etnias'], 1) . '%';
                                echo '</td>';

                                echo '<td class="text-center">';
                                echo number_format($lista['criterio_desarrollo'],1);
                                echo '<br>' .  number_format($lista['criterio_desarrollo'], 1) . '%';
                                echo '</td>';

                                echo '<td class="text-center">' . number_format($puntajeTotal,2) . '</td>';
                                echo '<td class="text-center">' . number_format($porcentajeTotal, 1) . '%</td>';
                                echo '<td class="text-center">';
                                $class = 'btn-info';
                                $valor = $lista['id_candidato'];
                                if($lista['id_puntaje']){ 
                                    $class = 'btn-default';
                                    $valor = $lista['id_puntaje'];
                                }
                        ?>
                                <button type="button" class="btn <?php echo $class; ?> btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $valor; ?>" >
                                    Puntajes <span class="glyphicon glyphicon-briefcase" aria-hidden="true">
                                </button>
                        <?php
                                echo '</td>';
                                echo '</tr>';
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                    
<?php   } ?>                    
                </div>
            </div>

        </div>

    </div>

<?php
    if($infoCalculoFormHabilidades){ 
?> 
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                        <i class="fa fa-list-ul"></i> <strong>TABULACIÓN - PUNTAJE HABILIDADES SOCIALES</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>#</th>
                                <th>Nombres</th>
                                <th class='text-center'>No. Identificación</th>
                                <th class='text-center'>ASERTIVIDAD</th>
                                <th class='text-center'>COMUNICACIÓN</th>
                                <th class='text-center'>AUTOESTIMA</th>
                                <th class='text-center'>TOMA DE DECISIONES</th>
                                <th class='text-center'>Info. Prueba Habilidades Sociales</th>

                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            $i = 1;
                            foreach ($infoCalculoFormHabilidades as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td>' . $lista['name'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td class="text-center">' . $lista['ASE'] . '</td>';
                                echo '<td class="text-center">' . $lista['COM'] . '</td>';
                                echo '<td class="text-center">' . $lista['AUT'] . '</td>';
                                echo '<td class="text-center">' . $lista['TOM'] . '</td>';
                                echo '<td class="text-center">';

                                if($lista['numero_parte_formulario'] == 2){
                            ?>
                                    <a class='btn btn-primary btn-xs' href='<?php echo base_url('dashboard/respuestas_habilidades/' . $lista['fk_id_form_habilidades_c']) ?>'>
                                        Ver Respuestas <span class="fa fa-arrow-circle-right" aria-hidden="true">
                                    </a>
                                    <br><br>
                            <?php
                                    $fechaInicio = $lista['fecha_registro_inicio'];
                                    $fechaFin = $lista['fecha_registro_fin'];
                                
                                    echo '<strong>' . strftime("%b %d, %G",strtotime($fechaInicio)) . '</strong>';
                                    echo '<br>';
                                    echo '<strong>Hora Incio: </strong>';
                                    echo strftime("%I:%M:%S %p",strtotime($fechaInicio));
                                    echo '<br>';
                                    echo '<strong>Hora Fin: </strong>';
                                    echo strftime("%I:%M:%S %p",strtotime($fechaFin));
                                    $date1 = new DateTime($fechaInicio);
                                    $date2 = new DateTime($fechaFin);
                                    $diff = $date1->diff($date2);

                                    echo '<br><strong>Duración: </strong>';
                                    echo $diff->i . ' minuto(s)';
                                }else{
                                    echo '<strong>Hora Inicio: </strong><br>' . $lista['fecha_registro_inicio'];
                                }
                                echo '</td>';
                                echo '</tr>';
                                $i++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Habilidades Sociales

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="graficaHablidades"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
<?php  } ?>  

<?php
    if($infoCalculoFormAspectos){ 
?>  
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                        <i class="fa fa-list-ul"></i> <strong>TABULACIÓN - PUNTAJE ASPECTOS DE INTERES</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>#</th>
                                <th>Nombres</th>
                                <th class='text-center'>No. Identificación</th>
                                <th class='text-center'>LOG</th>
                                <th class='text-center'>DT</th>
                                <th class='text-center'>SUP</th>
                                <th class='text-center'>POD</th>
                                <th class='text-center'>AA</th>
                                <th class='text-center'>GT</th>
                                <th class='text-center'>AFI</th>
                                <th class='text-center'>ANV</th>
                                <th class='text-center'>CT</th>
                                <th class='text-center'>A-R</th>
                                <th class='text-center'>REQ</th>
                                <th class='text-center'>SAL</th>
                                <th class='text-center'>REC</th>
                                <th class='text-center'>EXP</th>
                                <th class='text-center'>PRO</th>
                                <th class='text-center'>Info. Prueba Aspectos de Interes</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            $i = 1;
                            foreach ($infoCalculoFormAspectos as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td>' . $lista['name'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td class="text-center">' . $lista['LOG'] . '</td>';
                                echo '<td class="text-center">' . $lista['DT'] . '</td>';
                                echo '<td class="text-center">' . $lista['SUP'] . '</td>';
                                echo '<td class="text-center">' . $lista['POD'] . '</td>';
                                echo '<td class="text-center">' . $lista['AA'] . '</td>';
                                echo '<td class="text-center">' . $lista['GT'] . '</td>';
                                echo '<td class="text-center">' . $lista['AFI'] . '</td>';
                                echo '<td class="text-center">' . $lista['ANV'] . '</td>';
                                echo '<td class="text-center">' . $lista['CT'] . '</td>';
                                echo '<td class="text-center">' . $lista['A-R'] . '</td>';
                                echo '<td class="text-center">' . $lista['REQ'] . '</td>';
                                echo '<td class="text-center">' . $lista['SAL'] . '</td>';
                                echo '<td class="text-center">' . $lista['REC'] . '</td>';
                                echo '<td class="text-center">' . $lista['EXP'] . '</td>';
                                echo '<td class="text-center">' . $lista['PRO'] . '</td>';
                                echo '<td class="text-center">';
                                if($lista['numero_parte_formulario'] >= 4) {
                            ?>
                                    <a class='btn btn-primary btn-xs' href='<?php echo base_url('dashboard/respuestas_aspectos/' . $lista['fk_id_form_aspectos_interes_c']) ?>'>
                                        Ver Respuestas <span class="fa fa-arrow-circle-right" aria-hidden="true">
                                    </a>
                                     <br><br>
                            <?php
                                    $fechaInicio = $lista['fecha_registro_inicio'];
                                    $fechaFin = $lista['fecha_registro_fin'];
                                
                                    echo '<strong>' . strftime("%b %d, %G",strtotime($fechaInicio)) . '</strong>';
                                    echo '<br>';
                                    echo '<strong>Hora Incio: </strong>';
                                    echo strftime("%I:%M:%S %p",strtotime($fechaInicio));
                                    echo '<br>';
                                    echo '<strong>Hora Fin: </strong>';
                                    echo strftime("%I:%M:%S %p",strtotime($fechaFin));
                                    $date1 = new DateTime($fechaInicio);
                                    $date2 = new DateTime($fechaFin);
                                    $diff = $date1->diff($date2);

                                    echo '<br><strong>Duración: </strong>';
                                    echo $diff->i . ' minuto(s)';

                                }else{
                                    echo '<strong>Hora Inicio: </strong><br>' . $lista['fecha_registro_inicio'];
                                    echo '<br><strong>No. Parte:</strong><br>' . $lista['numero_parte_formulario'] . '/3';
                                }
                                echo '</td>';
                                echo '</tr>';
                                $i++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php  } ?> 

<?php
    if($infoCalculoCompetencias){ 
?>  
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                        <i class="fa fa-list-ul"></i> <strong>COMPETENCIAS</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center' rowspan='2'>#</th>
                                <th rowspan='2'>Nombres</th>
                                <th class='text-center' rowspan='2'>No. Identificación</th>
                                <th class='text-center primary text-primary' colspan='4'>Orientacion al Ciudadano</th>
                                <th class='text-center danger text-danger' colspan='3'>Aprendizaje continuo</th>
                                <th class='text-center info text-info' colspan='3'>Orientación a resultados</th>
                                <th class='text-center warning text-warning' colspan='3'>Compromiso con la Organización</th>
                                <th class='text-center success text-success' colspan='3'>Trabajo en equipo</th>
                                <th class='text-center violeta text-violeta'>Adaptación al cambio</th>
                            </tr>
                            <tr>
                                <th class='text-center primary text-primary'>ASE</th>
                                <th class='text-center primary text-primary'>COM</th>
                                <th class='text-center primary text-primary'>AUT</th>
                                <th class='text-center primary text-primary'>TOM</th>
                                <th class='text-center danger text-danger'>AA</th>
                                <th class='text-center danger text-danger'>GT</th>
                                <th class='text-center danger text-danger'>CT</th>
                                <th class='text-center info text-info'>LOG</th>
                                <th class='text-center info text-info'>SUP</th>
                                <th class='text-center info text-info'>A-R</th>
                                <th class='text-center warning text-warning'>DT</th>
                                <th class='text-center warning text-warning'>AFI</th>
                                <th class='text-center warning text-warning'>ANV</th>
                                <th class='text-center success text-success'>GT</th>                                
                                <th class='text-center success text-success'>REC</th>
                                <th class='text-center success text-success'>EXP</th>
                                <th class='text-center violeta text-violeta'>A-R</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            $i = 1;
                            foreach ($infoCalculoCompetencias as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td>' . $lista['name'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORC-ASE'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORC-COM'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORC-AUT'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORC-TOM'] . '</td>';
                                echo '<td class="text-center">' . $lista['APC-AA'] . '</td>';
                                echo '<td class="text-center">' . $lista['APC-GT'] . '</td>';
                                echo '<td class="text-center">' . $lista['APC-CT'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORR-LOG'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORR-SUP'] . '</td>';
                                echo '<td class="text-center">' . $lista['ORR-A-R'] . '</td>';
                                echo '<td class="text-center">' . $lista['COO-DT'] . '</td>';
                                echo '<td class="text-center">' . $lista['COO-AFI'] . '</td>';
                                echo '<td class="text-center">' . $lista['COO-ANV'] . '</td>';
                                echo '<td class="text-center">' . $lista['TRE-GT'] . '</td>';
                                echo '<td class="text-center">' . $lista['TRE-REC'] . '</td>';
                                echo '<td class="text-center">' . $lista['TRE-EXP'] . '</td>';
                                echo '<td class="text-center">' . $lista['ADC-A-R'] . '</td>';
                                echo '</tr>';
                                $i++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php  } ?> 

</div>

<!--INICIO Modal Buscar por fecha -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="tablaDatos">

        </div>
    </div>
</div>                       
<!--FIN Modal Buscar por fecha -->

<!--INICIO Modal Buscar por fecha -->
<div class="modal fade text-center" id="modalRango" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="formRango">

        </div>
    </div>
</div>                       
<!--FIN Modal Buscar por fecha -->

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

<script>
$(function() {

    Morris.Line({
        element: 'graficaHablidades',
        data: [
            <?php $i = 1;
                if($infoCalculoFormHabilidades)
                {
                    $i = 1001;
                    foreach ($infoCalculoFormHabilidades as $lista):
                            echo "{";
                            echo "period:'" . $i. ' ' . $lista['name']."',";
                            echo "ASE:'" . $lista['ASE']."',";
                            echo "COM:'" . $lista['COM']."',";
                            echo "AUT:'" . $lista['AUT']."',";
                            echo "TOM:'" . $lista['TOM']."',";
                            $media = ($lista['ASE'] + $lista['COM'] + $lista['AUT'] + $lista['TOM'])/4;
                            echo "MEDIA:'" . $media ."'";
                            echo "},";
                            $i++;
                    endforeach;
                }
            ?>
        ],
        xkey: 'period',
        ykeys: ['ASE', 'COM', 'AUT', 'TOM','MEDIA'],
        labels: ['Asertividad', 'Comunicación', 'Autoestima', 'Toma Decisión','Media'],
        lineColors: ['blue', 'red','green','yellow','black'],
        pointSize: 3,
        hideHover: 'auto',
        resize: true
    });



    
});

</script>