<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preguntas extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        $page['main_content'] = 'campana_view';
        $this->load->view('includes/template_panel', $page);
    }
	
	function preguntas_datos($campana,$contacto){
		$select = "preguntas.*,CONCAT_WS('',(select opciones_respuesta from contacto_pregunta_respuesta rp where rp.preguntas_id=preguntas.id AND rp.contacto_campana_id=".$contacto." Limit 1)) AS respuesta_texto, (select multiple_respuesta from escalas e where e.id=preguntas.tipo_respuesta_id) as multiple_respuesta";
		//$select = "preguntas.*, (select multiple_respuesta from escalas e where e.id=preguntas.tipo_respuesta_id) as multiple_respuesta";
	    $obj = new Pregunta();
		$obj->select ($select);
		$obj->where('campana_id', $campana)->get();
		$datos_array = array();
		
		 foreach ($obj as $o) {
		 	
		 		 
		 	 $this->db->select("preguntas.id,opciones_respuestas.detalle,opciones_respuestas.objeto, (SELECT opciones_respuesta FROM contacto_pregunta_respuesta WHERE preguntas_id=preguntas.id and contacto_campana_id=".$contacto." and opciones_respuesta=opciones_respuestas.detalle Limit 1) AS respuesta");
			 $this->db->join('preguntas', 'preguntas.tipo_respuesta_id=opciones_respuestas.escalas_id','left');
			 $this->db->from('opciones_respuestas');
			 $this->db->where('preguntas.id',$o->id);
			 $query=$this->db->get();
			 $results=$query->result_array();
			 
				array_push($datos_array,array(  
							"id" => $o->id,
							"orden" => $o->orden,
							"detalle_pregunta" => $o->detalle_pregunta."<br>",
							"escala_id" => $o->tipo_respuesta_id,
							"multiple_respuesta" => $o->multiple_respuesta,
							"respuesta_texto" => $o->respuesta_texto,
							"opciones" => ($results)							
						)); 
	     }
		 
	    //echo json_encode($datos_array);
	    return $datos_array;		
	}
	
	function opciones_respuesta($pregunta_id,$contacto,$escala_id){
	     $this->db->select("opciones_respuestas.*, (CASE 
				when detalle=(select opciones_respuesta from contacto_pregunta_respuesta
				where preguntas_id=".$pregunta_id." AND contacto_campana_id=".$contacto.") then 'checked'
				else '' end) AS respuesta");
		 $this->db->from('opciones_respuestas');
		 $this->db->where('escalas_id',$escala_id );
		 $query=$this->db->get();
		 $results=$query->result_array();
	     echo json_encode($results);		
	}
	
	function opciones_encuesta($escala){
	    $esc = new Opcion_escala();
		$query=$obj->opciones_preguntas($escala);
		$results=$query->result_array();
		return json_encode($results);
	}
	
	function preguntas_encuesta($campana){
		$this->db->select("preguntas.*,escalas.tipo_pregunta_id AS tipo_pregunta_id, escalas.nombre AS tipo_respuesta , (case 
						when escalas.tipo_pregunta_id=1 Then 'Pregunta Abierta'
						else 'Pregunta Cerrada'
						end) AS tipo_pregunta, escalas.multiple_respuesta");
		$this->db->join('escalas', 'escalas.id = preguntas.tipo_respuesta_id','left');
		$this->db->from('preguntas');
		$this->db->where('preguntas.campana_id', $campana);
		$this->db->where('preguntas.estado', 'AC');
		$this->db->order_by("preguntas.orden","ASC");
		$query=$this->db->get();
		$results=$query->result_array();
		echo json_encode($results);
		
	}
	
    function ajax(){
        switch($this->input->post('accion')){
			case 'dataPG':
				echo json_encode($this->preguntas_datos($this->input->post('campana_id'),$this->input->post('contacto_campana_id')));
				break;
			case 'SaveRP':
				$contacto_campana_id = $this->input->post('contacto_campana');
				$contacto_id = $this->input->post('contacto');
				$pregunta_id = $this->input->post('preg');
				$where = "contacto_campana_id = ".$contacto_campana_id." AND preguntas_id = ".$pregunta_id."";
				$res = new Contacto_pregunta_respuesta();
                $res->where($where)->get();
				$results = array();
                  foreach ($res as $r) {
                     $id = intval($r->id);
                  }
					//echo intval($id);			
					if ($id!=0){	
						if ($this->input->post('multi')==1){
							//verifica_respuesta($where);
							$where_m = "contactos_campana_id = ".$contacto_campana_id." AND preguntas_id = ".$pregunta_id." AND opciones_respuesta= '".$this->input->post('resp')."'";
							$res->where($where_m)->get();
							$res->opciones_respuesta=$this->input->post('resp');//cambiar a varchar
							$res->contacto_campana_id=$this->input->post('contacto_campana');
							$res->contactos_id=$this->input->post('contacto');
							$res->preguntas_id=$this->input->post('preg');
							$res->save();
							
						}else{
							$res->where($where)->get();
							$res->opciones_respuesta=$this->input->post('resp');//cambiar a varchar
							$res->save();
						}
						
					}else{
						
						$res->opciones_respuesta=$this->input->post('resp');//cambiar a varchar
						$res->contacto_campana_id=$this->input->post('contacto_campana');
						$res->contactos_id=$this->input->post('contacto');
						$res->preguntas_id=$this->input->post('preg');
						$res->save();
						
					}
				break;
            case 'add': 
                $pregunta = new Pregunta();
                $pregunta->orden=$this->input->post('orden');
				$pregunta->campana_id=$this->input->post('campana_id');
                $pregunta->detalle_pregunta=$this->input->post('detalle_pregunta');
				$pregunta->tipo_respuesta_id=$this->input->post('tipo_respuesta_id');
				$pregunta->obligatorio=$this->input->post('obligatorio');
                $pregunta->save();
				break;
            case 'edit':
                if($this->input->post('id')){
                    $pregunta = new Pregunta();
                    $pregunta->where('id', $this->input->post('id'))->get();
                    $pregunta->orden=$this->input->post('orden');
					$pregunta->campana_id=$this->input->post('campana_id');
                	$pregunta->detalle_pregunta=$this->input->post('detalle_pregunta');
					$pregunta->tipo_respuesta_id=$this->input->post('tipo_respuesta_id');
					$pregunta->obligatorio=$this->input->post('obligatorio');
                    $pregunta->save();
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $pregunta = new Pregunta();
                    $pregunta->where('id', $this->input->post('id'))->get();
                    $pregunta->estado='IN';
                    $pregunta->save();
                }
                break;
            default:
				//echo json_encode($this->preguntas_datos(1,56));
			
        }
    }
	
	
	
	
}
