<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Formulario_model extends CI_Model {
		
		/**
		 * Edit CANDIDATO
		 * @since 25/3/2021
		 */
		public function saveCandidato() 
		{
				$idCandidato = $this->input->post('hddIdCandidato');
				
				$data = array(
					'nombres' => $this->input->post('firstName'),
					'apellidos' => $this->input->post('lastName'),
					'correo' => $this->input->post('email'),
					'numero_celular' => $this->input->post('movilNumber'),
					'edad' => $this->input->post('edad'),
					'fk_id_nivel_academico' => $this->input->post('nivelAcademico'),
					'profesion' => $this->input->post('profesion'),
					'ciudad' => $this->input->post('ciudad')
				);	

				$this->db->where('id_candidato', $idCandidato);
				$query = $this->db->update('candidatos', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Guardar informacion del formulario
		 * @since 28/3/2021
		 */
		public function saveFormulario() 
		{				
				$data = array(
					'fk_id_candidato_fh ' => $this->input->post('hddIdCandidato'),
					'fecha_registro' => date("Y-m-d G:i:s"),
					'duracion_prueba' => 1,
				);	
				$query = $this->db->insert('form_habilidades', $data);

				$idFormulario = $this->db->insert_id();
				if ($query) {
					return $idFormulario;
				} else {
					return false;
				}
		}

		/**
		 * Guardar informacion del formulario
		 * @since 28/3/2021
		 */
		public function saveRespuestasFormulario($idFormulario) 
		{
			//update states
			$query = 1;
			
			$NoPreguntas = $this->input->post('hddIdNoPreguntas');
				
			if ($respuesta = $this->input->post('pregunta')) 
			{
				for ($i = 1; $i <= $NoPreguntas; $i++) 
				{
					if (array_key_exists($i,$respuesta))
					{
						$data = array(
							'fk_id_formulario_habilidades' => $idFormulario,
							'fk_id_pregunta_habilidades' => $i,
							'respuesta_habilidad' => $respuesta[$i]
						);	
						$query = $this->db->insert('form_habilidades_respuestas', $data);
					}

				}
			}

			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		

		
	    
	}