<?php echo modules::run('login/menu_rol');?>
<!DOCTYPE html>
<html>
    <head>
	    <title></title>
    </head>
    <body> 
    	<?=form_open_multipart(base_url().'mar/upload/upload_file')?>
		<?=form_upload('file')?>
		<?=form_submit('submit', 'Upload')?>
    	<?=form_close()?>
    </body>
</html>

