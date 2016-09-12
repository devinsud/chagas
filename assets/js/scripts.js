function agregaBarrioCompleto(id){
    $( "#cart ol" ).find( ".placeholder" ).remove();
    $('#listado_viviendas'+id+' li').each(function(){
        existe=$('#'+$(this).attr('rel')).text();
        if(existe==''){
            $( "<li id='"+ $(this).attr('rel') +"'></li>" ).html( $(this).text()+' <a href="#" stylr="color:#f00;" onclick="elimina('+$(this).attr('rel') +')"><img src="../../../assets/img/hr.gif" alt=""></a>' ).appendTo( $( "#cart ol" ) );
            texto = $('#caja').val() + '-' + $(this).attr('rel');
            $('#caja').val(texto);
            
        }
    })
}


function chequeaTipo(){
    valor = $('#ciaSel').val();
    //alert(valor);
    if(valor=='0'){
        $('#selTipo').val(2);
    }
};

function muestraPos(pos){
        $('#'+pos).toggle('slow');
}

function checkAdmin(){
    valor = $('#selTipo').val();
    if(valor==1 || valor==10){
        $('#trSelCia').css('visibility','hidden');
        $('#passBlock').css('visibility','visible');
    }else if(valor==3){
        $('#trSelCia').css('visibility','visible');
        $('#passBlock').css('visibility','hidden');
    }else{
        $('#trSelCia').css('visibility','hidden');
        $('#passBlock').css('visibility','hidden');
    }
}



function eliminaBarrio(id){
   texto = $('#cajaBarrios').val().replace('-'+id, '');
   $('#cajaBarrios').val(texto);
   $('#'+id).remove();
}

/*$('#calc_id').on('click', function(){
                barrio = parseInt($("#barrio").val());
                manzana = parseInt($("#manzana").val());
                vivienda = parseInt($("#vivienda").val());
                if(barrio>0 && manzana >0 && vivienda >0){
                    codigo = (barrio * 1000000)+(manzana*1000)+vivienda;
                    $('#idvivienda').val(codigo);
                }else{
                    alert( 'Faltan datos para calcular');
                }
            })*/