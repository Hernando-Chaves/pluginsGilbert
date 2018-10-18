(function( $ ) {
	'use strict';

     var precargador = $('.bc_preloader'),
     urlEdit         = '?page=bc_data&action=edit&id=',
     marcoImg        = $('.marcoImg img'),
     selectImgVal    = $('#selectImgVal'),
     idTabla         = $('#idTabla').val(),
     nombres         = $('#nombres'),
     correo          = $('#correo'),
     apellidos       = $('#apellidos'),
     tituloModal     = $('#formData h5'),
     marco;


    // HELPERS
    function limpiarEnlace( url )
    {
        var local = /localhost/;

        if(local.test( url) ){

            var url_pathname  = location.pathname,//Recupera el pathname que es = a http://localhost
                    indexPos  = url_pathname.indexOf('wp-admin'),//cuenta los caracteres hasta wp-admin
                     url_pos  = url_pathname.substr(0,indexPos),//substrae lo que hay desde cero a indexPos
                  url_delete  = location.protocol + '//' + location.host + url_pos;//selecciona todo hasta el slash / antes de wp-admin


                  return url_pos + url.replace(url_delete,'');
        } else {
            var url_real = location.protocol + '//' + location.hostname;
            return url.replace(url_real,'');
        }
    }
    // VALIDA SI HAY CAMPOS VACIOS EN EL FORMULARIO
    function validarCamposVacios( selector )
    {
        var inputs = $(selector),
            result = false;

            $.each(inputs,function(k,v)
            {
                var input = $(v),
                inputVal  = input.val();


                if(inputVal == '' && input.attr('type') != 'file')
                {
                    
                    if(!input.hasClass('invalid'))
                    {
                        input.addClass('invalid');
                        $(this).siblings('#requerido').removeClass('hide');
                    }

                    // result = true;

                } else {

                    if(!$(this).siblings('#requerido').hasClass('hide'))
                    {
                        $(this).siblings('#requerido').addClass('hide');
                    }
                }

            });

            if(result)
            {
                return true;
            } else {

                return false;
            }
    }
    // VALIDAR CORREO
    function validarCorreo( correo )
    {
        var er = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return  er.test( correo );
    }
    function addUserItem(id,nombres,apellidos,correo,media)
    {
        var output = "<tr data-user='"+id+"'>\
                <td>\
                    <img class='bc-media' src='"+media+"' alt='"+nombres+apellidos+"'>\
                </td>\
                <td> "+nombres+" </td>\
                <td> "+apellidos+" </td>\
                <td> "+correo+" </td>\
                <td>\
                    <button data-edit='"+id+"' class='btn-floating waves-ligh btn'>\
                        <i class='material-icons'>edit</i>\
                    </button>\
                    <button data-remove='"+id+" ' class='btn-floating waves-ligh btn red'>\
                        <i class='material-icons'>delete</i>\
                    </button>\
                </td>\
            </tr>\
        ";
        $('table tbody').append(output);

    }

    // VENTANA MODAL
    $('.modal').modal();

    $('.boton-modal').on('click',function(e){
        e.preventDefault();
        var field = $('#requerido').val();

        $('#add_bc_table').modal('open');

    });
	// CREAR TABLA
    $('#crear-tabla').on('click',function(e){
        e.preventDefault();

        var name = $('#nombre-tabla'),
        val_name = name.val();

        if(val_name != "")
        {
            precargador.css('display','flex');
            // ENVIO AJAX
            $.ajax({
                url     : bcdata.url,
                type    : 'POST',
                dataType: 'json',
                data    : {
                    action : 'bc_crud_table',
                    nonce  : bcdata.seguridad,
                    nombre : val_name,
                    tipo   : 'add'
                },success:function(data){
                    if(data.result)
                    {
                        urlEdit += data.insert_id;
                            // location.href = urlEdit;
                        setTimeout(function(){
                            location.href = urlEdit;
                        },1300);

                    } 
                },error: function(d,x,v){
                    console.log(d);
                    console.log(x);
                    console.log(v);
                }
            });

        } else {

            if(!name.hasClass('invalid'))
            {
                precargador.css('display','none');
                name.addClass('invalid');
                $('#requerido').removeClass('hide');
            }
        }
    });

    // CREA INTERACCIÓN CON EL BOTÓN EDITAR
    $(document).on('click','[data-bc-edit-id]',function(){
        var id = $(this).attr('data-bc-edit-id');
        location.href = urlEdit + id;
    });
    
    // CREA INTERACCIÓN CON EL BOTÓN BORRAR
    $(document).on('click','[data-bc-remove-id]',function(){
        var id = $(this).attr('data-bc-remove-id');
        swal({
            title  : 'Estas seguro de borrar este elemento?',
            text   : "Esta acción no tiene vuelta atras",
            type   : "warning",
            showCancelButton     : true,
            confirmButtonColor   : '#3085d6',
            cancelButtonColor    : "#d33",
            confirmButtonText    : "Si, borrarlo",
            closeOnConfirm       : false,
            showLoaderOnConfirm  : true
        },function(isConfirm){
            if(isConfirm)
            {
                setTimeout(function(){
                    swal({
                        title   : "Borrado",
                        text    : "Ha sido borrado",
                        type    : "success"
                    });
                },3300);
            }
        })
    });

    // MODAL EDITAR
    $('.add-item').on('click',function(){

        $('#formData label').removeClass('active');
        $('#formData input').val('');
        $('.marcoImg img').attr('src','');
        tituloModal.text('Agregar Usuario');
        $('#actualizar').css('display','none');
        $('#agregar').css('display','initial');
        $('#addUpdate').modal('open');

    });

    $('#selectImg').on('click',function(e){

        e.preventDefault();

        if(marco)
        {
           marco.open();
           return;
        }

        var marco = wp.media({
            frame   : 'select',
            title   : 'Seleccionar la imagen para el usuario',
            button  : {
                text: 'Usar esta imágen'
            },
            multiple: false,
            library : {
                type : 'image'
            }

        });

        marco.on('select',function(){

            var imagen  = marco.state().get('selection').first().toJSON(),
            urlLimpia   = limpiarEnlace(imagen.url);

            selectImgVal.val( urlLimpia);
            marcoImg.attr('src',imagen.url);

        });

        marco.open();

    });

    // AGREGA USUARIO 
    $('#agregar').on('click',function(){

        var
            val_correo    = correo.val(),
            val_nombres   = nombres.val(),
            val_apellidos = apellidos.val(),
            img_val       = selectImgVal.val();

            if(validarCamposVacios('#formData input'))
            {
                console.log('hay que validar');
            } else if(!validarCorreo(val_correo))
            {
                $('#formData input').removeClass('invalid');
                $('#formData input').addClass('valid');
                if(!correo.hasClass('invalid'))
                {
                    correo.addClass('invalid');
                    correo.siblings('#requerido').removeClass('hide').text('Debes ingresar un correo valido');
                }
                
            } else {
                $('#formData input').removeClass('invalid');
                $('#formData input').addClass('valid');
                precargador.css('display','flex');

                $.ajax({
                    url     : bcdata.url,
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        action    : 'bc_crud_json',
                        nonce     : bcdata.seguridad,
                        tipo      : 'add',
                        idTabla   : idTabla,
                        nombres   : val_nombres,
                        apellidos : val_apellidos,
                        correo    : val_correo,
                        media     : img_val
                    },success:function(data){
                        console.log(data);
                        if(data.result)
                        {
                           
                           precargador.css('display','none');
                           swal({
                                title  : 'Agregado',
                                text   : 'El usuario ' + val_nombres + ' ha sido agregado correctamnete',
                                type   : 'success',
                                timer  : 2000
                           });

                           setTimeout(function(){
                              $('#addUpdate').modal('close');
                              addUserItem(data.insert_id,val_nombres,val_apellidos,val_correo,img_val);
                           },1800);



                        } else {
                            
                           precargador.css('display','none');

                           swal({
                                title  : 'Error',
                                text   : 'Hubo un error al guardar',
                                type   : 'error',
                                timer  : 2000
                           });

                        }
                    },error: function(d,x,v){
                        console.log(d);
                        console.log(x);
                        console.log(v);
                    }
                });
            }

    });
    
    // BOTON EDITAR
    $(document).on('click','[data-edit]', function(){

       tituloModal.text('Editar Usuario');
       $('#actualizar').css('display','initial');
       $('#agregar').css('display','none');
       $('#addUpdate').modal('open');

       var 
           $this      = $(this),
           id         = $this.attr('data-edit'),
           tr         = $this.parent().parent(),
           tdImg      = tr.find($('td:nth-child(1) img')),
           tdNombre   = tr.find($('td:nth-child(2')),
           tdApellido = tr.find($('td:nth-child(3)')),
           tdCorreo   = tr.find($('td:nth-child(4)')),
           src        = tdImg.attr('src');

       $('#formData label').addClass('active');

       selectImgVal.val(src);
       marcoImg.attr('src', src);
       nombres.val(tdNombre.text());
       apellidos.val(tdApellido.text());
       correo.val(tdCorreo.text());
       $('#actualizar').attr('data-id',id);

    });

    $(document).on('click','#actualizar',function(){

        var 
            $this         = $(this),
            id            = $this.attr('data-id'),
            tr            = $('tr[data-user="'+id+'"]'),
            tdImg         = tr.find($('td:nth-child(1) img')),
            tdNombre      = tr.find($('td:nth-child(2')),
            tdApellido    = tr.find($('td:nth-child(3)')),
            tdCorreo      = tr.find($('td:nth-child(4)')),
            val_correo    = correo.val(),
            val_nombres   = nombres.val(),
            val_apellidos = apellidos.val(),
            img_val       = selectImgVal.val();


        if(validarCamposVacios('#formData input'))
        {
            console.log('hay que validar');
        } else if(!validarCorreo(val_correo))
        {
            $('#formData input').removeClass('invalid');
            $('#formData input').addClass('valid');
            if(!correo.hasClass('invalid'))
            {
                correo.addClass('invalid');
                correo.siblings('#requerido').removeClass('hide').text('Debes ingresar un correo valido');
            }
            
        } else {
            $('#formData input').removeClass('invalid');
            $('#formData input').addClass('valid');
            precargador.css('display','flex');

            $.ajax({
                url     : bcdata.url,
                type    : 'POST',
                dataType: 'json',
                data    : {
                    action    : 'bc_crud_json',
                    nonce     : bcdata.seguridad,
                    tipo      : 'update',
                    idTabla   : idTabla,
                    idUser    : id,
                    nombres   : val_nombres,
                    apellidos : val_apellidos,
                    correo    : val_correo,
                    media     : img_val
                },success:function(data){
                    console.log(data);
                    if(data.result)
                    {                       
                       precargador.css('display','none');
                       swal({
                            title  : 'Actualizado',
                            text   : 'El usuario ' + val_nombres + ' ha sido actualizado correctamnete',
                            type   : 'success',
                            timer  : 1500
                       });

                       location.reload();
                       setTimeout(function(){
                          $('#addUpdate').modal('close');
                          tdImg.attr('src',img_val);
                          tdNombre.text(val_nombres);
                          tdApellido.text(val_apellidos);
                          tdCorreo.text(val_correo);
                       },1800);
                        tr.addClass('bganimado');

                       setTimeout(function(){
                        tr.removeClass('bganimado');
                       },1300);

                    } else {
                        
                       precargador.css('display','none');

                       swal({
                            title  : 'Error',
                            text   : 'Hubo un error al actualizar',
                            type   : 'error',
                            timer  : 2000
                       });

                    }
                },error: function(d,x,v){
                    console.log(d);
                    console.log(x);
                    console.log(v);
                }
            });
        }


    });
    // METODO ELIMINAR
    $(document).on('click','[data-remove]',function(){
        var 
            $this    = $(this),
            id       = $this.attr('data-remove'),
            // tr       = $('tr[data-user ="'+id+'"]'),
            tr       = $this.parent().parent(),
            tdNombre = tr.find($('td:nth-child(2')).text();

            swal({
                title               : 'Estas seguro de querer eliminar a "'+tdNombre+'" ?',
                text                : 'Esta acción no se puede deshacer',
                type                : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#dd6b55',
                confirmButtonText   : 'Si, borrarlo',
                closeOnConfirm      : false,
                showLoaderOnConfirm : true,
                html                : true
            },function(isConfirm){
                if(isConfirm)
                {

                    $.ajax({
                        url     : bcdata.url,
                        type    : 'POST',
                        dataType: 'json',
                        data    : {
                            action    : 'bc_crud_json',
                            nonce     : bcdata.seguridad,
                            tipo      : 'delete',
                            idTabla   : idTabla,
                            idUser    : id
                        },success:function(data){
                            console.log(data);
                            if(data.result)
                            {                       
                               precargador.css('display','none');

                               setTimeout(function(){

                                   swal({
                                       title  : 'Borrado',
                                       text   : 'El usuario'+ tdNombre +' ha sido eliminado',
                                       type   : 'success',
                                       timer  : 1500
                                   }); 

                                   tr.css({
                                     "background" : "red",
                                     "color"      : "white"
                                   }).fadeOut(600);

                                   setTimeout(function(){
                                     tr.remove();
                                   },1000);

                               },1500);
                               
                            } else {
                                
                               precargador.css('display','none');

                               swal({
                                    title  : 'Error',
                                    text   : 'Hubo un error al eliminar',
                                    type   : 'error',
                                    timer  : 2000
                               });

                            }
                        },error: function(d,x,v){
                            console.log(d);
                            console.log(x);
                            console.log(v);
                        }
                    });

                    
                } else {

                }
            });
            
    });

})( jQuery );