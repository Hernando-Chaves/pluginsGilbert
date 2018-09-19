(function( $ ) {
	'use strict';

	var precargador = $('.bc_preloader'),
	        urlEdit = '?page=bc_data&action=edit&id=',
           marcoImg = $('.marcoImg img'),
       selectImgVal = $('#selectImgVal'),
              marco;

    // HELPERS
    function limpiarEnlace( url ){
        var local = /localhost/;
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

        if(val_name != ""){
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
                    if(data.result){
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

            if(!name.hasClass('invalid')){
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
     
        $('#addUpdate').modal('open');
    });

    $('#selectImg').on('click',function(e){
        e.preventDefault();

        if(marco ){
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

            var imagen  = marco.state().get('selection').first().toJSON();
            selectImgVal.val( imagen.url);
            marcoImg.attr('src',imagen.url);

        });

        marco.open();

    });
    	

})( jQuery );