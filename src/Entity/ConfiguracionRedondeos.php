<?php

namespace App\Entity\Gio;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 *
 * @ORM\Table(name="CONFIGURACION_REDONDEOS")
 * @ORM\Entity()
 * 
 */

class ConfiguracionRedondeos implements JsonSerializable{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer", length=10)
     */
    private $id;

    /**
     * @ORM\Column(name="STRDESCRIPCION", type="string", length=45, nullable=false)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="VALOR", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @ORM\Column(name="ID_AMBITOS_STD", type="integer", length=10)
     */
    private $ambito;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return integer
     */
    public function getAmbito()
    {
        return $this->ambito;
    }

    /**
     * @param integer $ambito
     */
    public function setAmbito($ambito): void
    {
        $this->ambito = $ambito;
    }
    public function jsonSerialize()
    {
        return array(
            'id'=>$this->id,
            'valor'=>$this->valor,
            'descripcion'=>$this->descripcion,
            'ambito'=>$this->ambito,
        );
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

}