

<?php $this->load->view('includes/header_callrequest');
		//$this->carabiner->css('style.css');
		$this->carabiner->js('otwidgets/validadoc.js');
        $this->carabiner->js('js/call_request.js');
	    $this->carabiner->display(); 
 		$this->carabiner->empty_cache('both','yesterday');
?>

<script type="text/javascript">
        
        $(document).ready(function () {
           l=new CallRequest();
           l.init();
          
        });
    </script>
    <!--<div region="north" style="background: url(<?php echo base_url();?>assets/img/heabg.jpg);height:100px;">
		    <div style="background-image:url(<?php echo base_url();?>assets/img/healogo.jpg); height:98px; background-repeat:no-repeat;">&nbsp;</div>
	   </div>-->
  <div id="register" style="font-family: Verdana; font-size: 12px;">
        <div>
            Datos de contacto
        </div>
        <div style="font-family: Verdana; font-size: 12px;">
        	<?php $attributes = array('id' => 'register_form');
        	 echo form_open('login/validar_sesion', $attributes);?>	
            
	<table cellpadding="5">
		
          <tr>
          <td>Cédula:</td>
           <td>
          <?php 
		       $data_input = array('id'=>'identificacion','placeholder'=>'su cedula','name'=>'identificacion','value'=>'');
		       echo form_input($data_input);
		   ?>
		   </td>
         </tr>
         <tr>
          <td>Nombres:</td>
           <td>
          <?php 
		       $data_input = array('id'=>'nombres','placeholder'=>'sus nombres','name'=>'nombres','value'=>'');
		       echo form_input($data_input);
		   ?>
		   </td>
         </tr>
         <tr>
          <td>Apellidos:</td>
           <td>
          <?php 
		       $data_input = array('id'=>'apellidos','placeholder'=>'sus apellidos','name'=>'apellidos','value'=>'');
		       echo form_input($data_input);
		   ?>
		   </td>
         </tr>
         <tr>
          <td>Ciudad:</td>
           <td>
          <?php 
		       $data_input = array('id'=>'ciudad','placeholder'=>'su ciudad','name'=>'ciudad','value'=>'');
		       echo form_input($data_input);
		   ?>
		   </td>
         </tr>	
         <tr>
          <td>Celular:</td>
           <td>
          <?php 
		       $data_input = array('id'=>'celular','placeholder'=>'su celular','name'=>'celular','value'=>'');
		       echo form_input($data_input);
		   ?>
		   </td>
         </tr>	
         <tr>
          <td>Email:</td>
           <td>
            <?php 
		       $data_input = array('id'=>'email','placeholder'=>'su email','name'=>'email','value'=>'');
		       echo form_input($data_input);
		    ?>
		   </td>
         </tr>
       <tr></tr>
		<tr>
			<td></td>
			   <td>
			   		<?php 
				       $data_input = array('type'=>'submit', 'id'=>'submit','name' => 'submit','class'=>'submit','value' => 'True', 'content' => 'Solicitar llamada');
				       echo form_button($data_input);
				    ?> 
  			   </td>
			   
		</tr>
  
  </table>
  </form>
</div>
</div>

 
