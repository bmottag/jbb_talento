<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulario extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("formulario_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }

	/**
	 * Ingreso del candidato
	 */
	public function index()
	{				
			$arrParam = array('idCandidato' => $this->session->id);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);

			$arrParam = array('idProceso' => $data['information'][0]['id_proceso']);
			$data['infoProceso'] = $this->general_model->get_procesos_info($arrParam);

			$arrParam = array(
				"table" => "param_nivel_academico",
				"order" => "id_nivel_academico",
				"id" => "x"
			);
			$data['nivelAcademico'] = $this->general_model->get_basic_search($arrParam);

			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos

			$data['view'] = 'info_candidato';
			$this->load->view('layout_calendar', $data);
	}

	/**
	 * Save info del candidato
     * @since 2/4/2021
     * @author BMOTTAG
	 */
	public function save_candidato()
	{
			header('Content-Type: application/json');
			$data = array();

			$idCandidato= $this->input->post('hddIdCandidato');
			$msj = "Se actualizarón sus datos, por favor continuar con los cuestionarios.";

			if ($idCandidato = $this->formulario_model->saveCandidato()) 
			{
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }

	/**
	 * Formulario de habilidades
     * @since 8/4/2021
     * @author BMOTTAG
	 */
	public function habilidades()
	{
			//buscar por el id del candidato y el fomulario este habilitado
			$arrParam = array(
				'idCandidato' => $this->session->id,
				'estadoFormulario' => 1
			);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);

			$data['infoFormulario'] = $this->general_model->get_formulario_habilidades($arrParam);

			$arrParam = array('idProceso' => $data['information'][0]['id_proceso']);
			$data['infoProceso'] = $this->general_model->get_procesos_info($arrParam);

			if($data['infoFormulario'])
			{
				$data['idFormularioHabilidades'] = $data['infoFormulario'][0]['id_form_habilidades'];
			}else{
				//si no hay formulario entonces creo el formulario
				$data['idFormularioHabilidades'] = $this->formulario_model->saveFormularioHabilidades();
				//si no hay formulario entonces creo registro de sumatoria de datos
				$arrParam = array(
					'table' => 'form_habilidades_calculos',
					'columnaFormulario' => 'fk_id_form_habilidades_c',
					'idFormulario' => $data['idFormularioHabilidades']
				);
				$this->formulario_model->saveCalculoRecord($arrParam);
			}

            $arrParam = array(
                'table' => 'param_preguntas_habilidades',
                'order' => 'id_pregunta_habilidad',
                'id' => 'x'
            );
            $data['preguntasHabilidades'] = $this->general_model->get_basic_search($arrParam);
            $data['noPreguntas'] = count($data['preguntasHabilidades']);//se utiliza al guardar las respuestas

			$data["view"] = 'form_habilidades';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Save formulario de habilidades
     * @since 8/4/2021
     * @author BMOTTAG
	 */
	public function save_habilidades()
	{
			header('Content-Type: application/json');
			$data = array();

			$idCandidato= $this->input->post('hddIdCandidato');

			$msj = "Se guardó la información del formulario!";
			$flag = true;
			if ($idCandidato != '') {
				$msj = "Se guardó la información!";
				$flag = false;
			}

			if ($this->formulario_model->updateFormularioHabilidades()) 
			{
				$this->formulario_model->saveRespuestasFormulario();

				//busco listado de formulas, para el formulario de HABILIDADES (2)
				$arrParam = array(
					'table' => 'param_competencias_formulas',
					'order' => 'id_competencias_formulas ',
					'column' => 'formulario',
					'id' => 2
				);
				$data['formulas'] = $this->general_model->get_basic_search($arrParam);
				$conteo = count($data['formulas']);

				for ($i = 0; $i < $conteo; $i++) 
				{
						$arrParam = array(
							'valMin' => $data['formulas'][$i]['valor_minimo'],
							'valMax' => $data['formulas'][$i]['valor_maximo'],
							'descripcion' =>$data['formulas'][$i]['descripcion']
						);	
						$data['sumatoria'] = $this->formulario_model->aplicar_formula_habilidades($arrParam);
				}

				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }

	/**
	 * Formulario de Aspectos de interes
     * @since 9/4/2021
     * @author BMOTTAG
	 */
	public function aspectos()
	{
			//buscar por el id del candidato y el fomulario este habilitado
			$arrParam = array(
				'idCandidato' => $this->session->id,
				'estadoFormulario' => 1
			);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);

			//busco si ya se guardo informacion del formulario
			$data['infoFormulario'] = $this->general_model->get_formulario_aspectos_interes($arrParam);

			$arrParam = array('idProceso' => $data['information'][0]['id_proceso']);
			$data['infoProceso'] = $this->general_model->get_procesos_info($arrParam);

			if($data['infoFormulario'])
			{
				//buscar por parte de formulario
				$noParteFormulario = $data['infoFormulario'][0]['numero_parte_formulario'];
				$arrParamForm = array('numeroParte' => $noParteFormulario);
				$data['idFormularioAspectos'] = $data['infoFormulario'][0]['id_form_aspectos_interes'];

			}else{
				//si no hay formulario entonces creo el formulario
				$data['idFormularioAspectos'] = $this->formulario_model->saveFormularioAspectosInteres();
				//si no hay formulario entonces creo registro de sumatoria de datos
				$arrParam = array(
					'table' => 'form_aspectos_interes_calculos',
					'columnaFormulario' => 'fk_id_form_aspectos_interes_c',
					'idFormulario' => $data['idFormularioAspectos']
				);
				$this->formulario_model->saveCalculoRecord($arrParam);

				//si es primera vez de ingreso entonces empieza por la primera parte
				$arrParamForm = array('numeroParte' => 1);
				$data['infoFormulario'] = $this->general_model->get_formulario_aspectos_interes($arrParam);
			}

			//busco preguntas de acuerdo en que parte del formulario va el usuario
			$data['preguntasAspectosInteres'] = $this->general_model->get_preguntas_aspectos_interes($arrParamForm);

			$data["view"] = 'form_aspectos';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Save formulario de aspectos
     * @since 9/4/2021
     * @author BMOTTAG
	 */
	public function save_aspectos()
	{
			header('Content-Type: application/json');
			$data = array();

			$msj = "Se guardó la información del formulario!";
			$NoParte = $this->input->post('hddIdFormNoParte');
			$respuesta = $this->input->post('pregunta');
			$NoPreguntas = $this->input->post('hddNoPreguntas');
			$noProximaPregunta = $this->input->post('hddNoProximaPregunta');
			$finalPreguntas = $NoPreguntas + $noProximaPregunta;

			$sumatoria1 = 0;
			$sumatoria2 = 0;
			$sumatoria3 = 0;
			$sumatoria4 = 0;
			$sumatoria5 = 0;
			$bandera = false;
			$error = false;

			if($respuesta){
				for ($i = $noProximaPregunta; $i <= $finalPreguntas; $i++) 
				{
					if($NoParte == 1)
					{
						if (array_key_exists($i,$respuesta) )
						{
							if($i >= 1 && $i <= 5){
								$sumatoria1 = $respuesta[$i] + $sumatoria1;
							}elseif($i >= 6 && $i <= 10){
								$sumatoria2 = $respuesta[$i] + $sumatoria2;
							}elseif($i >= 11 && $i <= 15){
								$sumatoria3 = $respuesta[$i] + $sumatoria3;
							}elseif($i >= 16 && $i <= 20){
								$sumatoria4 = $respuesta[$i] + $sumatoria4;
							}elseif($i >= 21 && $i <= 25){
								$sumatoria5 = $respuesta[$i] + $sumatoria5;
							}

							if($sumatoria1 != 15){
								$error = "Error pregunta 1.";
							}elseif($sumatoria2 != 15){
								$error = "Error pregunta 2.";
							}elseif($sumatoria3 != 15){
								$error = "Error pregunta 3.";
							}elseif($sumatoria4 != 15){
								$error = "Error pregunta 4.";
							}elseif($sumatoria5 != 15){
								$error = "Error pregunta 5.";
							}

						}
					}elseif($NoParte == 2){
						if (array_key_exists($i,$respuesta) )
						{
							if($i >= 26 && $i <= 30){
								$sumatoria1 = $respuesta[$i] + $sumatoria1;
							}elseif($i >= 31 && $i <= 35){
								$sumatoria2 = $respuesta[$i] + $sumatoria2;
							}elseif($i >= 36 && $i <= 40){
								$sumatoria3 = $respuesta[$i] + $sumatoria3;
							}elseif($i >= 41 && $i <= 45){
								$sumatoria4 = $respuesta[$i] + $sumatoria4;
							}elseif($i >= 46 && $i <= 50){
								$sumatoria5 = $respuesta[$i] + $sumatoria5;
							}

							if($sumatoria1 != 15){
								$error = "Error pregunta 6.";
							}elseif($sumatoria2 != 15){
								$error = "Error pregunta 7.";
							}elseif($sumatoria3 != 15){
								$error = "Error pregunta 8.";
							}elseif($sumatoria4 != 15){
								$error = "Error pregunta 9.";
							}elseif($sumatoria5 != 15){
								$error = "Error pregunta 10.";
							}
						}
					}elseif($NoParte == 3)
					{
						if (array_key_exists($i,$respuesta) )
						{
							if($i >= 51 && $i <= 55){
								$sumatoria1 = $respuesta[$i] + $sumatoria1;
							}elseif($i >= 56 && $i <= 60){
								$sumatoria2 = $respuesta[$i] + $sumatoria2;
							}elseif($i >= 61 && $i <= 65){
								$sumatoria3 = $respuesta[$i] + $sumatoria3;
							}elseif($i >= 66 && $i <= 70){
								$sumatoria4 = $respuesta[$i] + $sumatoria4;
							}elseif($i >= 71 && $i <= 75){
								$sumatoria5 = $respuesta[$i] + $sumatoria5;
							}

							if($sumatoria1 != 15){
								$error = "Error pregunta 11.";
							}elseif($sumatoria2 != 15){
								$error = "Error pregunta 12.";
							}elseif($sumatoria3 != 15){
								$error = "Error pregunta 13.";
							}elseif($sumatoria4 != 15){
								$error = "Error pregunta 14.";
							}elseif($sumatoria5 != 15){
								$error = "Error pregunta 15.";
							}
						}
					}
				}
			}

			if($sumatoria1 != 15 || $sumatoria2 != 15 || $sumatoria3 != 15 || $sumatoria4 != 15 || $sumatoria5 != 15){
				$bandera = true;
				if($sumatoria1 == 0 || $sumatoria2 == 0 || $sumatoria3 == 0 || $sumatoria4 == 0 || $sumatoria5 == 0){
					$error = false;
				}
			}

			if ($bandera)
			{
				$data["result"] = "error";
				if(!$error){
					$data["mensaje"] = "Debe contestar todas las preguntas del formulario.";
				}else{
					$data["mensaje"] = $error . " Solo se permite una respuesta por columna en cada pregunta.";
				}
			} else {
				//primero actualizar informacion del formulario, en que parte va y la hora de cierre
				if ($this->formulario_model->updateFormularioAspectosInteres()) 
				{
					$this->formulario_model->saveRespuestasFormularioAspectosInteres();
					
					//si es la ultima parte entonces realizo los calculos de datos
					if($NoParte == 3)
					{
						//actualizo el id del formulario en la tabla de form_competencias_calculos
						$this->formulario_model->updateIdFormularioTablaCompetencia();

						//busco listado de formulas, para el formulario de ASPECTOS DE INTERES (1)
						$arrParam = array(
							'table' => 'param_competencias_formulas',
							'order' => 'id_competencias_formulas ',
							'column' => 'formulario',
							'id' => 1
						);
						$data['formulas'] = $this->general_model->get_basic_search($arrParam);
						$conteo = count($data['formulas']);

						//para cada formula la utilizo y actualizo tabla form_aspectos_interes_calculos
						for ($i = 0; $i < $conteo; $i++) 
						{
								$arrParam = array(
									'formula' => $data['formulas'][$i]['formula'],
									'descripcion' =>$data['formulas'][$i]['descripcion']
								);	
								$data['sumatoria'] = $this->formulario_model->aplicar_formula_aspectos_interes($arrParam);
						}

					}

					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Ask for help.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
			}

			echo json_encode($data);
    }
	

	
	
}