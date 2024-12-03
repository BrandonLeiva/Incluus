<?php
require(__DIR__ . "/lib/FlowApi.class.php");

// Simulando los valores del formulario (por ejemplo, como si fueran enviados desde un formulario HTML)
$email = "cliente@gmail.com";  // Cambia esto al correo que desees
$amount = 5000;  // Cambia esto al monto que desees

// Datos opcionales
$optional = array(
    "rut" => "9999999-9",
    "otroDato" => "otroDato"
);
$optional = json_encode($optional);

// Prepara los parámetros de la transacción
$params = array(
    "commerceOrder" => rand(1100, 2000),
    "subject" => "Pago de prueba",
    "currency" => "CLP",
    "amount" => $amount,  // Usar el monto simulado
    "email" => $email,    // Usar el correo simulado
    "paymentMethod" => 9,
    "urlConfirmation" => Config::get("BASEURL") . "/confirm.php",
    "urlReturn" => Config::get("BASEURL") . "/result.php",
    "optional" => $optional
);

// Servicio a utilizar
$serviceName = "payment/create";

try {
    $flowApi = new FlowApi;
    // Ejecuta el servicio
    $response = $flowApi->send($serviceName, $params, "POST");

    // Prepara la URL de redirección
    $redirect = $response["url"] . "?token=" . $response["token"];
    header("location:$redirect");
} catch (Exception $e) {
    echo $e->getCode() . " - " . $e->getMessage();
}
?>
