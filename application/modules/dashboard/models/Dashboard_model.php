<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard_model extends CI_Model {

		
		/**
		 * Add/Edit Puntajes
		 * @since 29/4/2021
		 */
		public function savePuntajes() 
		{
				$idPuntaje = $this->input->post('hddIdPuntaje');
				$puntajeExperienciaPrivada = $this->input->post('puntajeExperienciaPrivada');
				$puntajeExperienciaPrivada = $puntajeExperienciaPrivada?$puntajeExperienciaPrivada:0;

				$puntajeExperienciaPublica =  $this->input->post('puntajeExperienciaPublica');
				$puntajeExperienciaPublica = $puntajeExperienciaPublica?$puntajeExperienciaPublica:0;

				$totalExperiencia = $puntajeExperienciaPrivada + $puntajeExperienciaPublica;
				$totalExperiencia = $totalExperiencia>59?60:$totalExperiencia;

				$data = array(
					'puntaje_experiencia_privada' => $this->input->post('puntajeExperienciaPrivada'),
					'puntaje_experiencia_publica' => $this->input->post('puntajeExperienciaPublica'),
					'puntaje_total_experiencia' => $totalExperiencia,
					'puntaje_estudios' => $this->input->post('puntajeEstudios'),
					'resultado_prueba_psicotecnica' => $this->input->post('resultadoPruebaPsicotecnica'),
					'resultado_entrevista' => $this->input->post('reultadoEntrevista')
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