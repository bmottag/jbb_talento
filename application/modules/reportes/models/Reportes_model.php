<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Reportes_model extends CI_Model {
	    
		/**
		 * Consultar registros de procesos
		 * @since 19/3/2021
		 */
		public function get_procesos_info($arrData)
		{
				$this->db->select();
				$this->db->join('param_dependencias D', 'D.id_dependencia = P.fk_id_dependencia', 'INNER');
				$this->db->join('param_tipo_proceso T', 'T.id_tipo_proceso = P.fk_id_tipo_proceso', 'INNER');
				if (array_key_exists("idProceso", $arrData)) {
					$this->db->where('P.id_proceso ', $arrData["idProceso"]);
				}
				if (array_key_exists("estadoProceso", $arrData)) {
					$this->db->where('P.estado_proceso', $arrData["estadoProceso"]);
				}

				$this->db->order_by('P.numero_proceso', 'asc');

				$query = $this->db->get('proceso P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

			/**
		 * Consulta de candidatos
		 * @since 19/3/2021
		 */
		public function get_candidatos_info($arrData)
		{
				$this->db->select("CONCAT(C.nombres, ' ', C.apellidos) nombres, C.numero_identificacion, C.edad, C.profesion, P.numero_proceso, D.dependencia, T.tipo_proceso, FHC.*, FAIC.*, CC.*");
				$this->db->join('candidatos_puntajes X', 'X.fk_id_candidato_p  = C.id_candidato', 'LEFT');
				$this->db->join('proceso P', 'P.id_proceso = C.fk_id_proceso', 'INNER');
				$this->db->join('param_dependencias D', 'D.id_dependencia = P.fk_id_dependencia', 'INNER');
				$this->db->join('param_tipo_proceso T', 'T.id_tipo_proceso = P.fk_id_tipo_proceso', 'INNER');
				$this->db->join('form_habilidades FH', 'FH.fk_id_candidato_fh = C.id_candidato', 'LEFT');
				$this->db->join('form_habilidades_calculos FHC', 'FHC.fk_id_form_habilidades_c = FH.id_form_habilidades', 'INNER');
				$this->db->join('form_aspectos_interes FAI', 'FAI.fk_id_candidato_fai = C.id_candidato', 'LEFT');
				$this->db->join('form_aspectos_interes_calculos FAIC', 'FAIC.fk_id_form_aspectos_interes_c = FAI.id_form_aspectos_interes', 'INNER');
				$this->db->join('form_competencias_calculos CC', 'CC.fk_id_candidato_cc = C.id_candidato', 'LEFT');
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('C.id_candidato', $arrData["idCandidato"]);
				}
				if (array_key_exists("numeroIdentificacion", $arrData)) {
					$this->db->where('C.numero_identificacion', $arrData["numeroIdentificacion"]);
				}
				if (array_key_exists("idProceso", $arrData)) {
					$this->db->where('C.fk_id_proceso', $arrData["idProceso"]);
				}
				if (array_key_exists("estadoCandidato", $arrData)) {
					$this->db->where('C.estado_candidato', $arrData["estadoCandidato"]);
				}

				$this->db->order_by('C.nombres, C.apellidos', 'asc');

				$query = $this->db->get('candidatos C');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}


		
		
	    
	}