function ponerPermisos(permisos){
    console.log("entro");
    console.log("permisos "+permisos);
    permisos.forEach(e => {
            document.getElementById(e).checked = true;
          });
  }