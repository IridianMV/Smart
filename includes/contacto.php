<?
if(isset($_REQUEST['callback'])){ // Si ha llegado callback

if(isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'cotizacion'){
if(stristr($_REQUEST['name'], '<a') === FALSE
    && stristr($_REQUEST['email'], '<a') === FALSE
    && stristr($_REQUEST['phone'], '<a') === FALSE
    && stristr($_REQUEST['message'], '<a') === FALSE
    && stristr($_REQUEST['name'], '<script') === FALSE
    && stristr($_REQUEST['email'], '<script') === FALSE
    && stristr($_REQUEST['phone'], '<script') === FALSE
    && stristr($_REQUEST['message'], '<script') === FALSE
    ) {
$TEST           = false;
$email_noreply  = $_REQUEST['email'];
$to             = 'agamez@corporativobora.com.mx';
$from           = 'smart-service.com.mx';
$subject        = 'Formulario de contacto | smart-service.com.mx';
$company_name   = 'SMART-SERVICE.COM.MX';
$title_email    = 'Nuevo formulario de contacto';
ob_start(); 
?>

<table cellpadding="0" cellspacing="0" border="0" style="width:100%; background:#222; text-align:center;">
<tbody>
<tr>
<td>

<table align="center" cellpadding="0" cellspacing="0" border="0" style="width:85%; max-width:600px; background:#fff; font-family:Arial; padding:50px 10px; margin:30px auto 50px auto;">
<tbody>
    <tr>
        <td colspan="2">
            <h1 style="font-family:Arial; color:#D91E18; font-size:24px;">CONTACTO <?=$company_name?></h1>
            <h3 style="font-family:Arial; color:#222; font-size:20px;"><?=$title_email?></h3>
        </td>
    </tr>
    <tr>
        <td style="text-align:right" width="40%"><strong>Nombre:</strong> </td>
        <td style="text-align:left" width="60%"> &nbsp; <?=$_REQUEST['name']?></td>
    </tr>
    <tr>
        <td style="text-align:right" width="40%"><strong>Email:</strong> </td>
        <td style="text-align:left" width="60%"> &nbsp; <?=$_REQUEST['email']?></td>
    </tr>
    <tr>
        <td style="text-align:right" width="40%"><strong>Teléfono:</strong> </td>
        <td style="text-align:left" width="60%"> &nbsp; <?=$_REQUEST['phone']?></td>
        <td style="text-align:right" width="40%"><strong>Mensaje:</strong> </td>
        <td style="text-align:left" width="60%"> &nbsp; <?=$_REQUEST['message']?></td>
    </tr>
    <? } ?>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>
<? 
$html = ob_get_contents();
ob_end_clean();


require 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->CharSet = 'UTF-8';
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
//mail->SMTPAuth = true;                               // Enable SMTP authentication
//$mail->Username = 'mailer@marmol-onix.com';                 // SMTP username
//$mail->Password = '123123Abc*';                           // SMTP password
//$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
//$mail->Port = 465;                                    // TCP port to connect to
$mail->From = 'mailer@smart-service.com.mx';
$mail->FromName = $from;
if($TEST){
    $mail->addAddress($to);     // Add a recipient
}else{
    //$mail->addAddress('agamez@corporativobora.com.mx');
    //$mail->addAddress('gbonilla@corporativobora.com.mx');
    $mail->addAddress('');
    $mail->addBCC('');
    $mail->addBCC($to);
}
$mail->addReplyTo($email_noreply);
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject;
$mail->Body    = $html;

if(!$mail->send()){
    $result = 'error';
} else {
    $result = 'success';
}

$array = array("result" => $result);
echo $_REQUEST['callback'].'('.json_encode($array).')';

}//End validate spam
}//End validate cmd variable

}
?>
