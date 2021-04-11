<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
    $(".btn-primary").click(function () {   
            var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'dashboard/cargarModalBuscar',
                data: {'idLink': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
    }); 
});
</script>

<script>
$(function(){ 
    $(".btn-info").click(function () {   
            var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'dashboard/cargarModalBuscarRango',
                data: {'idLink': oID},
                cache: false,
                success: function (data) {
                    $('#formRango').html(data);
                }
            });
    }); 
});
</script>

<div id="page-wrapper">
    <div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
    </div>
								
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?> 

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-4">
                        <i class="fa fa-list-ul"></i> <strong>CANDIDATOS ACTIVOS</strong>
                        </div>
                        <div class="col-lg-2">
                            <form  name="form_descarga" id="form_descarga" method="post" action="<?php echo base_url("reportes/generaReservaFechaPDF"); ?>" target="_blank">
                                <input type="hidden" class="form-control" id="bandera" name="bandera" value=1 />
                                <input type="hidden" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" />
                            <?php
                                if($infoProcesos){ 
                            ?>
                                <button type="submit" class="btn btn-info btn-xs" id="btnSubmit2" name="btnSubmit2" value="1" >
                                    Descargar Listado PDF <span class="fa fa-file-pdf-o" aria-hidden="true" />
                                </button>
                            <?php
                                }
                            ?>
                            </form>
                        </div>
                    </div>
                       
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

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

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th class='text-center'>#</th>
                                <th class='text-center'>Nombres</th>
                                <th class='text-center'>Apellidos</th>
                                <th class='text-center'>No. Identificación</th>
                                <th class='text-center'>Correo Electrónico</th>
                                <th class='text-center'>Nivel Académico</th>
                                <th class='text-center'>Proceso Actual</th>
                                <th class='text-center'>Habilidades Sociales</th>
                                <th class='text-center'>Aspectos Interes</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            $i = 1;
                            foreach ($infoCandidatos as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td class="text-center">' . $lista['nombres'] . '</td>';
                                echo '<td class="text-center">' . $lista['apellidos'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_identificacion'] . '</td>';
                                echo '<td class="text-center">' . $lista['correo'] . '</td>';
                                echo '<td class="text-center">' . $lista['nivel_academico'] . '</td>';
                                echo '<td class="text-center">' . $lista['numero_proceso'] . '</td>';
                                echo '<td class="text-center">';
                            ?>
                                    <a class='btn btn-success btn-xs' href='<?php echo base_url('dashboard/respuestas_habilidades/' . $lista['id_candidato']) ?>'>
                                        Ver Respuestas <span class="fa fa-arrow-circle-right" aria-hidden="true">
                                    </a>
                            <?php
                                echo '</td>';
                                echo '<td class="text-center">';
                            ?>
                                    <a class='btn btn-success btn-xs' href='<?php echo base_url('dashboard/respuestas_aspectos/' . $lista['id_candidato']) ?>'>
                                        Ver Respuestas <span class="fa fa-arrow-circle-right" aria-hidden="true">
                                    </a>
                            <?php
                                echo '</td>';
                                echo '</tr>';
                                $i++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                    
<?php   } ?>                    
                </div>
                <!-- /.panel-body -->
            </div>

        </div>

        <div class="col-lg-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> <strong>INFORMACIÓN GENERAL</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag fa-fw"></i><strong> No. Procesos</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noProcesos; ?></em>
                                </span>
                            </p>
                        </a>

                        <a href="#" class="list-group-item" disabled>
                            <p class="text-success"><i class="fa fa-tag  fa-fw"></i><strong> No. Candidatos</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noCandidatos; ?></em>
                                </span>
                            </p>
                        </a>
                    </div>
                    <!-- /.list-group -->

                    <div class="list-group">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar Candidato
                        </button>

                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalRango" id="y">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar Proceso
                        </button>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

        </div>
        <!-- /.col-lg-4 -->
    </div>

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