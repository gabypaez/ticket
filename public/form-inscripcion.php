<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="shortcut icon" href="img/logo1.png"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/cargando.css">
  <link rel="stylesheet" type="text/css" href="css/maquinawrite.css">
  <style> 
        table tr th{
            background:rgba(0, 0, 0, .6);
            color: #fff;
        }
        tbody tr{
          font-size: 12px !important;

        }
        h3{
            color:crimson; 
            margin-top: 100px;
        }
        a:hover{
            cursor: pointer;
            color: #333 !important;
        }
        em{
          font-size: 15px;
        }
      </style>
</head>
<body>
  
<div class="cargando">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>




<nav class="navbar navbar-expand-lg navbar-light navbar-dark fixed-top" style="background-color:hsl(268, 78.70%, 55.90%) !important;">
    <ul class="navbar-nav mr-auto collapse navbar-collapse">
      <li class="nav-item active">
          <img src="img/logo2.png" alt="Ministerio" width="75">
        </a>
      </li>
    </ul>
   
    <div class="my-2 my-lg-0" id="maquinaescribir">
    <img src="img/logo1.png" alt="Web Developer Urian Viera" width="220">
    </div>
  
</nav>
<br><br>


<div class="container mt-5 p-5">

  <h4 class="text-center">
    Bienvenidos Tecno Ciencia
    <br><br>
    <img src="img/logo5.jpeg" alt="TecnoCiencias" width="1000">
  </h4>
  <hr>
  


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-12 " > 
    <strong>Registrar Nuevo Invitado</strong>
  </div>
  
    <!--
  <div class="col-md-6"> 
    <strong>Lista de Clientes </strong>
  </div>
      -->
</div>

<?php require_once(dirname(__FILE__).'/mensajes.php'); ?>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="body">
      <div class="container d-flex justify-content-center">
      

        <!----- formulario --->
        <div class="col-sm-5 " >
          <form name="formCliente" id="formCliente" action="nuevoCliente.php" method="POST">
              <div class="row">
                
                <div class="col-md-12 mt-5">
                    <label for="name" class="form-label"> DNI</label>
                    <input type="number" class="form-control" name="dni" id="dni" required='true' autofocus>
                    <div id="respuesta"> </div>
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">Nombre y Apellido</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" id="correo" required='true'>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="number" class="form-control" name="celular" id="celular" required='true'>
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                        <button type="submit" class="btn btn-block btn-primary " style="background-color:hsl(268, 78.70%, 55.90%)">Registrar</button>
                    </div>
                </div>
          </form>
        </div>  
      </div>   
        <br><br>
      
      <!--fin form -->

          <!-- <div class="col-sm-7">
              <div class="row" id="listClientes">


              </div>
          </div>
     -->


        </div>
      </div>
  </div>
</div>
</div>


<script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
      //Apenas cargue el La pagina cargara la lista de Clientes.
      $("#listClientes").load("listClientes.php"); //load es una funcion de Jquery
      $(".zmdi-hc-spin").hide(); //Oculto la animacion del boton enviar

      //Efecto Pre-Carga
      $(window).load(function() {
          $(".cargando").fadeOut(500);
      });


    //Codigo para limitar la cantidad maxima que tendra dicho Input
    $('input#dni').keypress(function (event) {
      if (event.which < 48 || event.which > 57 || this.value.length === 8) {
        return false;
      }
    });
    

    //Validar la cantidad maxima en el campo celular
    $('input#celular').keypress(function (event) {
      if (event.which < 48 || event.which > 57 || this.value.length === 10) {
        return false;
      }
    });


//Validando si existe la Cedula en BD antes de enviar el Form
$("#dni").on("keyup", function() {
  var dni = $("#dni").val(); //CAPTURANDO EL VALOR DE INPUT CON ID CEDULA
  var longitudDni = $("#dni").val().length; //CUENTO LONGITUD

//Valido la longitud 
  if(longitudDni >= 3){
    var dataString = 'dni=' + dni;

      $.ajax({
          url: 'verificarDni.php',
          type: "GET",
          data: dataString,
          dataType: "JSON",

          success: function(datos){

                if( datos.success == 1){

                $("#respuesta").html(datos.message);

                $("input").attr('disabled',true); //Desabilito el input nombre
                $("input#dni").attr('disabled',false); //Habilitando el input dni
                $("#btnEnviar").attr('disabled',true); //Desabilito el Botton

                }else{

                $("#respuesta").html(datos.message);

                $("input").attr('disabled',false); //Habilito el input nombre
                $("#btnEnviar").attr('disabled',false); //Habilito el Botton

                    }
                  }
                });
              }
          });

/*
        //Funcion para enviar el formulario de registro.
        $('#btnEnviar').click(function(e){
            e.preventDefault();

          //Muestro el efecto cargando en el boton
          $(".zmdi-hc-spin").show();  

          setTimeout(function() {
            $(".zmdi-hc-spin").hide();
            $("#btnEnviar").attr('disabled',false); //Desabilito el boton enviar
          }, 1000);

        url = "nuevoCliente.php";
         $.ajax({
              type: "POST",
              url: url,
              data: $("#formCliente").serialize(),
              success: function(datos)
              {
                alertify.success("Gracias la Inscripcion fue Exitosa, Por Favor revise su email");
                $("#formCliente")[0].reset(); //Limpio todos los input de mi formulario
              }
          });
        });
*/

 });
      
</script>

</body>
</html>