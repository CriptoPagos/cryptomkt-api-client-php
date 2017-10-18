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

namespace sasco\CryptoMKT;

/**
 * Clase que representa un mercado
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-12
 */
class Market extends Object
{

    protected $market; ///< Mercado sobre el que se está operando
    protected $client; ///< Cliente de CryptoMKT

    /**
     * Constructor del mercado, permite detectar el mercado y asignar o bien
     * se espera que quien instancia la clase lo indique (en constructor o con
     * setMarket() posteriormente)
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function __construct($market = null)
    {
        if ($market == null) {
            $class = get_called_class();
            if ($class!=get_class()) {
                $this->setMarket(explode('\\', $class)[3]);
            }
        } else {
            $this->setMarket($market);
        }
    }

    /**
     * Método que entrega el ticker del mercado
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getTicker()
    {
        return $this->getClient()->getTicker($this->getMarket());
    }

    /**
     * Método que entrega el libro de compras del mercado
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getBuyBook($page = 0, $limit = null)
    {
        return $this->getClient()->getBook($this->getMarket(), 'buy', $page, $limit);
    }

    /**
     * Método que entrega el libro de ventas del mercado ETHCLP
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getSellBook($page = 0, $limit = null)
    {
        return $this->getClient()->getBook($this->getMarket(), 'sell', $page, $limit);
    }

    /**
     * Método que entrega el listado de intercambios cursados en CryptoMKT del mercado ETHCLP
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getTrades($start = null, $end = null, $page = 0, $limit = null)
    {
        return $this->getClient()->getTrades($this->getMarket(), $start, $end, $page, $limit);
    }

    /**
     * Método que entrega el listado de ordenes activas del usuario
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getActiveOrders($page = 0, $limit = null)
    {
        return $this->getClient()->getActiveOrders($this->getMarket(), $page, $limit);
    }

    /**
     * Método que entrega el listado de ordenes ejecutadas del usuario en el mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getExecutedOrders($page = 0, $limit = null)
    {
        return $this->getClient()->getExecutedOrders($this->getMarket(), $page, $limit);
    }

    /**
     * Método que crea una orden de compra en el libro de órdenes del mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function createBuyOrder($amount, $price)
    {
        return $this->getClient()->createOrder($this->getMarket(), 'buy', $amount, $price);
    }

    /**
     * Método que crea una orden de venta en el libro de órdenes del mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function createSellOrder($amount, $price)
    {
        return $this->getClient()->createOrder($this->getMarket(), 'sell', $amount, $price);
    }

}
