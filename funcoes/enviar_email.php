<?php
    $to = 'kaueschade04100@outlook.com';
    $subject = 'teste';
    $message = 'testado';
    $headers = 'From: naoresponda@knteam.com.br';

    mail($to, $subject, $message, $headers);

    print "Enviado!";