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
					'fk_dpto_divipola' => $this->input->post('depto'),
					'fk_mpio_divipola' => $this->input->post('mcpio'),
					'profesion' => $this->input->post('profesion')
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
		 * Crear formulario de habilidades
		 * @since 17/4/2021
		 */
		public function saveFormularioHabilidades() 
		{				
				$data = array(
					'fk_id_candidato_fh' => $this->session->id,
					'numero_parte_formulario' => 1,
					'fecha_registro_inicio' => date("Y-m-d G:i:s")
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
		 * Actualizar datos del formulario
		 * @since 19/4/2021
		 */
		public function updateFormularioHabilidades() 
		{				
				$idFormulario = $this->input->post('hddIdFormHabilidades');
				$NoParte = $this->input->post('hddIdFormNoParte') + 1;

				$data = array(
					'numero_parte_formulario' => $NoParte,
					'fecha_registro_fin' => date("Y-m-d G:i:s")
				);	

				$this->db->where('id_form_habilidades', $idFormulario);
				$query = $this->db->update('form_habilidades', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Guardar informacion del formulario
		 * @since 8/4/2021
		 */
		public function saveRespuestasFormulario() 
		{
			//update states
			$query = 1;
			
			$idFormulario = $this->input->post('hddIdFormHabilidades');
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

		/**
		 * Crear formulario de aspectos de interes
		 * @since 8/4/2021
		 */
		public function saveFormularioAspectosInteres() 
		{				
				$data = array(
					'fk_id_candidato_fai' => $this->session->id,
					'numero_parte_formulario' => 1,
					'fecha_registro_inicio' => date("Y-m-d G:i:s")
				);	
				$query = $this->db->insert('form_aspectos_interes', $data);

				$idFormulario = $this->db->insert_id();
				if ($query) {
					return $idFormulario;
				} else {
					return false;
				}
		}

		/**
		 * Actualizar datos del formulario
		 * @since 9/4/2021
		 */
		public function updateFormularioAspectosInteres() 
		{				
				$idFormulario = $this->input->post('hddIdFormAspectos');
				$NoParte = $this->input->post('hddIdFormNoParte') + 1;
				$NoPreguntas = $this->input->post('hddNoPreguntas');
				$noProximaPregunta = $this->input->post('hddNoProximaPregunta') + $NoPreguntas;

				$data = array(
					'numero_parte_formulario' => $NoParte,
					'numero_proxima_pregunta' => $noProximaPregunta,
					'fecha_registro_fin' => date("Y-m-d G:i:s")
				);	

				$this->db->where('id_form_aspectos_interes', $idFormulario);
				$query = $this->db->update('form_aspectos_interes', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Guardar respuestas del formulario de aspesctos de interes
		 * @since 9/4/2021
		 */
		public function saveRespuestasFormularioAspectosInteres() 
		{
			//update states
			$query = 1;
			
			$idFormulario = $this->input->post('hddIdFormAspectos');
			$NoPreguntas = $this->input->post('hddNoPreguntas');
			$noProximaPregunta = $this->input->post('hddNoProximaPregunta');
			$finalPreguntas = $NoPreguntas + $noProximaPregunta;

			if ($respuesta = $this->input->post('pregunta')) 
			{
				for ($i = $noProximaPregunta; $i <= $finalPreguntas; $i++) 
				{
					if (array_key_exists($i,$respuesta))
					{
						$data = array(
							'fk_id_formulario_aspectos_interes' => $idFormulario,
							'fk_id_opciones_aspectos_interes' => $i,
							'respuesta_aspectos_interes' => $respuesta[$i]
						);	
						$query = $this->db->insert('form_aspectos_interes_respuestas', $data);
					}

				}
			}

			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Crear registro de sumatoria para un formulario
		 * @since 11/4/2021
		 */
		public function saveCalculoRecord($arrData) 
		{				
				$data = array(
					$arrData['columnaFormulario'] => $arrData['idFormulario']
				);	
				$query = $this->db->insert($arrData['table'], $data);
				if($query){
					return true;
				}else{
					return false;
				}
		}

		/**
		 * Aplico la sumatoria y guardo en la base de datos
		 * @since 11/4/2021
		 */
		public function aplicar_formula_aspectos_interes($arrData)
		{
				$idFormulario = $this->input->post('hddIdFormAspectos');

				$sql = "SELECT sum(respuesta_aspectos_interes) resultado FROM form_aspectos_interes_respuestas H INNER JOIN param_aspectos_interes_opciones O ON O.id_opciones_aspectos_interes = H.fk_id_opciones_aspectos_interes WHERE fk_id_formulario_aspectos_interes  = " . $idFormulario. " AND codigo IN(" . $arrData['formula'] . ")";
				$query = $this->db->query($sql);

				if ($query->num_rows() > 0) 
				{
					$resultado = $query->result_array();
					$resultado = $resultado[0]['resultado']?$resultado[0]['resultado']:0;

					$campo = $arrData['descripcion'];

					$data = array(
						$campo => $resultado
					);	
					$this->db->where('fk_id_form_aspectos_interes_c', $idFormulario);
					$query = $this->db->update('form_aspectos_interes_calculos', $data);


					//busco en la tabla de param_competencias_valores las datos para calculo de las desviaciones estandar
					//se busca por el valor de la competencia y por el tipo de proceso
					$idTipoProceso = $this->input->post('hddIdTipoProceso');

					$this->db->select();
					$this->db->join('param_competencias_relacion_formulas R', 'R.id_competencias_relacion = V.fk_id_competencias_relacion', 'INNER');
					$this->db->join('param_competencias C', 'C.id_competencia = R.fk_id_competencias', 'INNER');
					$this->db->join('param_competencias_formulas F', 'F.id_competencias_formulas = R.fk_id_competencias_formulas', 'INNER');
					$this->db->where('V.fk_id_tipo_proceso', $idTipoProceso);
					$this->db->where('F.descripcion', $campo);
					$query = $this->db->get('param_competencias_valores V');

					if ($query->num_rows() >= 1) {
						$datos = $query->result_array();
						$conteo = count($datos);

						//ACTUALIZO LA TABLA CON LOS DATOS
						for ($i = 0; $i < $conteo; $i++) 
						{
							$media = $datos[$i]['media'];
							$DS = $datos[$i]['desviacion_estandar'];
							$alto = $media + $DS;
							$bajo = $media - $DS;
							$columna = $datos[$i]['sigla'] . '-' . $datos[$i]['descripcion'];

							if($resultado>$alto){
								$valor = 'alto';
							}elseif($resultado<$bajo){
								$valor = 'bajo';
							}else{
								$valor = 'medio';
							}

							$data = array(
								$columna => $valor
							);	
							$this->db->where('fk_id_form_aspectos_interes_cc', $idFormulario);
							$query = $this->db->update('form_competencias_calculos', $data);
						}
					}
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Aplico la sumatoria y guardo en la base de datos para formulario dde habilidades
		 * @since 17/4/2021
		 */
		public function aplicar_formula_habilidades($arrData)
		{
				$idFormulario = $this->input->post('hddIdFormHabilidades');

				$sql = "SELECT sum(respuesta_habilidad) resultado FROM form_habilidades_respuestas H WHERE fk_id_formulario_habilidades = " . $idFormulario . " AND fk_id_pregunta_habilidades BETWEEN " . $arrData['valMin'] . " AND " . $arrData['valMax'];
				$query = $this->db->query($sql);

				if ($query->num_rows() > 0) 
				{
					$resultado = $query->result_array();
					$resultado = $resultado[0]['resultado']?$resultado[0]['resultado']:0;

					$campo = $arrData['descripcion'];

					$data = array($campo => $resultado);	
					$this->db->where('fk_id_form_habilidades_c', $idFormulario);
					$query = $this->db->update('form_habilidades_calculos', $data);

					if ($query)
					{
						//actualizo el id del formulario en la tabla de form_competencias_calculos
						$idCandidato = $this->input->post('hddIdCandidato');
						$data = array('fk_id_form_habilidades_cc' => $idFormulario);	
						$this->db->where('fk_id_candidato_cc', $idCandidato);
						$query = $this->db->update('form_competencias_calculos', $data);
						
						//busco en la tabla de param_competencias_valores las datos para calculo de las desviaciones estandar
						//se busca por el valor de la competencia y por el tipo de proceso
						$idTipoProceso = $this->input->post('hddIdTipoProceso');

						$this->db->select();
						$this->db->join('param_competencias_relacion_formulas R', 'R.id_competencias_relacion = V.fk_id_competencias_relacion', 'INNER');
						$this->db->join('param_competencias C', 'C.id_competencia = R.fk_id_competencias', 'INNER');
						$this->db->join('param_competencias_formulas F', 'F.id_competencias_formulas = R.fk_id_competencias_formulas', 'INNER');
						$this->db->where('V.fk_id_tipo_proceso', $idTipoProceso);
						$this->db->where('F.descripcion', $campo);
						$query = $this->db->get('param_competencias_valores V');

						if ($query->num_rows() >= 1) {
							$datos = $query->result_array();
							$conteo = count($datos);

							//ACTUALIZO LA TABLA CON LOS DATOS
							for ($i = 0; $i < $conteo; $i++) 
							{
								$media = $datos[$i]['media'];
								$DS = $datos[$i]['desviacion_estandar'];
								$alto = $media + $DS;
								$bajo = $media - $DS;
								$columna = $datos[$i]['sigla'] . '-' . $datos[$i]['descripcion'];

								if($resultado>$alto){
									$valor = 'alto';
								}elseif($resultado<$bajo){
									$valor = 'bajo';
								}else{
									$valor = 'medio';
								}

								$data = array($columna => $valor);	
								$this->db->where('fk_id_form_habilidades_cc', $idFormulario);
								$query = $this->db->update('form_competencias_calculos', $data);
							}
						}


						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
		}

		/**
		 * actualizo el id del formulario en la tabla de form_competencias_calculos
		 * @since 4/5/2021
		 */
		public function updateIdFormularioTablaCompetencia() 
		{
			$idCandidato = $this->input->post('hddIdCandidato');
			$idFormulario = $this->input->post('hddIdFormAspectos');

			$data = array('fk_id_form_aspectos_interes_cc' => $idFormulario);	
			$this->db->where('fk_id_candidato_cc', $idCandidato);
			$query = $this->db->update('form_competencias_calculos', $data);

			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		

		
	    
	}