$(function() {
        mostrar('A');
});


function mostrar( letra, pagina=1){
  $("#resultado").empty();
        var parametros = {
                "letra" : letra,
                "pagina": pagina

        };
        $.ajax({
                data:  parametros,
                url:   'script/buscarFichaLetra.php',
                type:  'post',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $("#resultado").html(response);
                }
        });
}
