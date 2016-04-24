<?php
class Categoria extends DataMapper {
    var $table = 'categorias';
    var $extensions = array('json');
	//var $has_many = array('productos');
	var  $has_many  = array ( 
    'productos'  => array( 
        'class'  =>  'productos' , 
        'other_field'  =>  'id' , 
        'join_other_as'  =>  'producto' , 
        'join_self_as'  =>  'categoria' ,
        'join_table' => 'productos'
    ) 
  ); 
		
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	 function include_all_related(){
        foreach($this->has_many as $h){
            $this->include_related($h['class']);
        }
        return $this;
    }
	 
	 
}

/* End of file modelo.php */
/* Location: ./application/modules/categorias/models/categoria.php */