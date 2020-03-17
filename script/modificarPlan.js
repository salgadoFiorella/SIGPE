function abrirEnfasis(){
    $("#modalEnf").modal('show');
}

function abrirEnfasis(){
    $("#modalFechas").modal('show');
}

function ponerCampus(campus){

    campus.forEach(e => {
            document.getElementById(e).checked = true;
          });
  }
  
  function ponerModalidad(mod){
    mod.forEach(e => {
            document.getElementById(e).selected = true;
          });
  }

function fcs(codigo,unidad){
    $.post("script/select2.php", { codigo: codigo,unidad:unidad }, function(data){
        $("#unidadAcademica").html(data);
    });

}