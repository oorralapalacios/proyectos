function CallRequest () {
 	 //var tema= "ui-start";
 	 //var tema= "energyblue";
     var tema= "ui-redmond";
 	 this.init=function(){
 	 	   validador();
   	       createElements();
           
   	
   };
   
   createElements=function(){
   	        // Create jqxExpander.
            $("#register").jqxExpander({ theme:tema,  toggleMode: 'none', width: '450px', showArrow: false });
            // Create jqxInput.
            $("#identificacion").jqxInput({  width: '300px', height: '20px' });
            $("#nombres").jqxInput({  width: '300px', height: '20px' });
            $("#apellidos").jqxInput({  width: '300px', height: '20px' });
            $("#ciudad").jqxInput({  width: '300px', height: '20px' });
            $("#celular").jqxInput({  width: '300px', height: '20px' });
            $("#email").jqxInput({  width: '300px', height: '20px' });
            $("#submit").jqxButton({ theme: tema });
   };
   
   validador= function (){
          //codigo para validacion de entradas
	        $('#register_form').jqxValidator({
	            hintType: 'label',
	            animationDuration: 0,
	            rules: [
	                    { input: '#identificacion', message: 'Identificación debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					    { input: "#nombres", message: "Nombre es requerido!", action: 'keyup, blur', rule: 'required' },
                        { input: "#apellidos", message: "Apellidos es requerido!", action: 'keyup, blur', rule: 'required' },
                        { input: '#ciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: 'required' },
					    { input: '#celular', message: 'Celular es requerido!', action: 'keyup, blur', rule: 'required' },
                        { input: '#email', message: 'email es requerido!', action: 'keyup, blur', rule: 'required' },
	                    { input: '#email', message: 'e-mail invalido!', action: 'keyup', rule: 'email' }
	            ],  hintType: "label"
	        });	
          }; 
          
   validaDatos= function (){
           var esValido=true;
           if (!validaDoc($("#identificacion").val())){
          	 jqxAlert.alert('Identificación invalida!');
          	 esValido=false;
           }
           if (!validaTelefonoFijo($("#telefono").val())){
          	 jqxAlert.alert('Teléfono fijo invalido!');
          	 esValido=false;
           }
           if (!validaTelefonoMovil($("#celular").val())){
          	 jqxAlert.alert('Teléfono móvil invalido!');
          	 esValido=false;
           }
            
          	return esValido;
         };
         
   save=function (){
					   
			    var validationResult = function (isValid) {
                if (isValid) {
                    var empleado = {  
                        accion: oper,
                        id: $("#id").val(),
                        //rol_id: $("#rol_id").val(),
						usuario_id: $("#usuario_id").val(),
						//rol_usuario_id: $("#rol_usuario_id").val(),
						//departamento_id: $("#departamento_id").val(),
						identificacion: $("#identificacion").val(),
						nombres: $("#nombre").val(),
						apellidos: $("#apellido").val(),
						genero: $("#genero").val(),
						direccion: $("#direccion").val(),
						telefono: $("#telefono").val(),
						celular: $("#celular").val(),
						email: $("#email").val(),
						correo_institucional: $("#correo_institucional").val(),
                        estado: $("#estado").val()
                    };	
                    /*alert(empleado.accion+' '+empleado.id+' '+empleado.rol_id+' '+empleado.usuario_id+' '+empleado.departamento_id
                    +' '+empleado.identificacion+' '+empleado.nombres+' '+empleado.apellidos+' '+empleado.genero+' '+empleado.direccion
                    +' '+empleado.telefono+' '+empleado.celular+' '+empleado.email+' '+empleado.correo_institucional);	
                 	*/
                 	if (ValidaDatos()){
                 	
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: empleado,
                        success: function (data) {
                        	//alert(data);
                        	var mensaje=data; 
							if(data=true){
                                
                                if (mensaje=='exists'){
                                	alert("Dato ya existe.");
                                }else{
                                    $("#jqxgrid").jqxGrid('updatebounddata');
                                    $("#eventWindow").jqxWindow('hide');
                                    alert("El dato se grabó correctamente.");
                                }
                                
                            }else{
                                alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                            //alert(msg.responseText);
                        }
                    });
                    }
		             else{
		               	//jqxAlert.alert('Cédula invalida!');
		            }	
                };
            };
            $('#eventWindow').jqxValidator('validate', validationResult);    	
     	
                
		    };
 }