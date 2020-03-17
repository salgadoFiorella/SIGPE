$(document).ready(function() {
    var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div'));

    $('#btAddAreaD').click(function() {
        if (iCnt <= 19) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.

            $(container).append('<input type="text" placeholder="Área Disciplinaria" class="form-control" id="areaD-'+iCnt+'" name="areaD-'+iCnt+'">');
            if (iCnt == 1) {

var divSubmit = $(document.createElement('div'));
                //$(divSubmit).append('');

            }

$('#areaDisc').after(container, divSubmit);
        }
        else {      //se establece un limite para añadir elementos, 20 es el limite

            $(container).append('<label>Limite Alcanzado</label>');
            $('#btAddAreaD').attr('class', 'bt-disable');
            $('#btAddAreaD').attr('disabled', 'disabled');

        }
    });

    $('#btRemoveAreaD').click(function() {   // Elimina un elemento por click
        if (iCnt != 0) { $('#areaD-' + iCnt).remove(); iCnt = iCnt - 1; }

        if (iCnt == 0) { $(container).empty();

            $(container).remove();
            $('#btSubmit').remove();
            $('#btAddAreaD').removeAttr('disabled');
            $('#btAddAreaD').attr('class', 'btarea')

        }
    });

    $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor

        $(container).empty();
        $(container).remove();
        $('#btSubmit').remove(); iCnt = 0;
        $('#btAddAreaD').removeAttr('disabled');
        $('#btAddAreaD').attr('class', 'btarea');

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