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
 * @example 002-estado_orden_pago.php
 * Ejemplo para obtener el estado de una orden de pago
 * @link https://developers.cryptomkt.com/es/#estado-de-orden-de-pago
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-18
 */

// credenciales
$api_key = '';
$api_secret = '';

// incluir autoload composer
require '../../../vendor/autoload.php';

// crear cliente y mercado
$Client = new \sasco\CryptoMKT\Client();
$Client->setApiKey($api_key);
$Client->setApiSecret($api_secret);

// obtener estado de la orden de pago
print_r($Client->getPaymentOrder('P13560'));
