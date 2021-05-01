<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
	
	/**
	 * Delete Record
	 * @since 25/5/2017
	 */
	public function deleteRecord($arrDatos) 
	{
			$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
			if ($query) {
				return true;
			} else {
				return false;
			}
	}
	
	/**
	 * Update field in a table
	 * @since 11/12/2016
	 */
	public function updateRecord($arrDatos) {
		$data = array(
			$arrDatos ["column"] => $arrDatos ["value"]
		);
		$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
		$query = $this->db->update($arrDatos ["table"], $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Lista de menu
	 * Modules: MENU
	 * @since 30/3/2020
	 */
	public function get_menu($arrData) 
	{		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuState", $arrData)) {
			$this->db->where('menu_state', $arrData["menuState"]);
		}
		if (array_key_exists("columnOrder", $arrData)) {
			$this->db->order_by($arrData["columnOrder"], 'asc');
		}else{
			$this->db->order_by('menu_order', 'asc');
		}
		
		$query = $this->db->get('param_menu');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}	

	/**
	 * Lista de roles
	 * Modules: ROL
	 * @since 30/3/2020
	 */
	public function get_roles($arrData) 
	{		
		if (array_key_exists("filtro", $arrData)) {
			$this->db->where('id_role !=', 99);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('id_role', $arrData["idRole"]);
		}
		
		$this->db->order_by('role_name', 'asc');
		$query = $this->db->get('param_role');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * User list
	 * @since 30/3/2020
	 */
	public function get_user($arrData) 
	{			
		$this->db->select();
		$this->db->join('param_role R', 'R.id_role = U.fk_id_user_role', 'INNER');
		if (array_key_exists("state", $arrData)) {
			$this->db->where('U.state', $arrData["state"]);
		}
		
		//list without inactive users
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('U.state !=', 2);
		}
		
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('U.id_user', $arrData["idUser"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('U.fk_id_user_role', $arrData["idRole"]);
		}

		$this->db->order_by("first_name, last_name", "ASC");
		$query = $this->db->get("usuarios U");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		} else
			return false;
	}
	
	/**
	 * Lista de enlaces
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_links($arrData) 
	{		
		$this->db->select();
		$this->db->join('param_menu M', 'M.id_menu = L.fk_id_menu', 'INNER');
		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('id_link', $arrData["idLink"]);
		}
		if (array_key_exists("linkType", $arrData)) {
			$this->db->where('link_type', $arrData["linkType"]);
		}			
		if (array_key_exists("linkState", $arrData)) {
			$this->db->where('link_state', $arrData["linkState"]);
		}
		
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_links L');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Lista de permisos
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_role_access($arrData) 
	{		
		$this->db->select('P.id_access, P.fk_id_menu, P.fk_id_link, P.fk_id_role, M.menu_name, M.menu_order, M.menu_type, L.link_name, L.link_url, L.order, L.link_icon, L.link_type, R.role_name, R.style');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
		$this->db->join('param_menu_links L', 'L.id_link = P.fk_id_link', 'LEFT');
		$this->db->join('param_role R', 'R.id_role = P.fk_id_role', 'INNER');
		
		if (array_key_exists("idPermiso", $arrData)) {
			$this->db->where('id_access', $arrData["idPermiso"]);
		}
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('P.fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('P.fk_id_link', $arrData["idLink"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("linkState", $arrData)) {
			$this->db->where('L.link_state', $arrData["linkState"]);
		}
		if (array_key_exists("menuURL", $arrData)) {
			$this->db->where('M.menu_url', $arrData["menuURL"]);
		}
		if (array_key_exists("linkURL", $arrData)) {
			$this->db->where('L.link_url', $arrData["linkURL"]);
		}		
		
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_access P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * menu list for a role
	 * Modules: MENU
	 * @since 2/4/2020
	 */
	public function get_role_menu($arrData) 
	{		
		$this->db->select('distinct(fk_id_menu), menu_url,menu_icon,menu_name,menu_order');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');

		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuState", $arrData)) {
			$this->db->where('M.menu_state', $arrData["menuState"]);
		}
					
		//$this->db->group_by("P.fk_id_menu"); 
		$this->db->order_by('M.menu_order', 'asc');
		$query = $this->db->get('param_menu_access P');

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
				$this->db->select();
				$this->db->join('candidatos_puntajes X', 'X.fk_id_candidato_p  = C.id_candidato', 'LEFT');
				$this->db->join('param_nivel_academico A', 'A.id_nivel_academico = C.fk_id_nivel_academico', 'INNER');
				$this->db->join('proceso P', 'P.id_proceso = C.fk_id_proceso', 'INNER');
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('C.id_candidato', $arrData["idCandidato"]);
				}
				if (array_key_exists("numeroIdentificacion", $arrData)) {
					$this->db->where('C.numero_identificacion', $arrData["numeroIdentificacion"]);
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
		 * Consultar registros de Respuestas
		 * @since 29/3/2021
		 */
		public function get_formulario_habilidades($arrData)
		{
				$this->db->select();
				$this->db->join('candidatos C', 'C.id_candidato = H.fk_id_candidato_fh', 'INNER');
				$this->db->join('proceso P', 'P.id_proceso = C.fk_id_proceso', 'INNER');
				if (array_key_exists("idFormHabilidades", $arrData)) {
					$this->db->where('H.id_form_habilidades', $arrData["idFormHabilidades"]);
				}
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('H.fk_id_candidato_fh', $arrData["idCandidato"]);
				}
				if (array_key_exists('estadoFormulario', $arrData)) {
					$this->db->where('H.estado_form_habilidades', $arrData['estadoFormulario']);
				}
				$this->db->order_by('H.id_form_habilidades', 'desc');

				$query = $this->db->get('form_habilidades H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de Respuestas
		 * @since 29/3/2021
		 */
		public function get_respuestas_formulario_habilidades($arrData)
		{
				$this->db->select();
				$this->db->join('param_preguntas_habilidades P', 'P.id_pregunta_habilidad = H.fk_id_pregunta_habilidades ', 'INNER');

				if (array_key_exists("idFormHabilidades", $arrData)) {
					$this->db->where('H.fk_id_formulario_habilidades', $arrData["idFormHabilidades"]);
				}
				$this->db->order_by('H.fk_id_pregunta_habilidades', 'asc');

				$query = $this->db->get('form_habilidades_respuestas H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de formaurlo de aspectgos de interes
		 * @since 8/4/2021
		 */
		public function get_formulario_aspectos_interes($arrData)
		{
				$this->db->select();
				$this->db->join('candidatos C', 'C.id_candidato = H.fk_id_candidato_fai', 'INNER');
				$this->db->join('proceso P', 'P.id_proceso = C.fk_id_proceso', 'INNER');
				if (array_key_exists("idFormAspectos", $arrData)) {
					$this->db->where('H.id_form_aspectos_interes', $arrData["idFormAspectos"]);
				}
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('H.fk_id_candidato_fai', $arrData["idCandidato"]);
				}
				if (array_key_exists('estadoFormulario', $arrData)) {
					$this->db->where('H.estado_form_aspectos_interes', $arrData['estadoFormulario']);
				}
				$this->db->order_by('H.id_form_aspectos_interes', 'desc');

				$query = $this->db->get('form_aspectos_interes H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar preguntas formulario de aspecto de interes
		 * @since 8/4/2021
		 */
		public function get_preguntas_aspectos_interes($arrData)
		{
				$this->db->select();
				if (array_key_exists("numeroParte", $arrData)) {
					$this->db->where('P.numero_parte ', $arrData["numeroParte"]);
				}
				$this->db->order_by('P.id_pregunta_aspecto_interes', 'asc');

				$query = $this->db->get('param_aspectos_interes_preguntas P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar opciones de las preguntas del formulario de aspecto de interes
		 * @since 9/4/2021
		 */
		public function get_opciones_preguntas_aspectos_interes($arrData)
		{
				$this->db->select();
				if (array_key_exists("idPregunta", $arrData)) {
					$this->db->where('P.fk_id_pregunta_aspecto_interes', $arrData["idPregunta"]);
				}
				$this->db->order_by('P.numero_opcion', 'asc');

				$query = $this->db->get('param_aspectos_interes_opciones P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de Respuestas cuestionario de aspectos de interes
		 * @since 29/3/2021
		 */
		public function get_formulario_aspectos($arrData)
		{
				$this->db->select();
				$this->db->join('candidatos C', 'C.id_candidato = H.fk_id_candidato_fai', 'INNER');
				$this->db->join('proceso P', 'P.id_proceso = C.fk_id_proceso', 'INNER');
				if (array_key_exists("idFormAspectos", $arrData)) {
					$this->db->where('H.id_form_aspectos_interes', $arrData["idFormAspectos"]);
				}
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('H.fk_id_candidato_fai', $arrData["idCandidato"]);
				}
				$this->db->order_by('H.id_form_aspectos_interes', 'desc');

				$query = $this->db->get('form_aspectos_interes H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de Respuestas cuestionario de aspectos de interes
		 * @since 10/4/2021
		 */
		public function get_respuestas_formulario_aspectos($arrData)
		{
				$this->db->select();
				$this->db->join('param_aspectos_interes_opciones O', 'O.id_opciones_aspectos_interes = H.fk_id_opciones_aspectos_interes', 'INNER');
				$this->db->join('param_aspectos_interes_preguntas P', 'P.id_pregunta_aspecto_interes = O.fk_id_pregunta_aspecto_interes', 'INNER');

				if (array_key_exists('idFormAspectos', $arrData)) {
					$this->db->where('H.fk_id_formulario_aspectos_interes', $arrData['idFormAspectos']);
				}
				$this->db->order_by('P.numero_pregunta_aspecto_interes , O.numero_opcion', 'asc');

				$query = $this->db->get('form_aspectos_interes_respuestas H');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de Calculos sumatoria formulario de aspectos de interes
		 * @since 11/4/2021
		 */
		public function get_calculos_formulario_aspectos($arrData)
		{
				$this->db->select("S.*, F.numero_parte_formulario, F.fecha_registro_inicio, F.fecha_registro_fin, C.id_candidato, CONCAT(nombres, ' ', apellidos) name, C.numero_identificacion");
				$this->db->join('form_aspectos_interes F', 'F.id_form_aspectos_interes = S.fk_id_form_aspectos_interes_c', 'INNER');
				$this->db->join('candidatos C', 'C.id_candidato = F.fk_id_candidato_fai', 'INNER');
				if (array_key_exists('estadoFormulario', $arrData)) {
					$this->db->where('F.estado_form_aspectos_interes', $arrData['estadoFormulario']);
				}
				if (array_key_exists("estadoCandidato", $arrData)) {
					$this->db->where('C.estado_candidato', $arrData["estadoCandidato"]);
				}
				$this->db->order_by('name', 'asc');

				$query = $this->db->get('form_aspectos_interes_calculos S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Lista de comeptencias
		 * @since 12/4/2021
		 */
		public function get_competencias_variables() 
		{			
				$this->db->select();
				$this->db->join('param_competencias C', 'C.id_competencia = R.fk_id_competencias', 'INNER');
				$this->db->join('param_competencias_formulas F', 'F.id_competencias_formulas = R.fk_id_competencias_formulas', 'INNER');

				$this->db->order_by('id_competencia', 'asc');
				$query = $this->db->get("param_competencias_relacion_formulas R");

				if($query->num_rows() >= 1){
					return $query->result_array();
				}else{
					return false;
				}
		}

		/**
		 * Lista de valores para las variables de las competencias
		 * @since 12/4/2021
		 */
		public function get_valores_variables($arrData) 
		{			
				$this->db->select();
				$this->db->join('param_tipo_proceso T', 'T.id_tipo_proceso = V.fk_id_tipo_proceso', 'INNER');
				$this->db->join('param_competencias_relacion_formulas R', 'R.id_competencias_relacion = V.fk_id_competencias_relacion', 'INNER');
				$this->db->join('param_competencias C', 'C.id_competencia = R.fk_id_competencias', 'INNER');
				$this->db->join('param_competencias_formulas F', 'F.id_competencias_formulas = R.fk_id_competencias_formulas ', 'INNER');
				if(array_key_exists("idTipoProceso", $arrData)){
					$this->db->where('V.fk_id_tipo_proceso', $arrData["idTipoProceso"]);
				}

				$this->db->order_by('id_competencia', 'asc');
				$query = $this->db->get("param_competencias_valores V");

				if ($query->num_rows() >= 1) {
					return $query->result_array();
				}else{
					return false;
				}
		}

		/**
		 * Consultar registros de Calculos para las competenias
		 * @since 16/4/2021
		 */
		public function get_calculos_competencias($arrData)
		{
				$this->db->select("CC.*, CONCAT(nombres, ' ', apellidos) name, C.numero_identificacion");
				$this->db->join('candidatos C', 'C.id_candidato = CC.fk_id_candidato_cc', 'INNER');
				if (array_key_exists('estadoCandidato', $arrData)) {
					$this->db->where('C.estado_candidato', $arrData['estadoCandidato']);
				}
				$this->db->order_by('name', 'asc');
				$query = $this->db->get('form_competencias_calculos CC');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de Calculos sumatoria formulario de Habilidades
		 * @since 18/4/2021
		 */
		public function get_calculos_formulario_habilidades($arrData)
		{
				$this->db->select("S.*, F.numero_parte_formulario, F.fecha_registro_inicio, F.fecha_registro_fin,  C.id_candidato, CONCAT(nombres, ' ', apellidos) name, C.numero_identificacion");
				$this->db->join('form_habilidades F', 'F.id_form_habilidades = S.fk_id_form_habilidades_c', 'INNER');
				$this->db->join('candidatos C', 'C.id_candidato = F.fk_id_candidato_fh', 'INNER');
				if (array_key_exists('estadoFormulario', $arrData)) {
					$this->db->where('F.estado_form_habilidades', $arrData['estadoFormulario']);
				}
				if (array_key_exists("estadoCandidato", $arrData)) {
					$this->db->where('C.estado_candidato', $arrData["estadoCandidato"]);
				}
				$this->db->order_by('name', 'asc');

				$query = $this->db->get('form_habilidades_calculos S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Consultar registros de puntajes
		 * @since 30/4/2021
		 */
		public function get_puntaje($arrData)
		{
				$this->db->select();
				if (array_key_exists('idPuntaje', $arrData)) {
					$this->db->where('P.id_puntaje', $arrData['idPuntaje']);
				}
				$query = $this->db->get('candidatos_puntajes P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}



}