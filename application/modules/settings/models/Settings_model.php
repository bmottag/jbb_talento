<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Settings_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @author BMOTTAG
		 * @since  8/11/2016
		 * @review 10/12/2020
		 */
		public function verifyUser($arrData) 
		{
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('id_user !=', $arrData["idUser"]);
				}			

				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("usuarios");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Add/Edit USER
		 * @since 8/11/2016
		 */
		public function saveEmployee() 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'first_name' => $this->input->post('firstName'),
					'last_name' => $this->input->post('lastName'),
					'log_user' => $this->input->post('user'),
					'movil' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email'),
					'fk_id_user_role' => $this->input->post('id_role')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') {
					$data['state'] = 0;//si es para adicionar se coloca estado inicial como usuario nuevo
					$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';//123456
					$query = $this->db->insert('usuarios', $data);
				} else {
					$data['state'] = $this->input->post('state');
					$this->db->where('id_user', $idUser);
					$query = $this->db->update('usuarios', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
	    /**
	     * Reset user´s password
	     * @author BMOTTAG
	     * @since  11/1/2017
	     */
	    public function resetEmployeePassword($idUser)
		{
				$passwd = '123456';
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'state' => 0
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('usuarios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }

	    /**
	     * Update user´s password
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('usuarios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		/**
		 * Add/Edit Proceso
		 * @since 19/3/2021
		 */
		public function saveProceso() 
		{
				$idProceso = $this->input->post('hddId');
				
				$data = array(
					'numero_proceso' => $this->input->post('numeroProceso'),
					'fk_id_tipo_proceso' => $this->input->post('id_tipo_proceso'),
					'fk_id_dependencia' => $this->input->post('id_dependencia')
				);	

				//revisar si es para adicionar o editar
				if ($idProceso == '') 
				{
					$data['estado_proceso'] = 1;
					$data['fecha_registro_proceso'] = date("Y-m-d");
					$query = $this->db->insert('proceso', $data);
				} else {
					$data['estado_proceso'] = $this->input->post('estado');
					$this->db->where('id_proceso', $idProceso);
					$query = $this->db->update('proceso', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Actualizar estado de los procesos
		 * @since 24/3/2021
		 */
		public function actualizarEstadoProcesos($state) 
		{
			//if it comes from the active view, then inactive everything
			//else do nothing and continue with the activation
			if($state == 1){
				//update all states to inactive
				$data['estado_proceso'] = 2;
				$query = $this->db->update('proceso', $data);
			}

			//update states
			$query = 1;
			if ($procesos = $this->input->post('disponibilidad')) {
				$tot = count($procesos);
				for ($i = 0; $i < $tot; $i++) {
					$data['estado_proceso'] = 1;
					$this->db->where('id_proceso', $procesos[$i]);
					$query = $this->db->update('proceso', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Verify si el candidato ya existe por numero de identificacion
		 * @author BMOTTAG
		 * @since  1/4/2021
		 */
		public function verificarCandidato($arrData) 
		{
				if (array_key_exists("idCandidato", $arrData)) {
					$this->db->where('id_candidato !=', $arrData["idCandidato"]);
				}			

				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("candidatos");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}

		/**
		 * Add/Edit CANDIDATO
		 * @since 24/3/2021
		 */
		public function saveCandidato() 
		{
				$idCandidato = $this->input->post('hddId');
				
				$data = array(
					'nombres' => $this->input->post('firstName'),
					'apellidos' => $this->input->post('lastName'),
					'numero_identificacion' => $this->input->post('numeroIdentificacion'),
					'correo' => $this->input->post('email'),
					'numero_celular' => $this->input->post('movilNumber'),
					'edad' => $this->input->post('edad'),
					'fk_id_nivel_academico' => $this->input->post('nivelAcademico'),
					'profesion' => $this->input->post('profesion'),
					'ciudad' => $this->input->post('ciudad'),
					'fk_id_proceso' => $this->input->post('numeroProceso')
				);	

				//revisar si es para adicionar o editar
				if ($idCandidato == '') {
					$data['estado_candidato'] = 1;//si es para adicionar se coloca estado inicial como ACTIVO
					$query = $this->db->insert('candidatos', $data);
					$idCandidato = $this->db->insert_id();
				} else {
					$data['estado_candidato'] = $this->input->post('state');
					$this->db->where('id_candidato', $idCandidato);
					$query = $this->db->update('candidatos', $data);
				}
				if ($query) {
					return $idCandidato;
				} else {
					return false;
				}
		}

		/**
		 * Crear registro de valores de las competencias
		 * @since 16/4/2021
		 */
		public function saveCalculoCompetenciasRecord($idCandidato) 
		{				
				$data = array(
					'fk_id_candidato_cc' => $idCandidato
				);	
				$query = $this->db->insert('form_competencias_calculos', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Actualizar estado de los candidatos
		 * @since 24/3/2021
		 */
		public function actualizarEstadoCandidatos($state) 
		{
			//if it comes from the active view, then inactive everything
			//else do nothing and continue with the activation
			if($state == 1){
				//update all states to inactive
				$data['estado_candidato'] = 2;
				$query = $this->db->update('candidatos', $data);
			}

			//update states
			$query = 1;
			if ($candidatos = $this->input->post('disponibilidad')) {
				$tot = count($candidatos);
				for ($i = 0; $i < $tot; $i++) {
					$data['estado_candidato'] = 1;
					$this->db->where('id_candidato', $candidatos[$i]);
					$query = $this->db->update('candidatos', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}


		
		
		
	    
	}