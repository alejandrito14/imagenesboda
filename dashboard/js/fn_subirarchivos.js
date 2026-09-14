 var vattachedFiles=[];

var vconfirmDeleteAttachedFile;
var vfile;
function fileUpload(event){

 
    //notify user about the file upload status

    var url='catalogos/sucursales/subirarchivossucursales.php',

    //get selected file
    files = event.target.files;
    
    //form data check the above bullet for what it is  
    var data = new FormData();           


    var contar= files.length;

    if (contar>0) {      

      var idsucursal=$("#idsucursales").val();


      $("#progress_id").css("width", "0%");
     $("#percent").text("0%");
     ModalCarga();                

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
     
            //append the uploadable file to FormData object
            data.append('file', file, file.name);
            data.append('idsucursal',idsucursal);
            
            //create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();     
            
            //post file data for upload
            xhr.open('POST', url, true);  
            xhr.send(data);


          xhr.onprogress = function(e) {
              
            var contentLength;
                if (e.lengthComputable) {
                  contentLength = e.total;
                } else {
                  contentLength = parseInt(e.target.getResponseHeader('x-decompressed-content-length'), 10);
                }
               

            contentLength=1;

               var percentValue = (e.loaded*100/contentLength) + '%';
                  $("#progress_id").animate({
                      width: '' + percentValue + ''
                  }, {
                      duration: 1000,
                      easing: "linear",
                      step: function (x) {
                        percentText = Math.round(x * 100 / e.loaded);
                        if(percentText >= "100") {
                          $("#percent").text("COMPLETADO");
                         $("#progress_id").css("width", "100%");
                          


                        }else{
                          $("#percent").text(percentText + "%");

                        }

                      }
                  });
                        setTimeout('cerrarModal()',5000);


          };
            xhr.onload = function () {

                //get response and show the uploading status
                var response = xhr.response;
              if(response==1){
                 nombreimagen=response.name;

                vattachedFiles.push(nombreimagen); 
         
               showAttachedFiles(idsucursal);
                setTimeout('cerrarModal('+idsucursal+')',3000);
              document.getElementById("demoimg").value = "";

              }

            if (response == 0) {

              alert(response.error);
             $("#progress_id").stop();
               $("#percent").text("Error");
               $("#progress_id").css("width", "0%");
                    setTimeout('cerrarModal()',3000);

            }




               
            };


        
    }
        $("#progress_id").css("width", "0%");

    }

}


function ModalCarga() {
  
          var html='<div class="modal" id="cargando" style="z-index: 1600;" role="dialog">'
         html+=' <div class="modal-dialog" role="document">'
           html+=' <div class="modal-content">'
            html+='  <div class="modal-header">'
               html+=' <h5 class="modal-title"></h5>'
               html+=' </button>'
              html+='</div>'
              html+='<div class="modal-body">'
              html+='  <p>Cargando...</p>'
             html+='<div class="progress" ><div id="progress_id" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>'
                 html+='</div>'
                    html+='<div style="margin-left: 86%;padding-top: 0px;" class="percent" id="percent">0%</div>'

             html+=' </div>'
             html+=' <div class="modal-footer">'
            
              html+='</div>'
           html+=' </div>'
         html+=' </div>'
        html+='</div>';

        $("#modales").html(html);
        $("#cargando").modal({backdrop: 'static', keyboard: false});


}
function cerrarModal(idsucursal) {


       $("#cargando").modal('hide');
       // showAttachedFiles(idproductos,idempresas);

}

function showAttachedFiles(idsucursal) {
    
    var datos="idsucursal="+idsucursal;
    $("#vfileNames").html("");
        $.ajax({
     type: 'post',
        url: 'catalogos/sucursales/obtenerimagenessucursal.php',
        data:datos,
        dataType: "json",
        success: function(vresponse, vtextStatus, vjqXHR){
                

               
              var vattachedFiles=vresponse.imagenes;

              var html=`<table class="table">
                <thead>
                  <tr>
                    <th scope="col">IMAGEN</th>
                    <th scope="col">ACCIÓN</th>
                   
                  </tr>
                </thead>
                <tbody>`;

                if (vattachedFiles.length>0) {
                  
                  for (var i =0;i < vattachedFiles.length; i++) {

                   
                   
                      html+=`<tr>
                      <th scope="row">
                      <img style="width:50px;height:50px;" src="catalogos/sucursales/imagenes/`+vattachedFiles[i].imagen+`" />
                      </th>
                     
                      <td><span style="cursor:pointer" onclick="deleteArchivo(`+ vattachedFiles[i].idsucursalesimagenes +`,`+vattachedFiles[i].idsucursales+`);" class="label label-success" style="background-color:#089908;font-size:16px;"><strong>x</strong></span></td>
                    </tr>`;
                  }

                }
                 
                 
               html+= `</tbody>
              </table>`;


                $("#vfileNames").html(html);
            
    },
    error: function(vjqXHR, vtextStatus, verrorThrown){
            alert(verrorThrown, vtitle, 0);
    }
  });   



 
}

