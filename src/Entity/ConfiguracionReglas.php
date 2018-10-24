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

class ConfiguracionReglas implements JsonSerializable{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer", length=10)
     */
    private $id;

    /**
     * @ORM\Column(name="APLICAR_DESDE", type="string", length=16, nullable=false)
     */
    private $aplicarDesde;

    /**
     * @ORM\Column(name="OPERACION", type="string", length=1, nullable=false)
     */
    private $operacion;

    /**
     * @ORM\Column(name="VALOR", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @var ConfiguracionRedondeos
     * @ORM\ManyToOne(targetEntity="App\Entity\Gio\ConfiguracionRedondeos")
     * @ORM\JoinColumn(name="CONFIGURACION_REDONDEOS", referencedColumnName="ID", nullable=true)
     */
    private $redondeo;

    /**
     * @ORM\Column(name="STRDESCRIPCION", type="string", length=64, nullable=false)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="BLNELIMINADA", type="integer", length=1, nullable=false)
     */
    private $eliminada;

    /**
     * @ORM\Column(name="DATCREACION", type="string" )
     */
    private $datCreacion;

    public function __construct(){
    }

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
     * @return mixed
     */
    public function getAplicarDesde()
    {
        return $this->aplicarDesde;
    }

    /**
     * @param mixed $aplicarDesde
     */
    public function setAplicarDesde($aplicarDesde): void
    {
        $this->aplicarDesde = $aplicarDesde;
    }

    /**
     * @return mixed
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * @param mixed $operacion
     */
    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }

    /**
     * @return ConfiguracionRedondeos
     */
    public function getRedondeo(): ConfiguracionRedondeos
    {
        return $this->redondeo;
    }

    /**
     * @param ConfiguracionRedondeos $redondeo
     */
    public function setRedondeo(ConfiguracionRedondeos $redondeo): void
    {
        $this->redondeo = $redondeo;
    }

    /**
     * @return mixed
     */
    public function getEliminada()
    {
        return $this->eliminada;
    }

    /**
     * @param mixed $eliminada
     */
    public function setEliminada($eliminada): void
    {
        $this->eliminada = $eliminada;
    }

    /**
     * @return mixed
     */
    public function getDatCreacion()
    {
        return $this->datCreacion;
    }

    /**
     * @param mixed $datCreacion
     */
    public function setDatCreacion($datCreacion): void
    {
        $this->datCreacion = $datCreacion;
    }
    public function jsonSerialize()
    {
        return array(
            'id'=>$this->id,
            'valor'=>$this->valor,
            'descripcion'=>$this->descripcion,
            'redondeo'=>$this->redondeo,
            'eliminada'=>$this->eliminada,
            'operacion'=>$this->operacion,
            'dat_creacion'=>$this->datCreacion,
            'aplicar_desde'=>$this->aplicarDesde
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