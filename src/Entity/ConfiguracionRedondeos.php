<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRedondeosRepository")
 * @ORM\Table(name="CONFIGURACION_REDONDEOS")
 * 
 */

class ConfiguracionRedondeos implements JsonSerializable{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer", length=10)
     * @ORM\GeneratedValue
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
     * @var AmbitoSTD
     * @ORM\ManyToOne(targetEntity="AmbitoSTD", fetch="EAGER")
     * @ORM\JoinColumn(name="ID_AMBITOS_STD", referencedColumnName="ID")
     *
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
     * @return AmbitoSTD
     */
    public function getAmbito(): AmbitoSTD
    {
        return $this->ambito;
    }

    /**
     * @param AmbitoSTD $ambito
     */
    public function setAmbito(AmbitoSTD $ambito): void
    {
        $this->ambito = $ambito;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'id'=>$this->id,
            'valor'=>$this->valor,
            'descripcion'=>$this->descripcion,
            'ambito'=>$this->ambito,
        );
    }
}