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
 * @example 005-cancelar_orden.php
 * Ejemplo para cancelar una orden de un usuario
 * @link https://developers.cryptomkt.com/es/#cancelar-una-orden
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-18
 */

// credenciales
$api_key = '';
$api_secret = '';

// incluir autoload composer
require '../../../vendor/autoload.php';

// crear cliente
$Client = new \sasco\CryptoMKT\Client();
$Client->setApiKey($api_key);
$Client->setApiSecret($api_secret);

// cancelar orden
print_r($Client->cancelOrder('M335846'));
