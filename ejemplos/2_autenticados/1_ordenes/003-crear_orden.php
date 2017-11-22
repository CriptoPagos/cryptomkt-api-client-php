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
 * @example 003-crear_orden.php
 * Ejemplo para crear una orden de compra o venta de un usuario en cierto mercado
 * @link https://developers.cryptomkt.com/es/#crear-orden
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-11-22
 */

// credenciales
$api_key = '';
$api_secret = '';

// incluir autoload composer
require '../../../vendor/autoload.php';

// crear cliente y mercado
$Client = new \sasco\CryptoMKT\Client($api_key, $api_secret);
$Market = $Client->getMarket('ETHCLP');

// crear una orden de compra para el usuario en el mercado
// poco ETH y precio muy bajo para evitar comprar por error si se ejecuta el ejemplo sin modificar
print_r($Market->createBuyOrder(0.01, 1000)); // 0.01 ETH a 1.000 pesos cada 1 ETH

// crear una orden de venta para el usuario en el mercado
// poco ETH y precio muy alto para evitar vender por error si se ejecuta el ejemplo sin modificar
print_r($Market->createSellOrder(0.01, 100000000)); // 0.01 ETH a 100.000.000 pesos cada 1 ETH
