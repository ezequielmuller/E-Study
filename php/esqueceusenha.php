<?php
$to = 'andressadossantos361@gmail.com';
$subject = 'Esqueceu a senha';
$message  = 'Olá, este é um e-mail automático. Para redefinir sua senha, acesse:';
$headers = 'From: estudypi2024@gmail.com';

if(mail($to, $subject, $message, $headers)) {
      echo 'E-mail enviado com sucesso';
} else {
      echo 'Falha ao enviar e-mail.';
}

?>

