<div id="page-wrapper">
    <div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
    </div>
								
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-4">
                        <i class="fa fa-briefcase"></i> <strong>PROCESOS ACTIVOS</strong>
                        </div>
                    </div>
                       
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

<?php
    if(!$infoProcesos){ 
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
                                <th class='text-center'>Número Proceso</th>
                                <th>Tipo Proceso</th>
                                <th>Dependencia</th>
                                <th class='text-center'>Candidatos</th>
                            </tr>
                        </thead>
                        <tbody>                         
                        <?php
                            $i = 1;
                            foreach ($infoProcesos as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $lista['numero_proceso'] . '</td>';
                                echo '<td>' . $lista['tipo_proceso'] . '</td>';
                                echo '<td>' . $lista['dependencia'] . '</td>';
                                echo '<td class="text-center">';
                        ?>
                                <a href="<?php echo base_url("dashboard/detalle/" . $lista['id_proceso']); ?>" class="btn btn-success">Ver Puntajes Candidatos <span class="glyphicon glyphicon-lock" aria-hidden="true"></a>
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
</div>

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