<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("settings_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * employee List
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function employee($state)
	{			
			$data['state'] = $state;
			
			if($state == 1){
				$arrParam = array("filtroState" => TRUE);
			}else{
				$arrParam = array("state" => $state);
			}
			
			$data['info'] = $this->general_model->get_user($arrParam);
			
			$data["view"] = 'employee';
			$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Cargo modal - formulario Employee
     * @since 15/12/2016
     */
    public function cargarModalEmployee() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idEmployee"] = $this->input->post("idEmployee");	
			
			$arrParam = array("filtro" => TRUE);
			$data['roles'] = $this->general_model->get_roles($arrParam);

			if ($data["idEmployee"] != 'x') {
				$arrParam = array(
					"table" => "usuarios",
					"order" => "id_user",
					"column" => "id_user",
					"id" => $data["idEmployee"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("employee_modal", $data);
    }
	
	/**
	 * Update Employee
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function save_employee()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddId');

			$msj = "Se adicionó un nuevo Usuario!";
			if ($idUser != '') {
				$msj = "Se actualizó el Usuario!";
			}			

			$log_user = $this->input->post('user');
			$email_user = $this->input->post('email');
			
			$result_user = false;
			$result_email = false;
			
			//verificar si ya existe el usuario
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "log_user",
				"value" => $log_user
			);
			$result_user = $this->settings_model->verifyUser($arrParam);
			
			//verificar si ya existe el correo
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "email",
				"value" => $email_user
			);
			$result_email = $this->settings_model->verifyUser($arrParam);

			$data["state"] = $this->input->post('state');
			if ($idUser == '') {
				$data["state"] = 1;//para el direccionamiento del JS, cuando es usuario nuevo no se envia state
			}

			if ($result_user || $result_email)
			{
				$data["result"] = "error";
				if($result_user)
				{
					$data["mensaje"] = " Error. El Usuario ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El Usuario ya existe.');
				}
				if($result_email)
				{
					$data["mensaje"] = " Error. El correo ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El correo ya existe.');
				}
				if($result_user && $result_email)
				{
					$data["mensaje"] = " Error. El Usuario y el Correo ya existen.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El Usuario y el Correo ya existen.');
				}
			} else {
					if ($this->settings_model->saveEmployee()) {
						$data["result"] = true;					
						$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
					} else {
						$data["result"] = "error";					
						$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
					}
			}

			echo json_encode($data);
    }
	
	/**
	 * Reset employee password
	 * Reset the password to '123456'
	 * And change the status to '0' to changue de password 
     * @since 11/1/2017
     * @author BMOTTAG
	 */
	public function resetPassword($idUser)
	{
			if ($this->settings_model->resetEmployeePassword($idUser)) {
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> You have reset the Employee pasword to: 123456');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
			
			redirect("/settings/employee/",'refresh');
	}	

	/**
	 * Change password
     * @since 15/4/2017
     * @author BMOTTAG
	 */
	public function change_password($idUser)
	{
			if (empty($idUser)) {
				show_error('ERROR!!! - You are in the wrong place. The ID USER is missing.');
			}
			
			$arrParam = array(
				"table" => "usuarios",
				"order" => "id_user",
				"column" => "id_user",
				"id" => $idUser
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		
			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update user´s password
	 */
	public function update_password()
	{
			$data = array();			
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$userState = $this->input->post("hddState");
			
			//Para redireccionar el usuario
			if($userState!=2){
				$userState = 1;
			}
			
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
			
			$data['linkBack'] = "settings/employee/" . $userState;
			$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CAMBIAR CONTRASEÑA";
			
			if($newPassword == $confirm)
			{					
					if ($this->settings_model->updatePassword()) {
						$data['msj'] = 'Se actualizó la contrasela del usuario.';
						$data['msj'] .= '<br>';
						$data['msj'] .= '<br><strong>Nombre Usuario: </strong>' . $this->input->post('hddUser');
						$data['msj'] .= '<br><strong>Contraseña: </strong>' . $passwd;
						$data['clase'] = 'alert-success';
					}else{
						$data['msj'] = '<strong>Error!!!</strong> Ask for help.';
						$data['clase'] = 'alert-danger';
					}
			}else{
				//definir mensaje de error
				echo "pailas no son iguales";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Lista de candidatos
     * @since 19/3/2021
     * @author BMOTTAG
	 */
	public function candidatos($state)
	{
			$data['state'] = $state;

			$arrParam = array('estadoCandidato' => $state);
			$data['infoCandidatos'] = $this->general_model->get_candidatos_info($arrParam);
			
			$data["view"] = 'candidatos';
			$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Cargo modal - formulario CANDIDATOS
     * @since 19/3/2021
     */
    public function cargarModalCandidatos() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idCandidato"] = $this->input->post("idCandidato");	

			$arrParam = array(
				"table" => "param_nivel_academico",
				"order" => "id_nivel_academico",
				"id" => "x"
			);
			$data['nivelAcademico'] = $this->general_model->get_basic_search($arrParam);

			$arrParam = array("estadoProceso" => 1);
			$data['procesos'] = $this->general_model->get_procesos_info($arrParam);

			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
		
			if ($data["idCandidato"] != 'x') {
				$arrParam = array("idCandidato" => $data["idCandidato"]);
				$data['information'] = $this->general_model->get_candidatos_info($arrParam);
			}
			
			$this->load->view("candidatos_modal", $data);
    }
	
	/**
	 * Save candidato
     * @since 24/3/2021
     * @author BMOTTAG
	 */
	public function save_candidato()
	{			
			header('Content-Type: application/json');
			$data = array();
		
			$bandera = $idCandidato = $this->input->post('hddId');
			
			$msj = "Se adicionó el Candidato!";
			if ($idCandidato != '') {
				$msj = "Se actualizó el Candidato!";
			}

			$numeroIdentificacionCandidato = $this->input->post('numeroIdentificacion');
			$emailCandidato = $this->input->post('email');
			
			$result_candidato = false;
			$result_email = false;
			
			//verificar si ya existe el usuario
			$arrParam = array(
				"idCandidato" => $idCandidato,
				"column" => "numero_identificacion",
				"value" => $numeroIdentificacionCandidato
			);
			$result_candidato = $this->settings_model->verificarCandidato($arrParam);
			
			//verificar si ya existe el correo
			$arrParam = array(
				"idCandidato" => $idCandidato,
				"column" => "correo",
				"value" => $emailCandidato
			);
			$result_email = $this->settings_model->verificarCandidato($arrParam);

			if ($result_candidato || $result_email)
			{
				$data["result"] = "error";
				if($result_candidato)
				{
					$data["mensaje"] = " Error. El número de identificación ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El número de identificación ya existe.');
				}
				if($result_email)
				{
					$data["mensaje"] = " Error. El correo ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El correo ya existe.');
				}
				if($result_candidato && $result_email)
				{
					$data["mensaje"] = " Error. El número de identificación y el correo ya existen.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El número de identificación y el correo ya existen.');
				}
			} else {
				if ($idCandidato = $this->settings_model->saveCandidato()) 
				{
					if ($bandera == '') {
						//creo registro de calculo de competencias para el candidato
						$this->settings_model->saveCalculoCompetenciasRecord($idCandidato);
					}
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
				}
			}

			echo json_encode($data);	
    }

	/**
	 * Bloquear/Desbloqear CANDIDATOS
     * @since 24/3/2021
     * @author BMOTTAG
	 */
	public function bloquear_candidatos($state)
	{	
			if ($this->settings_model->actualizarEstadoCandidatos($state)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "Se actualizó el estado de los Candidatos!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('settings/candidatos/1'), 'refresh');
	}

	/**
	 * Lista de procesos
     * @since 19/3/2021
     * @author BMOTTAG
	 */
	public function procesos($state)
	{
			$data['state'] = $state;

			$arrParam = array('estadoProceso' => $state);
			$data['infoProcesos'] = $this->general_model->get_procesos_info($arrParam); 
			$data["view"] = 'procesos';
			$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Cargo modal - formulario PROCESOS
     * @since 19/3/2021
     */
    public function cargarModalProcesos() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idProceso"] = $this->input->post("idProceso");	

			$arrParam = array(
				"table" => "param_dependencias",
				"order" => "dependencia",
				"id" => "x"
			);
			$data['dependencias'] = $this->general_model->get_basic_search($arrParam);

			$arrParam = array(
				"table" => "param_tipo_proceso",
				"order" => "tipo_proceso",
				"id" => "x"
			);
			$data['tipoProceso'] = $this->general_model->get_basic_search($arrParam);
			
			if ($data["idProceso"] != 'x') {
				$arrParam = array("idProceso" => $data["idProceso"]);
				$data['information'] = $this->general_model->get_procesos_info($arrParam);
			}
			
			$this->load->view("procesos_modal", $data);
    }
	
	/**
	 * Save procesos
     * @since 19/3/2021
     * @author BMOTTAG
	 */
	public function save_procesos()
	{			
			header('Content-Type: application/json');
			$data = array();
		
			$idProceso = $this->input->post('hddId');
			
			$msj = "Se adicionó un nuevo Proceso!";
			if ($idProceso != '') {
				$msj = "Se actualizó el Proceso!";
			}

			if ($idProceso = $this->settings_model->saveProceso()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}

			echo json_encode($data);	
    }

	/**
	 * Bloquear/Desbloqear procesos
     * @since 24/3/2021
     * @author BMOTTAG
	 */
	public function bloquear_procesos($state)
	{	
			if ($this->settings_model->actualizarEstadoProcesos($state)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "Se actualizó el estado de los Procesos!!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('settings/procesos/1'), 'refresh');
	}

	/**
	 * Lista de competencias
     * @since 12/4/2021
     * @author BMOTTAG
	 */
	public function competencias()
	{						
			$data['info'] = $this->general_model->get_competencias_variables();

			$data["view"] = 'competencias';
			$this->load->view("layout_calendar", $data);
	}
	
	/**
	 * Lista de valores para las variables de competencias
     * @since 12/4/2021
     * @author BMOTTAG
	 */
	public function valores_variables($tipoProceso)
	{						
			$arrParam = array('idTipoProceso' => $tipoProceso);
			$data['info'] = $this->general_model->get_valores_variables($arrParam);

			$data["view"] = 'valores_variables';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Lista de municipios por departamentos
     * @since 12/5/2017
	 */
    public function mcpioList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idDepto'] = $this->input->post('identificador');
			$this->load->model("general_model");
			$lista = $this->general_model->get_municipios_by($arrParam);
		
			echo "<option value=''>Seleccione...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idMcpio"] . "' >" . $fila["municipio"] . "</option>";
				}
			}
    }

	/**
	 * Evio de correo
     * @since 11/8/2021
     * @author BMOTTAG
	 */
	public function email($idUsuario)
	{
			$arrParam = array('idUser' => $idUsuario);
			$infoUsuario = $this->general_model->get_user($arrParam);
			$to = $infoUsuario[0]['email'];

			//reiniciar primero la contraseña del usuario a Jardin2021 y estado colocarlo en cero
			$arrParam['passwd'] = 'Jardin2021';
			$resetPassword = $this->settings_model->resetEmployeePassword($arrParam);

			//busco datos parametricos de configuracion para envio de correo
			$arrParam2 = array(
				"table" => "parametros",
				"order" => "id_parametro",
				"id" => "x"
			);
			$parametric = $this->general_model->get_basic_search($arrParam2);

			$paramHost = $parametric[0]["parametro_valor"];
			$paramUsername = $parametric[1]["parametro_valor"];
			$paramPassword = $parametric[2]["parametro_valor"];
			$paramFromName = $parametric[3]["parametro_valor"];

			//mensaje del correo
			$msj = '<p>Sr.(a) ' . $infoUsuario[0]['first_name'] . ' se activo su ingreso a la plataforma de Talento Humano del Jardín Botánico de Bogotá,';
			$msj .= ' siga el enlace con las credenciales para acceder.</p>';
			$msj .= '<p>Recuerde cambiar su contraseña para activar su cuenta.</p>';
			$msj .= '<p><strong>Enlace: </strong>' . base_url('login');
			$msj .= '<br><strong>Usuario: </strong>' . $infoUsuario[0]['log_user'];
			$msj .= '<br><strong>Contraseña: </strong>' . $arrParam['passwd'];
									
			$mensaje = "<p>$msj</p>
						<p>Cordialmente,</p>
						<p><strong>Jardín Botánico de Bogotá</strong></p>";		

			require_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');
            $mail = new PHPMailer(true);

            try {
                    $mail->IsSMTP(); // set mailer to use SMTP
                    $mail->Host = $paramHost; // specif smtp server
                    $mail->SMTPSecure= "tls"; // Used instead of TLS when only POP mail is selected
                    $mail->Port = 587; // Used instead of 587 when only POP mail is selected
                    $mail->SMTPAuth = true;
					$mail->Username = $paramUsername; // SMTP username
                    $mail->Password = $paramPassword; // SMTP password
                    $mail->FromName = $paramFromName;
                    $mail->From = $paramUsername;
                    $mail->AddAddress($to, 'Usuario JJB Talento Humano');
                    $mail->WordWrap = 50;
                    $mail->CharSet = 'UTF-8';
                    $mail->IsHTML(true); // set email format to HTML
                    $mail->Subject = 'Jardín Botánico de Bogotá - Talento Humano';

                    $mail->Body = nl2br ($mensaje,false);

                    $data['linkBack'] = "settings/employee/1";
					$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CAMBIAR CONTRASEÑA";

                    if($mail->Send())
                    {
						$data['msj'] = 'Se actualizó la contraseña del usuario.';
						$data['msj'] .= '<br>';
						$data['msj'] .= '<br><strong>Nombre Usuario: </strong>' . $infoUsuario[0]['first_name'];
						$data['msj'] .= '<br><strong>Contraseña: </strong>' . $arrParam['passwd'];
						$data['msj'] .= '<br><br><p>La información con los datos de ingreso fue enviada al correo electrónico del usuario, quien debe cambiar la contraseña para activar la cuenta.</p>';
						$data['clase'] = 'alert-success';

                        $this->session->set_flashdata('retorno_exito', 'Creaci&oacute;n de usuario exitosa!. La informaci&oacute;n para activar su cuenta fu&eacute; enviada al correo registrado, recuerde aceptar los t&eacute;rminos y condiciones y cambiar su contrase&ntilde;a');
                        //redirect(base_url(), 'refresh');
                        //exit;

                    }else{
						$data['msj'] = 'Se actualizó la contraseña del usuario, sin embargo no se pudo enviar el correo electrónico.';
						$data['msj'] .= '<br>';
						$data['msj'] .= '<br><strong>Nombre Usuario: </strong>' . $infoUsuario[0]['first_name'];
						$data['msj'] .= '<br><strong>Contraseña: </strong>' . $arrParam['passwd'];
						$data['clase'] = 'alert-success';

                        $this->session->set_flashdata('retorno_error', 'Se creo la persona, sin embargo no se pudo enviar el correo electr&oacute;nico');
                       // redirect(base_url(), 'refresh');
                       //exit;

                    }

					$data["view"] = "template/answer";
					$this->load->view("layout", $data);

                }catch (Exception $e){
                                print_r($e->getMessage());
                                        exit;
                }

	}

	
	
}