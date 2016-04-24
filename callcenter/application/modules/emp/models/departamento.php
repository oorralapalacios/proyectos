<?php
class Departamento extends DataMapper {
    var $table = 'departamentos';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function lista_padre(){
		$sql="SELECT 0 as id, 'Ninguno' as nombre
              union 
              SELECT id,nombre FROM departamentos;";
	    	  $query=$this->db->query($sql);
			  return $query;
            
	}
	
	function deprol($rolid=null){
		$sql="select * from departamentos where padre_id in (select departamento_id from roles_departamentos where rol_id=?) ;";
			  $binds = array($rolid);
		      $query= $this->db->query($sql,$binds);
			   if ($query->num_rows() > 0)
				{
				   return 1;
				}
			   else {
			   	return 0;
			   }
			  //return $query;
	}
}

