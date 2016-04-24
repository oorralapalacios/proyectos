<?php echo modules::run('login/cp');?>
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare the data
            var data = new Array();
            var identificacion =
            [
                "001", "002", "003", "004", "005", "006", "007", "008", "009", "010", "011", "012", "013", "014", "015", "016", "017", "018"
            ];
            var nombres =
            [
                "Fuller", "Davolio", "Burke", "Murphy", "Nagase", "Saavedra", "Ohno", "Devling", "Wilson", "Peterson", "Winkler", "Bein", "Petersen", "Rossi", "Vileid", "Saylor", "Bjorn", "Nodier"
            ];
            var apellidos =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            var direccion =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            var email =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            var sexo =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            var telefono =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            var celular =
            [
                "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar", "movistar"
            ];
            for (var i = 0; i < 100; i++) {
                var row = {};
                row["identificacion"] = identificacion[Math.floor(Math.random() * identificacion.length)];
                row["nombres"] = nombres[Math.floor(Math.random() * nombres.length)];
                row["apellidos"] = apellidos[Math.floor(Math.random() * apellidos.length)];
                row["direccion"] = direccion[Math.floor(Math.random() * direccion.length)];
                row["email"] = email[Math.floor(Math.random() * email.length)];
                row["sexo"] = sexo[Math.floor(Math.random() * sexo.length)];
                row["telefono"] = telefono[Math.floor(Math.random() * telefono.length)];
                row["celular"] = celular[Math.floor(Math.random() * celular.length)];
                data[i] = row;
            }
            var source =
            {
                localdata: data,
                datatype: "array"
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            $("#jqxgrid").jqxGrid(
            {
                width : '100%',
                source: dataAdapter,
                columns: [
                  { text: 'Identificacion', datafield: 'identificacion', width: '8%' },
                  { text: 'Nombres', datafield: 'nombres', width: '15%' },
                  { text: 'Apellidos', datafield: 'apellidos', width: '15%' },
                  { text: 'Direccion', datafield: 'direccion', width: '25%' },
                  { text: 'Email', datafield: 'email', width: '13%' },
                  { text: 'Sexo', datafield: 'sexo', width: '8%' },
                  { text: 'Telefono', datafield: 'telefono', width: '8%' },
                  { text: 'Celular', datafield: 'celular', width: '8%' }
                ]
                
            });
            
            // Create Push Button.
            $("#btnConsultar").jqxButton({ width: '85px', height: '19px'});
            $("#btnNuevo").jqxButton({ width: '85px', height: '19px'});
            $("#btnEditar").jqxButton({ width: '85px', height: '19px'});
            $("#btnBorrar").jqxButton({ width: '85px', height: '19px'});
            
            
            

        });
    </script>
<div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/mar.png">&nbsp;&nbsp;Marketing: Empleados</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
</div>
<div id="main">
    <div class="divbtn">
        
        <div id='btnConsultar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icover.png' />&nbsp;Consultar
        </div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnNuevo' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/iconue.png' />&nbsp;Nuevo
        </div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnEditar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icoedi.png' />&nbsp;Editar
         </div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnBorrar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icobor.png' />&nbsp;Borrar
        </div>
        
    </div>
    
    
        
    <div id="jqxgrid"></div>
   
</div>



