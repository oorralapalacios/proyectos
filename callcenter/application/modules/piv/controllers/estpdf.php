<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estpdf extends MX_Controller
{
	function __construct()
	{
                parent::__construct();
                modules::run('login/autentificado');
				Datamapper::add_model_path( array( APPPATH.'modules/piv/' ) );
				
	}

	function index()
	{
            //$this->load->view('includes/header_panel');
			$this->load->view('piv/estcall_view');
			
			
	}
	
	
	function generar_pdf(){
	//echo json_encode($this->input->post('accion'));
	switch($this->input->post('accion')){
		case 'rep':	
		$html=$this->input->post('html');
		echo $html;
		
		break;
	   }
	}
	
	function generar_pdf1(){
		
		switch($this->input->post('accion')){
		case 'rep':	
		$html=$this->input->post('html');
		//echo $html;
		//$html="";
		$this->load->library('tcpdf'); //tcpdf
		
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Omar Orrala');
        $pdf->SetTitle('Reporte de llamadas con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData('logo.jpg', PDF_HEADER_LOGO_WIDTH, 'Estadisticas ','', array(0, 64, 255), array(0, 64, 128));
        //$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//relaci?n utilizada para ajustar la conversi?n de los p?xeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
// ---------------------------------------------------------
// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
// Establecer el tipo de letra
//Si tienes que imprimir car?cteres ASCII est?ndar, puede utilizar las fuentes b?sicas como
// Helvetica para reducir el tama?o del archivo.
        //$pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->SetFont('helvetica', '', 10, '', true);
        
		$pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
        //$pdf->SetFont('', 'B');
 
// A?adir una p?gina
// Este m?todo tiene varias opciones, consulta la documentaci?n para m?s informaci?n.
		//$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
		//$pdf->setPrintFooter(false); // imprime el pie ni la linea

        $pdf->AddPage();
 
//fijar efecto de sombra en el texto
       //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
	
 
        $pdf->writeHTML($html, true, false, true, false, '');
		
		//$pdf->lastPage();
	   
 
// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este m?todo tiene varias opciones, consulte la documentaci?n para m?s informaci?n.
        $nombre_archivo = utf8_decode("Reporte Estadistico.pdf");
        $pdf->Output($nombre_archivo, 'I');
		
		
		break;
	   }
	
				

	}	
	
	 
}
