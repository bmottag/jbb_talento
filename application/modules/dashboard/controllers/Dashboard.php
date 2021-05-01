<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
    }
		
	/**
	 * SUPER ADMIN DASHBOARD
	 */
	public function admin()
	{				
			//Candidatos activos
			$arrParam = array('estadoCandidato' => 1);
			$data['infoCandidatos'] = $this->general_model->get_candidatos_info($arrParam);

			$data['infoCalculoCompetencias'] = $this->general_model->get_calculos_competencias($arrParam);

			$arrParam = array(
				'estadoFormulario' => 1,
				'estadoCandidato' => 1
			);
			$data['infoCalculoFormHabilidades'] = $this->general_model->get_calculos_formulario_habilidades($arrParam);
			$data['infoCalculoFormAspectos'] = $this->general_model->get_calculos_formulario_aspectos($arrParam);

			$data["view"] = "dashboard";
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Lista de Respuestas
     * @since 29/3/2021
     * @author BMOTTAG
	 */
	public function respuestas_habilidades($idFormulario)
	{		
			$arrParam = array('idFormHabilidades' => $idFormulario);			
			$data['infoFormulario'] = $this->general_model->get_formulario_habilidades($arrParam);
			$data['infoRespuestas'] = $this->general_model->get_respuestas_formulario_habilidades($arrParam);
			$data['view'] ='respuestas_habilidades';
			$this->load->view('layout_calendar', $data);
	}

    /**
     * Cargo modal - formulario buscar resercar por fecha
     * @since 1/3/2021
     */
    public function cargarModalBuscar() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
						
			$this->load->view('buscar_modal');
    }

	/**
	 * Lista de reservas
     * @since 1/3/2021
     * @author BMOTTAG
	 */
	public function buscar_reservas()
	{	
			//para identificar en la visda de donde viene
			$data['bandera'] = TRUE;

			$data['fecha'] = $this->input->post('date');
			$arrParam = array(
				'fecha' => $data['fecha']
			);			
			$data['listaReservas'] = $this->general_model->get_info_reservas($arrParam);

			$data["view"] ='lista_reservas_fecha';
			$this->load->view("layout_calendar", $data);
	}

    /**
     * Cargo modal - formulario buscar reservas por rango de fechas
     * @since 1/3/2021
     */
    public function cargarModalBuscarRango() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
						
			$this->load->view('buscar_rango_modal');
    }

	/**
	 * Lista de reservas
     * @since 3/3/2021
     * @author BMOTTAG
	 */
	public function buscar_reservas_rango()
	{		
			//para identificar en la visda de donde viene
			$data['bandera'] = FALSE;

			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');

			$from = formatear_fecha($data['from']);
			//le sumo un dia al dia final para que ingrese ese dia en la consulta
			$to = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( formatear_fecha($data['to']) ) ) );

			$arrParam = array(
				'from' => $from,
				'to' => $to
			);
			$data['listaReservas'] = $this->general_model->get_info_reservas($arrParam);

			$data["view"] ='lista_reservas_fecha';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Lista de Respuestas Fomrulario de Aspectos de interes
     * @since 10/4/2021
     * @author BMOTTAG
	 */
	public function respuestas_aspectos($idFormulario)
	{		
			$arrParam = array('idFormAspectos' => $idFormulario);			
			$data['infoFormulario'] = $this->general_model->get_formulario_aspectos($arrParam);
			$data['infoRespuestas'] = $this->general_model->get_respuestas_formulario_aspectos($arrParam);
			$data['view'] ='respuestas_aspectos';
			$this->load->view('layout_calendar', $data);
	}

	/**
     * Cargo modal - formulario de puntajes
     * @since 29/04/2021
     * @author BMOTTAG
     */
    public function cargarModalPuntajes() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['infoPuntajes'] = FALSE;
		$data['idCandidato'] = $this->input->post('idCandidato');
		$data['idPuntaje'] = $this->input->post('idPuntaje');
		if ($data['idPuntaje'] != 'x')
		{
			$arrParam = array('idPuntaje' => $data['idPuntaje']);
			$data['infoPuntajes'] = $this->general_model->get_puntaje($arrParam);
		}
		$this->load->view('puntajes_modal', $data);
    }

	/**
	 * Save puntajes
     * @since 29/4/2021
     * @author BMOTTAG
	 */
	public function save_puntajes()
	{			
			header('Content-Type: application/json');
			$data = array();
					
			$msj = "Se actualizó el Puntaje del Candidato!";

			if ($this->dashboard_model->savePuntajes()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}

			echo json_encode($data);	
    }
	
	
	
}