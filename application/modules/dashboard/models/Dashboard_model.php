<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard_model extends CI_Model {

		
		/**
		 * Add/Edit Puntajes
		 * @since 29/4/2021
		 */
		public function savePuntajes($puntajeDirecto, $puntajeT) 
		{
				$idPuntaje = $this->input->post('hddIdPuntaje');

				$data = array(
					'puntaje_experiencia' => $this->input->post('puntajeExperiencia'),
					'puntaje_adicionales' => $this->input->post('puntajeEstudiosAdicionales'),
					'resultado_prueba_psicotecnica' => $puntajeT,
					'resultado_entrevista' => $this->input->post('reultadoEntrevista'),
					'criterio_etnias' => $this->input->post('criterioEtnias'),
					'criterio_desarrollo' => $this->input->post('criterioDesarrollo'),
					'puntaje_directo' => $puntajeDirecto,
					'puntaje_t' => $puntajeT
				);	

				//revisar si es para adicionar o editar
				if ($idPuntaje == '') 
				{
					$data['fk_id_candidato_p'] = $this->input->post('hddIdCandidato');
					$data['fecha_registro_puntaje'] = date('Y-m-d');
					$query = $this->db->insert('candidatos_puntajes', $data);
				} else {
					$this->db->where('id_puntaje', $idPuntaje);
					$query = $this->db->update('candidatos_puntajes', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		
		
	    
	}