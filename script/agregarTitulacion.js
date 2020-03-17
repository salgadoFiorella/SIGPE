$(document).ready(function() {
    var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div'));

    $('#btAddTit').click(function() {
        if (iCnt <= 19) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.form-group

            $(container).append('<div id="divTit'+iCnt+'"><div class="form-group"><label for="tit-'+iCnt+'">Titulación #'+iCnt+'</label><input type="text" placeholder="Titulacion" size="100" class="form-control" id="tit-'+iCnt+'" name="tit-'+iCnt+'"></div><div class="form-group"><label for="tipoTit'+iCnt+'">Tipo</label><select class="form-control" id="tipoTit'+iCnt+'" name="tipoTit'+iCnt+'"><option>No tiene</option><option>Maestría profesional</option><option>Maestría Académica</option></select><br><br></div></div>');
            if (iCnt == 1) {

var divSubmit = $(document.createElement('div'));
                //$(divSubmit).append('');

            }

$('#areaTitulaciones').after(container, divSubmit);
        }
        else {      //se establece un limite para añadir elementos, 20 es el limite

            $(container).append('<label>Limite Alcanzado</label>');
            $('#btAddTit').attr('class', 'bt-disable');
            $('#btAddTit').attr('disabled', 'disabled');

        }
    });

    $('#btRemoveTit').click(function() {   // Elimina un elemento por click
        if (iCnt != 0) { $('#divTit' + iCnt).remove(); iCnt = iCnt - 1; }

        if (iCnt == 0) { $(container).empty();

            $(container).remove();
            $('#btSubmit').remove();
            $('#btAddTit').removeAttr('disabled');
            $('#btAddTit').attr('class', 'btTitul')

        }
    });

    $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor

        $(container).empty();
        $(container).remove();
        $('#btSubmit').remove(); iCnt = 0;
        $('#btAddTit').removeAttr('disabled');
        $('#btAddTit').attr('class', 'btTitul');

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