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
		

		
	    
	}