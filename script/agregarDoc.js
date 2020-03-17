$(document).ready(function() {
    var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div'));

    $('#btAddDoc').click(function() {
        if (iCnt <= 6) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.

            $(container).append('<div id=DocPrinc' +iCnt+'><input type="file" class="form-control" id="principal-'+iCnt+'" name="principal+'+iCnt+'" accept="application/msword,.docx"><br></div>');
           
            if (iCnt == 1) {

var divSubmit = $(document.createElement('div'));

            }

$('#docPrincipal').after(container, divSubmit);
        }
        else {      //se establece un limite para añadir elementos, 20 es el limite

            $(container).append('<label id="limite0">Limite Alcanzado</label>');
            $('#btAddDoc').attr('class', 'bt-disable');
            $('#btAddDoc').attr('disabled', 'disabled');

        }
    });

    $('#btRemoveDoc').click(function() {   // Elimina un elemento por click
        if (iCnt != 0) { $('#DocPrinc' + iCnt).remove(); iCnt = iCnt - 1; }

        if (iCnt == 0) { $(container).empty();

            $(container).remove();
            $('#btSubmitDoc').remove();
            $('#btAddDoc').removeAttr('disabled');
            $('#btAddDoc').attr('class', 'btDoc')

        }
        if (iCnt <=6){
            $('#btSubmitDoc').remove();
            $('#limite0').remove();
            $('#btAddDoc').removeAttr('disabled');
            $('#btAddDoc').attr('class', 'btDoc');
         }
    });

    $('#btRemoveAllDocs').click(function() {    // Elimina todos los elementos del contenedor

        $(container).empty();
        $(container).remove();
        $('#btSubmitDoc').remove(); iCnt = 0;
        $('#btAddDoc').removeAttr('disabled');
        $('#btAddDoc').attr('class', 'btDoc');

    });

    /*==================================================*/
    //OPES
    var iCnt1 = 0;

    // Crear un elemento div añadiendo estilos CSS
        var containerOpes = $(document.createElement('div'));
    
        $('#btAddOpes').click(function() {
            if (iCnt1 <= 6) {
    
                iCnt1 = iCnt1 + 1;
    
                // Añadir caja de texto.
    
                $(containerOpes).append('<div id=DocOpes' +iCnt1+'><input type="file" class="form-control" id="opes-'+iCnt1+'" name="opes+'+iCnt1+'" accept="application/pdf,image/*"><br></div>');
               
                if (iCnt1 == 1) {
    
    var divSubmitOpes = $(document.createElement('div'));
    
                }
    
    $('#espacioopes').after(containerOpes, divSubmitOpes);
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
    
                $(containerOpes).append('<label id="limite1">Limite Alcanzado</label>');
                $('#btAddOpes').attr('class', 'bt-disable');
                $('#btAddOpes').attr('disabled', 'disabled');
    
            }
        });
    
        $('#btRemoveOpes').click(function() {   // Elimina un elemento por click
            if (iCnt1 != 0) { $('#DocOpes' + iCnt1).remove(); iCnt1 = iCnt1 - 1; }
    
            if (iCnt1 == 0) { $(containerOpes).empty();
    
                $(containerOpes).remove();
                $('#btSubmitDoc').remove();
                $('#btAddOpes').removeAttr('disabled');
                $('#btAddOpes').attr('class', 'btOpes')
    
            }
            if (iCnt1 <=6){
                $('#btSubmitDoc').remove();
                $('#limite1').remove();
                $('#btAddOpes').removeAttr('disabled');
                $('#btAddOpes').attr('class', 'btOpes');
             }
        });
    
        $('#btRemoveAllOpes').click(function() {    // Elimina todos los elementos del contenedor
    
            $(containerOpes).empty();
            $(containerOpes).remove();
            $('#btAddOpes').remove(); iCnt1 = 0;
            $('#btAddOpes').removeAttr('disabled');
            $('#btAddOpes').attr('class', 'btOpes');
    
        });
        /*==================================================*/
        //CNR
        var iCnt2 = 0;

     // Crear un elemento div añadiendo estilos CSS
         var containercnr = $(document.createElement('div'));
     
         $('#btAddcnr').click(function() {
             if (iCnt2 <= 6) {
     
                 iCnt2 = iCnt2 + 1;
     
                 // Añadir caja de texto.
     
                 $(containercnr).append('<div id=DocCNR' +iCnt2+'><input type="file" class="form-control" id="cnr-'+iCnt2+'" name="cnr+'+iCnt2+'" accept="application/pdf"><br></div>');
                
                 if (iCnt2 == 1) {
     
     var divSubmitcnr = $(document.createElement('div'));
     
                 }
     
     $('#espaciocnr').after(containercnr, divSubmitcnr);
             }
             else {      //se establece un limite para añadir elementos, 20 es el limite
     
                 $(containercnr).append('<label id="limite2">Limite Alcanzado</label>');
                 $('#btAddcnr').attr('class', 'bt-disable');
                 $('#btAddcnr').attr('disabled', 'disabled');
     
             }
         });
     
         $('#btRemovecnr').click(function() {   // Elimina un elemento por click
             if (iCnt2 != 0) { $('#DocCNR' + iCnt2).remove(); iCnt2 = iCnt2 - 1; }
     
             if (iCnt2 == 0) { $(containercnr).empty();
     
                 $(containercnr).remove();
                 $('#btSubmitDoc').remove();
                 $('#btAddcnr').removeAttr('disabled');
                 $('#btAddcnr').attr('class', 'btcnr')
     
             }
             if (iCnt2 <=6){
                $('#btSubmitDoc').remove();
                $('#limite2').remove();
                $('#btAddcnr').removeAttr('disabled');
                $('#btAddcnr').attr('class', 'btcnr');
             }
         });
     
         $('#btRemoveAllcnr').click(function() {    // Elimina todos los elementos del contenedor
     
             $(containercnr).empty();
             $(containercnr).remove();
             $('#btAddcnr').remove(); iCnt2 = 0;
             $('#btAddcnr').removeAttr('disabled');
             $('#btAddcnr').attr('class', 'btcnr');
     
         });
        /*==================================================*/
         //Acuerdos
         var iCnt3 = 0;

         // Crear un elemento div añadiendo estilos CSS
             var containeracu = $(document.createElement('div'));
         
             $('#btAddacu').click(function() {
                 if (iCnt3 <= 6) {
         
                     iCnt3 = iCnt3 + 1;
         
                     // Añadir caja de texto.
         
                     $(containeracu).append('<div id=DocAcu' +iCnt3+'><input type="file" class="form-control" id="acuerdos-'+iCnt3+'" name="acuerdos+'+iCnt3+'" accept="application/pdf"><br></div>');
                    
                     if (iCnt3 == 1) {
         
         var divSubmitacu = $(document.createElement('div'));
         
                     }
         
         $('#espacioacu').after(containeracu, divSubmitacu);
                 }
                 else {      //se establece un limite para añadir elementos, 20 es el limite
         
                     $(containeracu).append('<label id="limite3">Limite Alcanzado</label>');
                     $('#btAddacu').attr('class', 'bt-disable');
                     $('#btAddacu').attr('disabled', 'disabled');
         
                 }
             });
         
             $('#btRemoveacu').click(function() {   // Elimina un elemento por click
                 if (iCnt3 != 0) { $('#DocAcu' + iCnt3).remove(); iCnt3 = iCnt3 - 1; }
         
                 if (iCnt3 == 0) { $(containeracu).empty();
         
                     $(containeracu).remove();
                     $('#btSubmitDoc').remove();
                     $('#btAddacu').removeAttr('disabled');
                     $('#btAddacu').attr('class', 'btacu')
         
                 }
                 if (iCnt3 <=6){
                    $('#btSubmitDoc').remove();
                    $('#limite3').remove();
                    $('#btAddacu').removeAttr('disabled');
                    $('#btAddacu').attr('class', 'btacu');
                 }
             });
         
             $('#btRemoveAllacu').click(function() {    // Elimina todos los elementos del contenedor
         
                 $(containeracu).empty();
                 $(containeracu).remove();
                 $('#btAddacu').remove(); iCnt3 = 0;
                 $('#btAddacu').removeAttr('disabled');
                 $('#btAddacu').attr('class', 'btacu');
         
             });

              /*==================================================*/
              //Referendos
              var iCnt4 = 0;

              // Crear un elemento div añadiendo estilos CSS
                  var containerref = $(document.createElement('div'));
              
                  $('#btAddref').click(function() {
                      if (iCnt4 <= 6) {
              
                          iCnt4 = iCnt4 + 1;
              
                          // Añadir caja de texto.
              
                          $(containerref).append('<div id=DocRef' +iCnt4+'><input type="file" class="form-control" id="referendos-'+iCnt4+'" name="referendos+'+iCnt4+'" accept="application/pdf"><br></div>');
                         
                          if (iCnt4 == 1) {
              
              var divSubmitref = $(document.createElement('div'));
              
                          }
              
              $('#espacioref').after(containerref, divSubmitref);
                      }
                      else {      //se establece un limite para añadir elementos, 20 es el limite
              
                          $(containerref).append('<label id="limite4">Limite Alcanzado</label>');
                          $('#btAddref').attr('class', 'bt-disable');
                          $('#btAddref').attr('disabled', 'disabled');
              
                      }
                  });
              
                  $('#btRemoveref').click(function() {   // Elimina un elemento por click
                      if (iCnt4 != 0) { $('#DocRef' + iCnt4).remove(); iCnt4 = iCnt4 - 1; }
              
                      if (iCnt4 == 0) { $(containerref).empty();
              
                          $(containerref).remove();
                          $('#btSubmitDoc').remove();
                          $('#btAddref').removeAttr('disabled');
                          $('#btAddref').attr('class', 'btref')
              
                      }
                      if (iCnt4 <=6){
                        $('#btSubmitDoc').remove();
                        $('#limite4').remove();
                        $('#btAddref').removeAttr('disabled');
                        $('#btAddref').attr('class', 'btref');
                     }
                  });
              
                  $('#btRemoveAllref').click(function() {    // Elimina todos los elementos del contenedor
              
                      $(containerref).empty();
                      $(containerref).remove();
                      $('#btAddref').remove(); iCnt4 = 0;
                      $('#btAddref').removeAttr('disabled');
                      $('#btAddref').attr('class', 'btref');
              
                  });
                /*==================================================*/
                //Visto Bueno
                var iCnt5 = 0;

                // Crear un elemento div añadiendo estilos CSS
                    var containervis = $(document.createElement('div'));
                
                    $('#btAddvis').click(function() {
                        if (iCnt5 <= 6) {
                
                            iCnt5 = iCnt5 + 1;
                
                            // Añadir caja de texto.
                
                            $(containervis).append('<div id=DocVis' +iCnt5+'><input type="file" class="form-control" id="visto-'+iCnt5+'" name="visto+'+iCnt5+'" accept="application/pdf"><br></div>');
                           
                            if (iCnt5 == 1) {
                
                var divSubmitvisto = $(document.createElement('div'));
                
                            }
                
                $('#espaciovis').after(containervis, divSubmitvisto);
                        }
                        else {      //se establece un limite para añadir elementos, 20 es el limite
                
                            $(containervis).append('<label id="limite5">Limite Alcanzado</label>');
                            $('#btAddvis').attr('class', 'bt-disable');
                            $('#btAddvis').attr('disabled', 'disabled');
                
                        }
                    });
                
                    $('#btRemovevis').click(function() {   // Elimina un elemento por click
                        if (iCnt5 != 0) { $('#DocVis' + iCnt5).remove(); iCnt5 = iCnt5 - 1; }
                
                        if (iCnt5 == 0) { $(containervis).empty();
                
                            $(containervis).remove();
                            $('#btSubmitDoc').remove();
                            $('#btAddvis').removeAttr('disabled');
                            $('#btAddvis').attr('class', 'btvis')
                
                        }
                        if (iCnt5 <=6){
                            $('#btSubmitDoc').remove();
                            $('#limite5').remove();
                            $('#btAddvis').removeAttr('disabled');
                            $('#btAddvis').attr('class', 'btvis');
                         }
                    });
                
                    $('#btRemoveAllvis').click(function() {    // Elimina todos los elementos del contenedor
                
                        $(containervis).empty();
                        $(containervis).remove();
                        $('#btAddvis').remove(); iCnt5 = 0;
                        $('#btAddvis').removeAttr('disabled');
                        $('#btAddvis').attr('class', 'btvis');
                
                    }); 
                    /*==================================================*/
                    //Oficio de Registro
                    var iCnt6 = 0;

            // Crear un elemento div añadiendo estilos CSS
                var containerof = $(document.createElement('div'));
            
                $('#btAddof').click(function() {
                    if (iCnt6 <= 6) {
            
                        iCnt6 = iCnt6 + 1;
            
                        // Añadir caja de texto.
            
                        $(containerof).append('<div id=DocOf' +iCnt6+'><input type="file" class="form-control" id="oficio-'+iCnt6+'" name="oficio+'+iCnt6+'" accept="application/pdf"><br></div>');
                        
                        if (iCnt6 == 1) {
            
            var divSubmitof = $(document.createElement('div'));
            
                        }
            
            $('#espacioof').after(containerof, divSubmitof);
                    }
                    else {      //se establece un limite para añadir elementos, 20 es el limite
            
                        $(containerof).append('<labe id="limite6"l>Limite Alcanzado</label>');
                        $('#btAddof').attr('class', 'bt-disable');
                        $('#btAddof').attr('disabled', 'disabled');
            
                    }
                });
            
                $('#btRemoveof').click(function() {   // Elimina un elemento por click
                    if (iCnt6 != 0) { $('#DocOf' + iCnt6).remove(); iCnt6 = iCnt6 - 1; }
            
                    if (iCnt6 == 0) { $(containerof).empty();
            
                        $(containerof).remove();
                        $('#btSubmitDoc').remove();
                        $('#btAddof').removeAttr('disabled');
                        $('#btAddof').attr('class', 'btof')
            
                    }
                    if (iCnt6 <=6){
                        $('#btSubmitDoc').remove();
                        $('#limite6').remove();
                        $('#btAddof').removeAttr('disabled');
                        $('#btAddof').attr('class', 'btof');
                     }
                    
                });
            
                $('#btRemoveAllof').click(function() {    // Elimina todos los elementos del contenedor
            
                    $(containerof).empty();
                    $(containerof).remove();
                    $('#btAddof').remove(); iCnt6 = 0;
                    $('#btAddof').removeAttr('disabled');
                    $('#btAddof').attr('class', 'btof');
            
                });     
                
                //Solicitudes de Asesoría
                var iCnt7 = 0;

                // Crear un elemento div añadiendo estilos CSS
                    var containersoli = $(document.createElement('div'));
                
                    $('#btAddsoli').click(function() {
                        if (iCnt7 <= 6) {
                
                            iCnt7 = iCnt7 + 1;
                
                            // Añadir caja de texto.
                
                            $(containersoli).append('<div id=DocSoli' +iCnt7+'><input type="file" class="form-control" id="soli-'+iCnt7+'" name="soli+'+iCnt7+'" accept="application/pdf"><br></div>');
                           
                            if (iCnt7 == 1) {
                
                var divSubmitsoli = $(document.createElement('div'));
                
                            }
                
                $('#espaciosoli').after(containersoli, divSubmitsoli);
                        }
                        else {      //se establece un limite para añadir elementos, 20 es el limite
                
                            $(containersoli).append('<label id="limite7">Limite Alcanzado</label>');
                            $('#btAddsoli').attr('class', 'bt-disable');
                            $('#btAddsoli').attr('disabled', 'disabled');
                
                        }
                    });
                
                    $('#btRemovesoli').click(function() {   // Elimina un elemento por click
                        if (iCnt7 != 0) { $('#DocSoli' + iCnt7).remove(); iCnt7 = iCnt7 - 1; }
                
                        if (iCnt7 == 0) { $(containersoli).empty();
                
                            $(containersoli).remove();
                            $('#btSubmitDoc').remove();
                            $('#btAddsoli').removeAttr('disabled');
                            $('#btAddsoli').attr('class', 'btsoli')
                
                        }
                        if (iCnt7 <=6){
                            $('#btSubmitDoc').remove();
                            $('#limite7').remove();
                            $('#btAddsoli').removeAttr('disabled');
                            $('#btAddsoli').attr('class', 'btsoli');
                         }
                    });
                
                    $('#btRemoveAllsoli').click(function() {    // Elimina todos los elementos del contenedor
                
                        $(containersoli).empty();
                        $(containersoli).remove();
                        $('#btAddsoli').remove(); iCnt7 = 0;
                        $('#btAddsoli').removeAttr('disabled');
                        $('#btAddsoli').attr('class', 'btsoli');
                
                    });

                    //Aprobaciones de SEPUNA/CCP
                    var iCnt8 = 0;

                    // Crear un elemento div añadiendo estilos CSS
                        var containersep = $(document.createElement('div'));
                    
                        $('#btAddsep').click(function() {
                            if (iCnt8 <= 6) {
                    
                                iCnt8 = iCnt8 + 1;
                    
                                // Añadir caja de texto.
                    
                                $(containersep).append('<div id=DocSep' +iCnt8+'><input type="file" class="form-control" id="sep-'+iCnt8+'" name="sep+'+iCnt8+'" accept="application/pdf"><br></div>');
                               
                                if (iCnt8 == 1) {
                    
                    var divSubmitsep = $(document.createElement('div'));
                    
                                }
                    
                    $('#espaciosep').after(containersep, divSubmitsep);
                            }
                            else {      //se establece un limite para añadir elementos, 20 es el limite
                    
                                $(containersep).append('<label id="limite8">Limite Alcanzado</label>');
                                $('#btAddsep').attr('class', 'bt-disable');
                                $('#btAddsep').attr('disabled', 'disabled');
                    
                            }
                        });
                    
                        $('#btRemovesep').click(function() {   // Elimina un elemento por click
                            if (iCnt8 != 0) { $('#DocSep' + iCnt8).remove(); iCnt8 = iCnt8 - 1; }
                    
                            if (iCnt8 == 0) { $(containersep).empty();
                    
                                $(containersep).remove();
                                $('#btSubmitDoc').remove();
                                $('#btAddsep').removeAttr('disabled');
                                $('#btAddsep').attr('class', 'btsep')
                    
                            }
                            if (iCnt8 <=6){
                                $('#btSubmitDoc').remove();
                                $('#limite8').remove();
                                $('#btAddsep').removeAttr('disabled');
                                $('#btAddsep').attr('class', 'btsep');
                             }
                        });
                    
                        $('#btRemoveAllsep').click(function() {    // Elimina todos los elementos del contenedor
                    
                            $(containersep).empty();
                            $(containersep).remove();
                            $('#btAddsep').remove(); iCnt8 = 0;
                            $('#btAddsep').removeAttr('disabled');
                            $('#btAddsep').attr('class', 'btsep');
                    
                        });
                        //Documentación de Convenios
                        var iCnt9 = 0;

                        // Crear un elemento div añadiendo estilos CSS
                            var containerconv = $(document.createElement('div'));
                        
                            $('#btAddconv').click(function() {
                                if (iCnt9 <= 6) {
                        
                                    iCnt9 = iCnt9 + 1;
                        
                                    // Añadir caja de texto.
                        
                                    $(containerconv).append('<div id=DocConv' +iCnt9+'><input type="file" class="form-control" id="conv-'+iCnt9+'" name="conv+'+iCnt9+'" accept="application/pdf"><br></div>');
                                   
                                    if (iCnt9 == 1) {
                        
                        var divSubmitconv = $(document.createElement('div'));
                        
                                    }
                        
                        $('#espacioconv').after(containerconv, divSubmitconv);
                                }
                                else {      //se establece un limite para añadir elementos, 20 es el limite
                        
                                    $(containerconv).append('<label id="limite9">Limite Alcanzado</label>');
                                    $('#btAddconv').attr('class', 'bt-disable');
                                    $('#btAddconv').attr('disabled', 'disabled');
                        
                                }
                            });
                        
                            $('#btRemoveconv').click(function() {   // Elimina un elemento por click
                                if (iCnt9 != 0) { $('#DocConv' + iCnt9).remove(); iCnt9 = iCnt9 - 1; }
                        
                                if (iCnt9 == 0) { $(containerconv).empty();
                        
                                    $(containerconv).remove();
                                    $('#btSubmitDoc').remove();
                                    $('#btAddconv').removeAttr('disabled');
                                    $('#btAddconv').attr('class', 'btconv')
                        
                                }
                                if (iCnt9 <=6){
                                    $('#btSubmitDoc').remove();
                                    $('#limite9').remove();
                                    $('#btAddconv').removeAttr('disabled');
                                    $('#btAddconv').attr('class', 'btconv');
                                 }
                            });
                        
                            $('#btRemoveAllconv').click(function() {    // Elimina todos los elementos del contenedor
                        
                                $(containerconv).empty();
                                $(containerconv).remove();
                                $('#btAddconv').remove(); iCnt9 = 0;
                                $('#btAddconv').removeAttr('disabled');
                                $('#btAddconv').attr('class', 'btconv');
                        
                            });
                        //Currículums de Docentes
                        var iCnt10 = 0;

                        // Crear un elemento div añadiendo estilos CSS
                            var containercurri = $(document.createElement('div'));
                        
                            $('#btAddcurri').click(function() {
                                if (iCnt10 <= 6) {
                        
                                    iCnt10 = iCnt10 + 1;
                        
                                    // Añadir caja de texto.
                        
                                    $(containercurri).append('<div id=DocCurri' +iCnt10+'><input type="file" class="form-control" id="curri-'+iCnt10+'" name="curri+'+iCnt10+'" accept=".zip,.rar,.7z"><br></div>');
                                   
                                    if (iCnt10 == 1) {
                        
                        var divSubmitcurri = $(document.createElement('div'));
                        
                                    }
                        
                        $('#espaciocurri').after(containercurri, divSubmitcurri);
                                }
                                else {      //se establece un limite para añadir elementos, 20 es el limite
                        
                                    $(containercurri).append('<label id="limite10">Limite Alcanzado</label>');
                                    $('#btAddcurri').attr('class', 'bt-disable');
                                    $('#btAddcurri').attr('disabled', 'disabled');
                        
                                }
                            });
                        
                            $('#btRemovecurri').click(function() {   // Elimina un elemento por click
                                if (iCnt10 != 0) { $('#DocCurri' + iCnt10).remove(); iCnt10 = iCnt10 - 1; }
                        
                                if (iCnt10 == 0) { $(containercurri).empty();
                        
                                    $(containercurri).remove();
                                    $('#btSubmitDoc').remove();
                                    $('#btAddcurri').removeAttr('disabled');
                                    $('#btAddcurri').attr('class', 'btcurri');
                        
                                }
                                if (iCnt10 <=18){
                                   $('#btSubmitDoc').remove();
                                   $('#limite10').remove();
                                   $('#btAddcurri').removeAttr('disabled');
                                   $('#btAddcurri').attr('class', 'btcurri');
                                }
                            });
                        
                            $('#btRemoveAllcurri').click(function() {    // Elimina todos los elementos del contenedor
                        
                                $(containercurri).empty();
                                $(containercurri).remove();
                                $('#btAddcurri').remove(); iCnt10 = 0;
                                $('#btAddcurri').removeAttr('disabled');
                                $('#btAddcurri').attr('class', 'btcurri');
                        
                            });

                            //Declaración de Plan Terminal
                            var iCnt11 = 0;

                            // Crear un elemento div añadiendo estilos CSS
                                var containerdec = $(document.createElement('div'));
                            
                                $('#btAdddec').click(function() {
                                    if (iCnt11 <= 6) {
                            
                                        iCnt11 = iCnt11 + 1;
                            
                                        // Añadir caja de texto.
                            
                                        $(containerdec).append('<div id=Docdec' +iCnt11+'><input type="file" class="form-control" id="dec-'+iCnt11+'" name="dec+'+iCnt11+'" accept="application/pdf"><br></div>');
                                       
                                        if (iCnt11 == 1) {
                            
                            var divSubmitdec = $(document.createElement('div'));
                            
                                        }
                            
                            $('#espaciodec').after(containerdec, divSubmitdec);
                                    }
                                    else {      //se establece un limite para añadir elementos, 20 es el limite
                            
                                        $(containerdec).append('<label id="limite11">Limite Alcanzado</label>');
                                        $('#btAdddec').attr('class', 'bt-disable');
                                        $('#btAdddec').attr('disabled', 'disabled');
                            
                                    }
                                });
                            
                                $('#btRemovedec').click(function() {   // Elimina un elemento por click
                                    if (iCnt11 != 0) { $('#Docdec' + iCnt11).remove(); iCnt11 = iCnt11 - 1; }
                            
                                    if (iCnt11 == 0) { $(containerdec).empty();
                            
                                        $(containerdec).remove();
                                        $('#btSubmitDoc').remove();
                                        $('#btAdddec').removeAttr('disabled');
                                        $('#btAdddec').attr('class', 'btdec');
                            
                                    }
                                    if (iCnt11 <=18){
                                       $('#btSubmitDoc').remove();
                                       $('#limite11').remove();
                                       $('#btAdddec').removeAttr('disabled');
                                       $('#btAdddec').attr('class', 'btdec');
                                    }
                                });
                            
                                $('#btRemoveAlldec').click(function() {    // Elimina todos los elementos del contenedor
                            
                                    $(containerdec).empty();
                                    $(containerdec).remove();
                                    $('#btAdddec').remove(); iCnt11 = 0;
                                    $('#btAdddec').removeAttr('disabled');
                                    $('#btAdddec').attr('class', 'btdec');
                            
                                });
                                //Publicación del Plan Terminal
                                var iCnt12 = 0;

     // Crear un elemento div añadiendo estilos CSS
         var containerpubli = $(document.createElement('div'));
     
         $('#btAddpubli').click(function() {
             if (iCnt12 <= 6) {
     
                 iCnt12 = iCnt12 + 1;
     
                 // Añadir caja de texto.
     
                 $(containerpubli).append('<div id=Docpubli' +iCnt12+'><input type="file" class="form-control" id="publi-'+iCnt12+'" name="publi+'+iCnt12+'" accept="application/pdf"><br></div>');
                
                 if (iCnt12 == 1) {
     
     var divSubmitpubli = $(document.createElement('div'));
     
                 }
     
     $('#espaciopubli').after(containerpubli, divSubmitpubli);
             }
             else {      //se establece un limite para añadir elementos, 20 es el limite
     
                 $(containerpubli).append('<label id="limite12">Limite Alcanzado</label>');
                 $('#btAddpubli').attr('class', 'bt-disable');
                 $('#btAddpubli').attr('disabled', 'disabled');
     
             }
         });
     
         $('#btRemovepubli').click(function() {   // Elimina un elemento por click
             if (iCnt12 != 0) { $('#Docpubli' + iCnt12).remove(); iCnt12 = iCnt12 - 1; }
     
             if (iCnt12 == 0) { $(containerpubli).empty();
     
                 $(containerpubli).remove();
                 $('#btSubmitDoc').remove();
                 $('#btAddpubli').removeAttr('disabled');
                 $('#btAddpubli').attr('class', 'btpubli');
     
             }
             if (iCnt12 <=18){
                $('#btSubmitDoc').remove();
                $('#limite12').remove();
                $('#btAddpubli').removeAttr('disabled');
                $('#btAddpubli').attr('class', 'btpubli');
             }
         });
     
         $('#btRemoveAllpubli').click(function() {    // Elimina todos los elementos del contenedor
     
             $(containerpubli).empty();
             $(containerpubli).remove();
             $('#btAddpubli').remove(); iCnt12 = 0;
             $('#btAddpubli').removeAttr('disabled');
             $('#btAddpubli').attr('class', 'btpubli');
     
         });

}); //cierra el document ready

// Obtiene los valores de los textbox al dar click en el boton "Enviar"
// var divValue, values = '';

// function GetTextValue() {

//     $(divValue).empty();
//     $(divValue).remove(); values = '';

//     $('.input').each(function() {
//         divValue = $(document.createElement('div')).css({
//             padding:'5px', width:'200px'
//         });
//         values += this.value + '<br />'
//     });

//     $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
//     $('body').append(divValue);
// }