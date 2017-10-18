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
 * @file 002-ticker.php
 * Ejemplo para obtener el ticker de cierto mercado
 * @link https://developers.cryptomkt.com/es/#obtener-ticker
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-18
 */

// incluir autoload composer
require '../../vendor/autoload.php';

// crear cliente
$Client = new \sasco\CryptoMKT\Client();

// obtener ticker del mercado chileno de ether
// si no se indica el mercado, se obtienen todos los tickers de los
// mercados disponibles
print_r($Client->getTicker('ETHCLP'));

// idealmente, utilizar la clase con el mercado: \sasco\CryptoMKT\Market\ETHCLP
// al hacerlo así, se obtiene sólo el ticker de este mercado.
// en ejemplos futuros de mercados se usará sólo esta forma
// a pesar que existen los mismos métodos en el cliente que se pueden usar
// pasando los parámetros correspondientes
$Market = new \sasco\CryptoMKT\Market\ETHCLP();
$Market->setClient($Client);
print_r($Market->getTicker());
