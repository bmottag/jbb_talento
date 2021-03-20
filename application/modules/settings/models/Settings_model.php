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
		 * Actualizar disponibilidad de horarios
		 * @since 3/3/2021
		 */
		public function actualizarDisponibilidadHorarios() 
		{
			//cambiar todos los horarios VIGENTES, que estan Bloqueados por el administrador (3) a DISPONIBLES (1)
			$data['disponible'] = 1;
			$this->db->where('disponible', 3);
			$query = $this->db->update('horarios', $data);
			

			//update states
			$query = 1;
			if ($disponibilidad = $this->input->post('disponibilidad')) {
				$tot = count($disponibilidad);
				for ($i = 0; $i < $tot; $i++) {
					$data['disponible'] = 3;
					$this->db->where('id_horario', $disponibilidad[$i]);
					$query = $this->db->update('horarios', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		
		
	    
	}