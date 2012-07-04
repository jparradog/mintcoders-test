$(function () {
    var activo='';
    /**
    *Evento del menu
    **/
    $('#navegacion a').on('click', function(event) {
        event.preventDefault();
        var href=$(this).attr('href');
        activo=$(this).attr('data-name');
        //alert(href);
        var modal=$(this).attr('data-modal');
        $('.escondido').hide();
        $(href).show();
        if (modal=='true') {
            $(href+'_modal').modal('show');
        };
        CargarEventos();
    });
    /**
    *Fin-Evento del menu
    **/
    /**
    *Eventos Crear
    **/
    function CargarEventos () {
        $('#'+activo+'-guardar').on('click',function(event){
            event.preventDefault();
            if(ValidarForm('#form'+activo)){
                //alert("valido");
                var datos=RecojeDatos('#form'+activo);
                $.ajax({
                    url: "php/ajax.php",
                    async:true,
                    data: "opcion=1&"+datos,
                    beforeSend: function(objeto){
                        //alert("Adiós, me voy a ejecutar");
                    },
                    complete: function(objeto, exito){
                        //alert("Me acabo de completar")
                        if(exito=="success"){
                            //alert("Y con éxito");
                        }
                    },
                    contentType: "application/x-www-form-urlencoded",
                    dataType: "json",//html
                    error: function(objeto, quepaso, otroobj){
                        alert("Estas viendo esto por que fallé");
                        alert("Pasó lo siguiente: "+quepaso);
                    },
                    global: true,
                    ifModified: false,
                    processData:true,
                    success: function(datos){
                        //alert(datos.message);
                        if (datos.message=='1') {
                            //alert('form'+activo+'-alerta');
                            alerta('form'+activo+'-alerta', "Error:", "Ya existe un usuario con el mismo nombre", '1');
                        } else if (datos.message=='2'){
                            alerta('form'+activo+'-alerta', "Inf:", "Se creo correctamente el usuario", '2');
                        } else if (datos.message=='3'){
                            alerta('form'+activo+'-alerta', "Error:", "No se ingreso el usuario", '1');
                        };
                    },
                    timeout: 3000,
                    type: "POST"
                });
            }
        });
    }
    /**
    *
    **/
    function ValidarForm(miForm) {
        // recorremos todos los campos que tiene el formulario
        var valido=true;
        $(".error").removeClass('error');
        $(".help-inline").remove();
        $(miForm).find(':input').each(function() {
            var mensaje="";
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            if (type == "text" || type == "password" || tag == "textarea" || type == "email")
                {
                    var value=this.value;
                    if(this.required){
                        if (value.length<$(this).attr('minlength') || value.length>$(this).attr('maxlength')) {
                            mensaje ="No esta dentro del rango";
                            valido=false;
                            MostrarError(this, mensaje);
                        };
                        var ok=new RegExp(this.pattern);//crear expresion regular
                        if (ok.test(value)==false) {
                            mensaje ="No cumple con las condiciones";
                            valido=false;
                            MostrarError(this, mensaje);
                        };
                    }
                }
            else if (type == "checkbox" || type == "radio")
                {
                    if($(this).checked == false){
                        mensaje ="No has seleccionado algo";
                        valido=false;
                        MostrarError(this, mensaje);
                    };
                }
            else if (tag == "select")
                {
                    //alert("entro select");
                    if($(this).find(':selected').val()==0)
                    {
                        mensaje ="No has seleccionado algo";
                        valido=false;
                        MostrarError(this, mensaje);
                    }
                }
        });
        return valido;
    }
    function RecojeDatos(miForm) {
        // recorremos todos los campos que tiene el formulario
        var datos='';
        var variable=true;
        $(miForm).find(':input').each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            var name=this.name;
            if (variable) {
                variable=false;
            }else{
                datos+="&"
            }
            if (type == "text" || type == "password" || tag == "textarea" || type == "email")
                {
                    var value=this.value;
                    datos+=name+"="+value;
                }
            else if (type == "checkbox" || type == "radio")
                {
                    /*Falta*/
                }
            else if (tag == "select")
                {
                    value=$(this).find(':selected').val();
                    datos+=name+"="+value;
                }
        });
        return datos;
    }
    function MostrarError (campo, msg) {
        // <span class="help-inline">Please correct the error</span>  error
        $(campo).parents(':eq(2)').addClass('error');
        $(campo).parents(':eq(1)').prepend('<span class="help-inline">* '+msg+'</span>');
    }
    function alerta(id, titulo, contenido, tipo){//tipo = 1:alert-error,2:alert-success,3:alert-info
        var select=$("#"+id);
        var clases="alert ";
        if(tipo=='1'){ clases+="alert-error";}
        else if(tipo=='2'){clases+="alert-success";}
        else if(tipo=='3'){clases+="alert-info";}
        else { return false;}
        select.removeAttr('class').addClass(clases);
        $("#"+id+" > h4").empty().prepend(titulo);
        $("#"+id+" > p").empty().prepend(contenido);
        select.show();
        return true;
    };
    $('.toltip').tooltip();
});

