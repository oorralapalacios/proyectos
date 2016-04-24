<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxnumberinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.aggregates.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownbutton.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcolorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/parametricas.js"></script>

<script type="text/javascript">
     $(document).ready(function () {
    	
    	
    	p=new Parametricas();
        p.ajaxurl = "<?php echo site_url("man/parametros/ajax"); ?>";
        p.init();
    	
    			
	});
</script>


	
<div class="main">
	<div class='titnavbg'>
     <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Mantenimiento: <a class="subtitulo"></a></div>
    </div>
    <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div>
    <div style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
    <div style="visibility: hidden; display:none;" id="jqxWidget">
        <div id="eventWindow">
            <div><a class="subtitulo"></a></div>
            <div>
                <div>
                    <form id="fmpr">
                        <table width="100%">
                            <tr>
                                <td align="right">Id:</td>
                                <td align="left" colspan="2"><input id="id"/></td>
                            </tr>
                            <tr>
                                <td align="right">Codigo:</td>
                                <td align="left" colspan="2"><input id="codigo" /></td>
                            </tr>
                            
                           	<tr>
                                <td align="right">Descripcion:</td>
                                <td align="left" colspan="2"><input id="descripcion" /></td>
                            </tr>
                           
							<tr>
                                <td align="right">Estado:</td>
                                <td align="left" colspan="2"><input id="estado" /></td>
                            </tr>
							
							 <tr>
                                <td align="center"></td>
                                <td style="padding-top: 10px;" align="center"><input style="margin-right: 5px;" type="button" id="btnSave" value="Grabar" /><input id="btnCancel" type="button" value="Cancelar" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
	
	
