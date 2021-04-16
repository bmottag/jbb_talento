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
			$msj = "Se guardó la información del Candidato!";

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
			$arrParam = array('idCandidato' => $this->session->id);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);

			$data['infoFormulario'] = $this->general_model->get_formulario_habilidades($arrParam);
			if(!$data['infoFormulario'])
			{
				$arrParam = array(
					"table" => "param_preguntas_habilidades",
					"order" => "id_pregunta_habilidad",
					"id" => "x"
				);
				$data['preguntasHabilidades'] = $this->general_model->get_basic_search($arrParam);
				$data['noPreguntas'] = count($data['preguntasHabilidades']);//se utiliza al guardar las respuestas
			}

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

			if ($idFormulario = $this->formulario_model->saveFormulario()) 
			{
				$this->formulario_model->saveRespuestasFormulario($idFormulario);
				$data["result"] = true;
				$data["idFormulario"] = $idFormulario;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idFormulario"] = "";
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
			$arrParam = array('idCandidato' => $this->session->id);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);
			//busco si ya se guardo informacion del formulario
			$data['infoFormulario'] = $this->general_model->get_formulario_aspectos_interes($arrParam);

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
				$this->formulario_model->saveCalculoRecord($data['idFormularioAspectos']);
				//si no hay formulario entonces creo registro de registro de valores competencias
				$this->formulario_model->saveCalculoCompetenciasRecord($data['idFormularioAspectos']);

				//si es primera vez de ingreso entonces empiza por la primera parte
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

			//primero actualizar informacion del formulario, en que parte va y la hora de cierre
			if ($this->formulario_model->updateFormularioAspectosInteres()) 
			{
				$this->formulario_model->saveRespuestasFormularioAspectosInteres();
				$NoParte = $this->input->post('hddIdFormNoParte');
				//si es la ultima parte entonces realizo los calculos de datos
				if($NoParte == 3)
				{
					//busco las respuestas
					$idFormulario = $this->input->post('hddIdFormAspectos');
					$arrParam = array('idFormulario' => $idFormulario);
					$data['infoRespuestas'] = $this->general_model->get_respuestas_formulario_aspectos($arrParam);

					//busco listado de formulas
					$arrParam = array(
						"table" => "param_aspectos_interes_formulas",
						"order" => "id_formula_aspectos_interes ",
						"id" => "x"
					);
					$data['formulas'] = $this->general_model->get_basic_search($arrParam);
					$conteo = count($data['formulas']);

					for ($i = 0; $i < $conteo; $i++) 
					{
							$arrParam = array(
								'formula' => $data['formulas'][$i]['formula'],
								'descripcion' =>$data['formulas'][$i]['descripcion'],
								'idFormulario' => $idFormulario
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

			echo json_encode($data);
    }
	

	
	
}