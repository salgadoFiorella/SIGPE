$(document).ready(function() {
    var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div'));

    $('#btAddS').click(function() {
        if (iCnt <= 19) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.

            $(container).append('<div id=salid' +iCnt+'><label for"sal-'+iCnt+'">Salida Lateral #'+iCnt+'</label><input type="text" size="100" class="form-control" id="sal-'+iCnt+'" name="sal+'+iCnt+'" required><br><label for="com-'+iCnt+'">Comentarios</label><textarea size="100" class="form-control" name="com-'+iCnt+'"></textarea><br><br></div>');
           
            if (iCnt == 1) {

var divSubmit = $(document.createElement('div'));

//$(divSubmit).append('<hr><br>');
                //$(divSubmit).append('');

            }

$('#salidasLat').after(container, divSubmit);
        }
        else {      //se establece un limite para añadir elementos, 20 es el limite

            $(container).append('<label>Limite Alcanzado</label>');
            $('#btAddS').attr('class', 'bt-disable');
            $('#btAddS').attr('disabled', 'disabled');

        }
    });

    $('#btRemoveS').click(function() {   // Elimina un elemento por click
        if (iCnt != 0) { $('#salid' + iCnt).remove(); iCnt = iCnt - 1; }

        if (iCnt == 0) { $(container).empty();

            $(container).remove();
            $('#btSubmitS').remove();
            $('#btAddS').removeAttr('disabled');
            $('#btAddS').attr('class', 'bt')

        }
    });

    $('#btRemoveAllS').click(function() {    // Elimina todos los elementos del contenedor

        $(container).empty();
        $(container).remove();
        $('#btSubmitS').remove(); iCnt = 0;
        $('#btAddS').removeAttr('disabled');
        $('#btAddS').attr('class', 'bt');

    });
});

// Obtiene los valores de los textbox al dar click en el boton "Enviar"
var divValue, values = '';

function GetTextValue() {

    $(divValue).empty();
    $(divValue).remove(); values = '';

    $('.input').each(function() {
        divValue = $(document.createElement('div')).css({
            padding:'5px', width:'200px'
        });
        values += this.value + '<br />'
    });

    $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
    $('body').append(divValue);

}
