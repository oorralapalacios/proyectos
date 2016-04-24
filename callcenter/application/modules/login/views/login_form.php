<?php $this->load->view('includes/header'); ?>
<div id="login_form">
    <div id="login_logo"><?php echo img('assets/img/logo.png');?></div>
    <?php 
        $attributes = array('id' => 'form_login');
        echo form_open('login/validar_sesion', $attributes);
        $data_input = array('id'=>'username','placeholder'=>'su usuario','name'=>'usuario','value'=>'');
	    echo form_input($data_input);
        $data_pass = array('id'=>'user_password','placeholder'=>'su clave','name'=>'clave','value'=>'');
		echo form_password($data_pass);
		?>
		<!--<label for="captcha"><?php echo $captcha['image']; ?></label>
	<?php 
		  $data_input = array('id'=>'userCaptcha','placeholder'=>'Codigo de seguridad','name'=>'userCaptcha','value'=>'');
		  echo form_input($data_input);
    ?> -->
	<?php 	
	
	echo form_submit('submit', 'Ingresar');
	echo form_close();
    ?>
</div>
<?php $attr = array('target'=>'_blank',);?>
   <div id="login_powered"><p>&copy; Copyright 2014</p></div>
	
<?php $this->load->view('includes/footer'); ?>