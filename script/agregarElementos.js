$(document).ready(function() {
        var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd').click(function() {
            if (iCnt <= 19) {

                iCnt = iCnt + 1;

                // Añadir caja de texto.

                //$(container).append('<div id=tb' +iCnt+' class="col-6"><div class="row"><h6>Fecha de&nbsp;&nbsp; </h6><select name="tipoAcred'+iCnt+'"><option>acreditación</option><option>reacreditación</option></select></div><div class="row">Desde&nbsp;&nbsp; <input type="date" id="aprobacion+'+iCnt+'"name="aprobacion+'+iCnt+'" required> Hasta&nbsp;&nbsp; <input type="date" id="hasta+'+iCnt+'"name="hasta+'+iCnt+'" required></div><div class="row"><label for="detalle-'+iCnt+'">Detalle</label><input type="text" size="100" class="form-control" name="detalle-'+iCnt+'"><br></div></div><br><br>');
                $(container).append('<div id=tb' +iCnt+' class="form-group"><br><div class="row"><h6>'+iCnt+'. Fecha de&nbsp;&nbsp; </h6><select  name="tipoAcred'+iCnt+'"><option>acreditación</option><option>reacreditación</option></select></div><div class="row"><div class="col-4"><label for="aprobacion+'+iCnt+'">Desde</label> <input type="date" id="aprobacion+'+iCnt+'" name="aprobacion+'+iCnt+'" required></div><div class="col-4"><label for="hasta+'+iCnt+'">Hasta </label><input type="date" id="hasta+'+iCnt+'" name="hasta+'+iCnt+'" required></div></div><div class="row"><label for="detalle-'+iCnt+'">Detalle</label><input type="text" class="form-control" name="detalle-'+iCnt+'"><br><br></div></div>');

                if (iCnt == 1) {

 var divSubmit = $(document.createElement('div'));
                    //$(divSubmit).append('');

                }

 $('#acreditacion').after(container, divSubmit);
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite

                $(container).append('<label>Limite Alcanzado</label>');
                $('#btAdd').attr('class', 'bt-disable');
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // Elimina un elemento por click
            if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }

            if (iCnt == 0) { $(container).empty();

                $(container).remove();
                $('#btSubmit').remove();
                $('#btAdd').removeAttr('disabled');
                $('#btAdd').attr('class', 'bt')

            }
        });

        $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor

            $(container).empty();
            $(container).remove();
            $('#btSubmit').remove(); iCnt = 0;
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'bt');

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
