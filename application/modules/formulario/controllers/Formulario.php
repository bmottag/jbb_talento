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
	 * Calendario
     * @since 6/1/2021
     * @author BMOTTAG
	 */
	public function habilidades($idCandidato)
	{
			$arrParam = array("idCandidato" => $idCandidato);
			$data['information'] = $this->general_model->get_candidatos_info($arrParam);
	
			$arrParam = array(
				"table" => "param_nivel_academico",
				"order" => "id_nivel_academico",
				"id" => "x"
			);
			$data['nivelAcademico'] = $this->general_model->get_basic_search($arrParam);

			$arrParam = array(
				"table" => "param_preguntas_habilidades",
				"order" => "id_pregunta_habilidad",
				"id" => "x"
			);
			$data['preguntasHabilidades'] = $this->general_model->get_basic_search($arrParam);
			$data["view"] = 'form_habilidades';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Save vehiculos inspection
     * @since 18/1/2021
     * @author BMOTTAG
	 */
	public function save_habilidades()
	{
			header('Content-Type: application/json');
			$data = array();

			$idFormulario = $this->input->post('hddIdFormulario');
			$idCandidato= $this->input->post('hddIdCandidato');
		
			$msj = "Se guardó la información del formulario!";
			$flag = true;
			if ($idCandidato != '') {
				$msj = "Se actualizó la información!";
				$flag = false;
			}
			
			if ($idCandidato = $this->formulario_model->saveCandidato()) 
			{

				echo "actualizo candidato"; exit;

				$idCandidato = $this->formulario_model->saveCandidato();

				$data["result"] = true;
				$data["idCandidato"] = $idCandidato;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idCandidato"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	

	
	
}