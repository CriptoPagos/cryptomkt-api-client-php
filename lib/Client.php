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
 * Clase principal con el cliente de CryptoMKT
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-13
 */
class Client extends Object
{

    private $_url = 'https://api.cryptomkt.com'; ///< URL base para las llamadas a la API
    private $_version = 'v1'; ///< Versión de la API con la que funciona este SDK
    protected $auth_key; ///< API key para autenticación
    protected $auth_secret; ///< API secret para autenticación
    protected $response; ///< Objeto con la respuesta del servicio web de CryptoMKT

    /**
     * Método que entrega los mercados disponibles en CryptoMKT
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getMarkets()
    {
        $url = $this->createUrl('/market');
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener el listado de mercados: '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el ticker de algún mercados
     * Este método no requiere autenticación
     * @param market Mercado que se desea obtener o vacio (null) para obtenerlos todos
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getTicker($market = null)
    {
        $url = $this->createUrl('/ticker', compact('market'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener el ticker del mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega un libro de órdenes, ya sea de compra o venta
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getBook($market, $type, $page = 0, $limit = 20)
    {
        $url = $this->createUrl('/book', compact('market', 'type', 'page', 'limit'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener el libro de '.$type.' del mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el listado de intercambios cursados en CryptoMKT
     * Este método no requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getTrades($market, $start = null, $end = null, $page = 0, $limit = 20)
    {
        if (!$start) {
            $start = date('Y-m-d');
        }
        if (!$end) {
            $end = $start;
        }
        $url = $this->createUrl('/trades', compact('market', 'start', 'end', 'page', 'limit'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener los intercambios del mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el listado de ordenes activas del usuario en cierto mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getActiveOrders($market, $page = 0, $limit = 20)
    {
        $url = $this->createUrl('/orders/active', compact('market', 'page', 'limit'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener las órdenes activas del mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el listado de ordenes ejecutadas del usuario en cierto mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getExecutedOrders($market, $page = 0, $limit = 20)
    {
        $url = $this->createUrl('/orders/executed', compact('market', 'page', 'limit'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener las órdenes activas del mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que crea una orden en el libro de órdenes del mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function createOrder($market, $type, $amount, $price)
    {
        $url = $this->createUrl('/orders/create');
        $this->setResponse($this->consume($url, compact('market', 'type', 'amount', 'price')));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible crear la orden en el mercado '.$market.': '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el balance de las billeteras del usuario en CryptoMKT
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getOrder($id)
    {
        $url = $this->createUrl('/orders/status', compact('id'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener el balance de las billeteras: '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que cancela una orden en el libro de órdenes del mercado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function cancelOrder($id)
    {
        $url = $this->createUrl('/orders/cancel');
        $this->setResponse($this->consume($url, compact('id')));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible cancelar la orden '.$id.' en el mercado: '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que entrega el balance de las billeteras del usuario en CryptoMKT
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getBalance()
    {
        $url = $this->createUrl('/balance');
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener el balance de las billeteras: '.$body->message);
        }
        return $body->data;
    }

    /**
     * Método que crea una orden de pago
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function createPaymentOrder(\sasco\CryptoMKT\Payment\Order &$PaymentOrder)
    {
        $url = $this->createUrl('/payment/new_order');
        $this->setResponse($this->consume($url, $PaymentOrder->getData()));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible realizar consulta a CryptoMKT: '.$body->message);
        }
        $PaymentOrder->set($body->data);
        return $PaymentOrder;
    }

    /**
     * Método que recupera una orden de pago y su estado
     * Este método si requiere autenticación
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getPaymentOrder($id)
    {
        $url = $this->createUrl('/payment/status', compact('id'));
        $this->setResponse($this->consume($url));
        $body = json_decode($this->getResponse()->getBody());
        if ($this->getResponse()->getStatus()->code!=200) {
            throw new \Exception('No fue posible obtener la orden de pago '.$id.' desde CryptoMKT: '.$body->message);
        }
        $PaymentOrder = new \sasco\CryptoMKT\Payment\Order();
        $PaymentOrder->set($body->data);
        return $PaymentOrder;
    }

    /**
     * Método que crea la URL final que se usará para acceder al servicio web
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-12
     */
    private function createUrl($recurso, array $params = [])
    {
        $url = $this->_url.'/'.$this->_version.$recurso;
        if (!$params) {
            return $url;
        }
        $query = http_build_query($params);
        return sprintf("%s?%s", $url, $query);
    }

    /**
     * Método que consume el servicio web de CryptoMKT
     * Este método crea las cabeceras con la firma de los datos del servicio que
     * se está consultando
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    private function consume($url, $data = null)
    {
        $timestamp = $this->getTimestamp();
        $path = parse_url($url)['path'];
        $msg = $timestamp.$path;
        if ($data) {
            ksort($data);
            foreach($data as $var => $val) {
                $msg .= $val;
            }
        }
        $header = [
            'X-MKT-APIKEY' => $this->auth_key,
            'X-MKT-SIGNATURE' => hash_hmac('sha384', $msg, $this->auth_secret),
            'X-MKT-TIMESTAMP' => $timestamp,
        ];
        $Socket = new \sasco\CryptoMKT\Client\Socket();
        $Response = new \sasco\CryptoMKT\Client\Response($Socket->consume($url, $data, $header));
        return $Response;
    }

    /**
     * Método que entrega el timestamp en zona horaria UTC
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    private function getTimestamp()
    {
        $timezone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('@'.time(), $timezone);
        $date->setTimezone($timezone);
        $now = $date->getTimestamp() - $date->getOffset();
        return $now;
    }

}
