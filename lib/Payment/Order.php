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

namespace sasco\CryptoMKT\Payment;

/**
 * Clase que representa una orden de pago de CryptoMKT
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2017-10-13
 */
class Order extends \sasco\CryptoMKT\Object
{

    // atributos obligatorios para crear una orden
    protected $to_receive; ///< Monto a cobrar de la orden de pago. ARS soporta 2 decimales. CLP no soporta decimales. "." como separador de decimales.
    protected $to_receive_currency; ///< string requerido	Tipo de moneda con la cual recibirá el pago.
    protected $payment_receiver; ///< string requerido	Email del usuario o comercio que recibirá el pago. Debe estar registrado en CryptoMarket.

    // atributos opcionales para crear una orden
    protected $external_id; /// ID externo. Permite asociar orden interna de comercio con orden de pago. Max. 64 caracteres.
    protected $callback_url; ///< Url a la cual se notificarán los cambios de estado de la orden. Max. 256 caracteres.
    protected $error_url; ///< Url a la cual se rediccionará en caso de error. Max. 256 caracteres.
    protected $success_url; ///< Url a la cual se rediccionará en caso de éxito. Max. 256 caracteres.

    // atributos que se asignan a través del servicio web de CryptoMKT
    protected $id; ///< ID interno de la orden de pago
    protected $status; ///< Estado de la orden de pago
    protected $deposit_address; ///< Dirección de la orden de pago
    protected $expected_currency; ///< Tipo de moneda que espera la orden para ser aceptada
    protected $expected_amount; ///< Cantidad que espera la orden para ser aceptada
    protected $created_at; ///< Fecha de creación de la orden de pago
    protected $updated_at; ///< Fecha de actualización de la orden de pago
    protected $qr; ///< Url de la imagen QR de la orden de pago
    protected $payment_url; ///< Url de voucher de orden de pago
    protected $obs; ///< Observaciones

    protected $statuses = [
        -4  => 'Pago múltiple',
        -3  => 'Monto pagado no concuerda',
        -2  => 'Falló conversión',
        -1  => 'Expiró orden de pago',
         0  => 'Esperando pago',
         1  => 'Esperando bloque',
         2  => 'Esperando procesamiento',
         3  => 'Pago exitoso',
    ]; ///< Mensaje asociados al código de estado de la orden

    /**
     * Método que entrega los datos que se asignaron a la orden para que sea creada
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getData()
    {
        $data = [];
        foreach (['to_receive', 'to_receive_currency', 'payment_receiver', 'external_id', 'callback_url', 'error_url', 'success_url'] as $var) {
            if (isset($this->$var)) {
                $data[$var] = $this->$var;
            }
        }
        return $data;
    }

    /**
     * Método que entrega la URL
     * Wrapper de \sasco\CryptoMKT\Payment::getPaymentUrl()
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-13
     */
    public function getUrl()
    {
        return $this->getPaymentUrl();
    }

    /**
     * Método que entrega el texto asociado al estado de la orden de pago
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-14
     */
    public function getStatusMessage()
    {
        return $this->statuses[$this->getStatus()];
    }

    /**
     * Método que entrega el color asociado al estado de la orden de pago
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-14
     */
    public function getStatusColor()
    {
        if (!isset($this->status)) {
            return null;
        } else if ($this->status<0) {
            return 'danger';
        } else if ($this->status==0) {
            return 'info';
        } else if ($this->status==1) {
            return 'warning';
        } else if ($this->status==2) {
            return 'warning';
        } else if ($this->status==3) {
            return 'success';
        }
    }

    /**
     * Método que entrega el tiempo (fecha y hora) en que expira la orden de pago
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2017-10-14
     */
    public function getExpireTime()
    {
        $timezone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('@'.strtotime($this->created_at), $timezone);
        $date->setTimezone($timezone);
        $now = $date->getTimestamp() + $date->getOffset() + 15*60;
        return date('Y-m-d H:i:s', $now);
    }

}
