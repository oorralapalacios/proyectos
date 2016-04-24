<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Llamada extends DataMapper {
    var $extensions = array('json');
    var $table = 'llamadas';
	

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	//retorna total de registros en la base a mostrar en la bandeja de forma virtual
	function found_rows(){
		$sql="SELECT FOUND_ROWS() AS `found_rows`;";
		$query=$this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
		      $total= $row->found_rows;
		    
		   }
		} 
		return $total;
	}	
	
	function datails_query($conta_id = NULL){
    	
	    $sql ="SELECT @rownum:=@rownum+1 AS rownum, llamadas.*, campanas.nombre as campana 
        FROM ((SELECT @rownum:=0) r, llamadas, campanas)
        WHERE llamadas.campana_id=campanas.id
        and llamadas.estado='AC'
        and llamadas.contacto_id = ?;";
 		$binds = array($conta_id);
		return $this->db->query($sql,$binds);
	}  
	function current_timestamp()  {
		$sql ="SELECT CURRENT_TIMESTAMP fecha_hora";
 		return $this->db->query($sql);
	}
	
	//bandeja mejorada filtra y pagina
 function pageContactoLlamadas($conta_id){
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start=$pagenum*$pagesize;
       
	        $sql ="SELECT SQL_CALC_FOUND_ROWS @rownum:=@rownum+1 AS rownum, llamadas.*,
	        campanas.nombre as campana,
	        concat(empleados.apellidos,' ',empleados.nombres) as gestor,
	        (SUBTIME(DATE_FORMAT(llamadas.fin,'%T'),DATE_FORMAT(llamadas.inicio,'%T'))) as duracion 
	        FROM ((SELECT @rownum:=0) r, llamadas, campanas, empleados)
	        WHERE llamadas.campana_id=campanas.id
	        and llamadas.empleado_id=empleados.id
	        and llamadas.estado='AC'
	        and llamadas.contacto_id = ".$conta_id."";
			/*
			$sql ="SELECT SQL_CALC_FOUND_ROWS *
	        FROM (llamadas, campanas)
	        WHERE llamadas.campana_id=campanas.id
	        and llamadas.estado='AC'
	        and llamadas.contacto_id = ".$conta_id."";*/

    // filter data.
	if (isset($_GET['filterscount']))
	{
		$filterscount = $_GET['filterscount'];
		
		if ($filterscount > 0)
		{
			$where = " AND (";
			$tmpdatafield = "";
			$tmpfilteroperator = "";
			for ($i=0; $i < $filterscount; $i++)
		    {
				// get the filter's value.
				$filtervalue = $_GET["filtervalue" . $i];
				// get the filter's condition.
				$filtercondition = $_GET["filtercondition" . $i];
				// get the filter's column.
				$filterdatafield = $_GET["filterdatafield" . $i];
				$filterdatafield='co.'.$filterdatafield;
				// get the filter's operator.
				$filteroperator = $_GET["filteroperator" . $i];
				
				if ($tmpdatafield == "")
				{
					$tmpdatafield = $filterdatafield;			
				}
				else if ($tmpdatafield <> $filterdatafield)
				{
					$where .= ")AND(";
				}
				else if ($tmpdatafield == $filterdatafield)
				{
					if ($tmpfilteroperator == 0)
					{
						$where .= " AND ";
					}
					else $where .= " OR ";	
				}
				
				// build the "WHERE" clause depending on the filter's condition, value and datafield.
				switch($filtercondition)
				{
					case "CONTAINS":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
						break;
					case "DOES_NOT_CONTAIN":
						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
						break;
					case "EQUAL":
						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
						break;
					case "NOT_EQUAL":
						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
						break;
					case "GREATER_THAN":
						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
						break;
					case "LESS_THAN":
						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
						break;
					case "GREATER_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
						break;
					case "LESS_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
						break;
					case "STARTS_WITH":
						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;
					case "ENDS_WITH":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
						break;
				}
								
				if ($i == $filterscount - 1)
				{
					$where .= ")";
				}
				
				$tmpfilteroperator = $filteroperator;
				$tmpdatafield = $filterdatafield;			
			}
			
			
			
			
			// build the query.
			$sql = $sql . $where;		
		}

	}
    //concatena filtra de ser el caso y pagina
	$sql=$sql." limit ".$start.",".$pagesize.";";
    //$query=$this->db->query($sql);
	//return $query;
	
	$query=$this->db->query($sql);
	$results=$query->result_array();
	$total=$this->found_rows();	
	
	$data[] = array(
	          'TotalRows' => $total,
		      'Rows' => $results
		    );
	return $data;
	
	}

}