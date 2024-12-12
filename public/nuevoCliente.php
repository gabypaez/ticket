
<?php
require("config.php");
require_once __DIR__ . '/mpdf/vendor/autoload.php';
require_once(dirname(__FILE__).'/phpqrcode/qrlib.php');
session_start();



$nombre        = ucwords($_REQUEST['nombre']); //ucwords para convertir la 1 letra mayuscula
$dni        = $_REQUEST['dni'];
$correo        = $_REQUEST['correo']; 
$celular       = $_REQUEST['celular'];


if(buscaRepetido($dni,$correo,$con)==1){

  $_SESSION['mensaje']['mensaje'] = '<b>Error!</b> Usuario Ya Registrado';
  $_SESSION['mensaje']['tipo'] = 'danger';
}else{
  $InsertCliente = "INSERT INTO invitados(
    nombre,
    dni,
    correo,
    celular
    )
  VALUES (
    '" .$nombre. "',
    '". $dni."',
    '" .$correo. "',
    '" .$celular. "'
)";
$resultadoCliente = mysqli_query($con, $InsertCliente);


    $string_to_encrypt="$dni";
    $password="nfdjs789456fdjshfdjsfin&&%%%8uwrjewm";
    $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
    $decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB",$password);
  

}


function buscaRepetido($d,$co,$conexion){
  $sql="SELECT * from invitados 
    where dni='$d' and correo='$co'";
  $result=mysqli_query($conexion,$sql);

  if(mysqli_num_rows($result) > 0){
    return 1;
  }else{
    return 0;
  }
}






          
          
          
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__FILE__).'/PHPMailer/src/Exception.php';
require dirname(__FILE__).'/PHPMailer/src/PHPMailer.php';
require dirname(__FILE__).'/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
//Server settings
$mail->SMTPDebug = 0;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'mincienciaeinovacion@gmail.com';                     //SMTP username
$mail->Password   = 'nabfnnkqlejqarij';                               //SMTP password
$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom('mincienciaeinovacion@gmail.com', 'Invitacion');
$mail->addAddress($correo, $nombre);     //Add a recipient



//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Inscripcion';
$mail->Body    = 'Holaa!! Muchas Gracias por realizar su inscripcion, por favor descargue su Ticket</b>  <a href="/generar_entrada_mail.php?dni='.$encrypted_string.'>">Descargar ticket</a>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();

if($resultadoCliente){

  $_SESSION['mensaje']['mensaje'] = '<b>Exelente!</b> Gracias por su Inscripcion :D Por Favor Revise su Email para descargar su entrada';
  $_SESSION['mensaje']['tipo'] = 'success';
   }
    else {
      $_SESSION['mensaje']['mensaje'] = '<b>Error!</b> No se pudo hacer el Resgistro';
      $_SESSION['mensaje']['tipo'] = 'danger';
    }

} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




?>

<script>window.location.href = 'form-inscripcion.php' </script>