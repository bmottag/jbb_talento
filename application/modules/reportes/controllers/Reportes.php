<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("reportes_model");
		$this->load->library('PHPExcel.php');
    }
	
	/**
	 * Generate Reportes in XLS
     * @since 3/09/2021
     * @author BMOTTAG
	 */		
	public function generaReporteFinalXLS($idProceso)
	{				
			//Candidatos activos
			$arrParam = array(
				'idProceso' => $idProceso,
				'estadoCandidato' => 1
			);
			$infoCandidatos = $this->reportes_model->get_candidatos_info($arrParam);

			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("JBB APP")
										 ->setLastModifiedBy("JBB APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("JBB Report")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$objPHPExcel->setActiveSheetIndex(0);
						
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'DEPENDENCIA')
										->setCellValue('B2', 'PROCESO')
										->setCellValue('C2', 'NOMBRES')
										->setCellValue('D2', 'DOCUMENTO')
										->setCellValue('E2', 'EDAD')
										->setCellValue('F2', 'Profesión')
										->setCellValue('G2', 'Grupo')
										->setCellValue('H2', 'Asertividad')
										->setCellValue('I2', 'Comunicación')
										->setCellValue('J2', 'Autoestima')
										->setCellValue('K2', 'Toma Decisión')
										->setCellValue('L2', 'LOGRO')
										->setCellValue('M2', 'PODER')
										->setCellValue('N2', 'AFILIACION')
										->setCellValue('O2', 'AUTO REALIZACION')
										->setCellValue('P2', 'RECONOCIMIENTO')
										->setCellValue('Q2', 'DEDICCACION AL TRABAJO')
										->setCellValue('R2', 'ACEPTACION DE LA AUTORIDAD')
										->setCellValue('S2', 'ACEPTACION A NORMAS Y VALORES')
										->setCellValue('T2', 'REQUISICION')
										->setCellValue('U2', 'EXPECTACION')
										->setCellValue('V2', 'SUPERVISION')
										->setCellValue('W2', 'GRUPO DE TRABAJO')
										->setCellValue('X2', 'CONTENIDO DEL TRABAJO')
										->setCellValue('Y2', 'SALARIO')
										->setCellValue('Z2', 'PROMOCION')
										;
										
			$j=3;

			if($infoCandidatos){
				foreach ($infoCandidatos as $info):
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $info['dependencia'])
													  ->setCellValue('B'.$j, $info['numero_proceso'])
													  ->setCellValue('C'.$j, $info['nombres'])
													  ->setCellValue('D'.$j, $info['numero_identificacion'])
													  ->setCellValue('E'.$j, $info['edad'])
													  ->setCellValue('F'.$j, $info['profesion'])
													  ->setCellValue('G'.$j, $info['tipo_proceso'])
													  ->setCellValue('H'.$j, $info['ASE'])
													  ->setCellValue('I'.$j, $info['COM'])
													  ->setCellValue('J'.$j, $info['AUT'])
													  ->setCellValue('K'.$j, $info['TOM'])
													  ->setCellValue('L'.$j, $info['LOG'])
													  ->setCellValue('M'.$j, $info['DT'])
													  ->setCellValue('N'.$j, $info['SUP'])
													  ->setCellValue('O'.$j, $info['POD'])
													  ->setCellValue('P'.$j, $info['AA'])
													  ->setCellValue('Q'.$j, $info['GT'])
													  ->setCellValue('R'.$j, $info['AFI'])
													  ->setCellValue('S'.$j, $info['ANV'])
													  ->setCellValue('T'.$j, $info['CT'])
													  ->setCellValue('U'.$j, $info['A-R'])
													  ->setCellValue('V'.$j, $info['REQ'])
													  ->setCellValue('W'.$j, $info['SAL'])
													  ->setCellValue('X'.$j, $info['REC'])
													  ->setCellValue('Y'.$j, $info['EXP'])
													  ->setCellValue('Z'.$j, $info['PRO']);
						$j++;
				endforeach;
			}

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(18);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
			$objConditional1->getStyle()->getAlignment()->setVertical('center')->setHorizontal('center');
			$objConditional1->getStyle()->getBorders()->applyFromArray(array('allBorders' => 'thin'));

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );


			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Informe Final');

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="informe_final.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }

	
}