function deleteArchivo(idsucursalesimagenes,idsucursal) {

  var datos='idsucursalesimagenes='+idsucursalesimagenes+"&idsucursal="+idsucursal;


          var r = confirm("¿Está seguro que desea eliminar el archivo adjuntado?.");
          if (r == true) {
             
               setTimeout(function () {
                    $.ajax({
                      url: 'catalogos/sucursales/eliminarimagen.php', //Url a donde la enviaremos
                      type: 'post', //Metodo que usaremos
                      data:datos,
                        async:false,

                      error: function (XMLHttpRequest, textStatus, errorThrown) {
                        var error;
                        console.log(XMLHttpRequest);
                        if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
                        if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
                        $("#contenedor_insumos").html(error);
                      },
                      success: function (msj) {
                        

                        showAttachedFiles(idsucursal);
                      }
                    });
                }, 100);

          } 

  
}


   function deleteAttachedFile(vfileName)
     {
        //Purpose: It deletes attached file.
        //Limitations: The end user must accept the deleting attached file.
        //Returns: None.
        
        var vacceptFunctionName=";";
        var vcancelFunctionName="cancelAttachedFileRemoval();";
        var vmessage="¿Está seguro que desea eliminar el archivo adjuntado?.";
        var vtitle="Eliminación de Archivo Adjuntado.";
        
    
      /*  alertify.confirm(vtitle, vmessage, function(){ //alertify.success('Ok');
          deleteAttachedFileData(vfileName); }
                , function(){ alertify.error('Cancel')});*/



        var txt;
          var r = confirm("¿Está seguro que desea eliminar el archivo adjuntado?.");
          if (r == true) {
             deleteAttachedFileData(vfileName);
          } else {
          
          }


     }

 function deleteAttachedFileData(vfileName)
 {
    //Purpose: It deletes attached file data.
    //Limitations: The attached file data must exist in database server and brought by service rest (attachFiles/:vfileName).
    //Returns: None.
    
    var vtitle="Eliminación de Archivo Adjuntado.";
   /* vconfirmDeleteAttachedFile.remove();
    toastr.clear(vconfirmDeleteAttachedFile, { force: true });*/
    
  $.ajax({
     type: 'post',
        url: 'catalogos/productos/eliminarimagen.php',
        data:{vfileName:vfileName},
    dataType: "json",
        success: function(vresponse, vtextStatus, vjqXHR){
            switch(vresponse.messageNumber){
                case -100: alert("Ocurrió un error al tratar de eliminar el archivo adjuntado, intente de nuevo.");
                           break;
                case -1:   alert("Imposible eliminar el archivo adjuntado, no existe.");
                           break;     
                case 0:    toastrAlert("Imposible eliminar el archivo, intente de nuevo.", vtitle, 3);
                           break;
                case 1:    var vattachedFileIndex=getAttachedFileIndexOnList(vfileName);
                        console.log(vattachedFileIndex);
                           if ( vattachedFileIndex>=0){
                             vattachedFiles.splice(vattachedFileIndex,1);
                           }
                           $("#vfileNames").html("");
                           showAttachedFiles();
                          
                           // alertify.alert('El archivo adjuntado ha sido eliminado correctamente.!');
                           alert('El archivo adjuntado ha sido eliminado correctamente.');
                           break; 
            }
    },
    error: function(vjqXHR, vtextStatus, verrorThrown){
            toastrAlert(verrorThrown, vtitle, 0);
    }
  });   
 }

 function GuardarImagenProductos(idempresas,idproductos,imagen) {
   
 }

 function getAttachedFileIndexOnList(vfileName)
 {

    
    var vattachedFileIndex=-1;
    for (var vi=0; vi<vattachedFiles.length; vi++){
        if (vfileName==vattachedFiles[vi]){
            vattachedFileIndex=vi;
            vi=vattachedFiles.length;
        }
    }
    
    return vattachedFileIndex;
 }


