<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <title>Personal Communications|Panel de Control</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/icopc.ico" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_panel.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.base.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.ui-start.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.ui-redmond.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.ui-le-frog.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.office.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.darkblue.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.energyblue.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.ui-sunny.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.ui-lightness.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.orange-custom.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqwidgets/styles/jqx.arctic.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqxalerts/styles/jqx.alert.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/jqyui/themes/base/jquery.ui.all.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jqyui/themes/redmond/jquery.ui.all.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fullcalendar/fullcalendar.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/jqeasyui/themes/default/easyui.css">
    <!--<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-1.10.2.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqeasyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxvalidator.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqxalerts/jqxalert.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatetimeinput.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.selection.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.grouping.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>
 
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownbutton.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxnumberinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttongroup.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcalendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.accordion.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lang-all.js"></script>
    
    
     
     
 </head>
<body>
	<script type="text/javascript">
	    var tema= "ui-redmond";
	    var temaMn= "ui-redmond";
       
       
        
    </script>