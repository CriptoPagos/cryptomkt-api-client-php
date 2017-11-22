<?php

/**
 * Cliente para servicios web de CryptoMKT
 * Copyright (C) SASCO SpA (https://sasco.cl)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o modificarlo
 * bajo los términos de la GNU Lesser General Public License (LGPL) publicada
 * por la Fundación para el Software Libre, ya sea la versión 3 de la Licencia,
 * o (a su elección) cualquier versión posterior de la misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero SIN
 * GARANTÍA ALGUNA; ni siquiera la garantía implícita MERCANTIL o de APTITUD
 * PARA UN PROPÓSITO DETERMINADO. Consulte los detalles de la GNU Lesser General
 * Public License (LGPL) para obtener una información más detallada.
 *
 * Debería haber recibido una copia de la GNU Lesser General Public License
 * (LGPL) junto a este programa. En caso contrario, consulte
 * <http://www.gnu.org/licenses/lgpl.html>.
 */

/**
 * @example 001-crear_orden_pago.php
 * Ejemplo para crear una orden de pago
 * @link https://developers.cryptomkt.com/es/#crear-orden-de-pago
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-11-22
 */

// credenciales
$api_key = '';
$api_secret = '';

// incluir autoload composer
require '../../../vendor/autoload.php';

// crear cliente
$Client = new \sasco\CryptoMKT\Client($api_key, $api_secret);

// crear orden de pago
// $Client->createPaymentOrder() modifica $PaymentOrder asignando la respuesta con los datos de la orden
// también lo retorna, pero como lo modifica directamente, no sería necesario ocupar lo retornado
$PaymentOrder = new \sasco\CryptoMKT\Payment\Order();
$PaymentOrder->setToReceive(10000);
$PaymentOrder->setToReceiveCurrency('CLP');
$PaymentOrder->setPaymentReceiver('comercio@example.com'); // registrado en CryptoMKT
$PaymentOrder->setExternalId('codigo-orden-interno-del-comercio');
$PaymentOrder->setCallbackUrl('https://example.com/api/cryptomkt/notification');
$PaymentOrder->setErrorUrl('https://example.com/cryptomkt/error');
$PaymentOrder->setSuccessUrl('https://example.com/cryptomkt/thanks');
$Client->createPaymentOrder($PaymentOrder);
print_r($PaymentOrder);
