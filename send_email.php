<?php
function sendEmail($to, $subject, $message) {
    $headers = "From: no-reply@e-leave-system.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($to, $subject, $message, $headers);
}
?>
