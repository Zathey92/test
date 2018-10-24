<?php

namespace App\Entity\Gio;

use App\Entity\MobileApp\Valores;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="CONFIGURACION_FILTROS")
 * @ORM\Entity()
 * 
 */

class ConfiguracionFiltros {
    
    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer", length=10)
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="PRECIO_DESDE", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $precioDesde;
    /**
     * @ORM\Column(name="PRECIO_HASTA", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $precioHasta;

    /**
     * @ORM\Column(name="STRPRECIO_FILTRO", type="string", length=16, nullable=false)
     */
    private $precioFiltro;

    /**
     * @ORM\Column(name="VALOR", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @var ConfiguracionReglas
     * @ORM\ManyToOne(targetEntity="App\Entity\Gio\ConfiguracionReglas")
     * @ORM\JoinColumn(name="CONFIGURACION_REGLAS", referencedColumnName="ID")
     */
    private $regla;

    /**
     * @var ProveedorArticulos
     * @ORM\ManyToOne(targetEntity="App\Entity\Gio\ProveedorArticulos")
     * @ORM\JoinColumn(name="PROVEEDO", referencedColumnName="CDGPROVEEDOR")
     */
    private $proveedor;

    /**
     * @var Valores
     * @ORM\ManyToOne(targetEntity="App\Entity\MobileApp\Valores")
     * @ORM\JoinColumn(name="VALORES", referencedColumnName="CDGVALOR")
     */
    private $marca;

    /**
     * @var TipoArticulo
     * @ORM\ManyToOne(targetEntity="App\Entity\Gio\TipoArticulo")
     * @ORM\JoinColumn(name="TIPOS", referencedColumnName="CDGTIPO")
     */
    private $familia;

    /**
     * @ORM\Column(name="BLNACTIVO", type="integer", length=1,options={"default" : 1})
     */
    private $activo;

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

    /**
     * @return mixed
     */
    public function getPrecioDesde()
    {
        return $this->precioDesde;
    }

    /**
     * @param mixed $precioDesde
     */
    public function setPrecioDesde($precioDesde): void
    {
        $this->precioDesde = $precioDesde;
    }

    /**
     * @return mixed
     */
    public function getPrecioHasta()
    {
        return $this->precioHasta;
    }

    /**
     * @param mixed $precioHasta
     */
    public function setPrecioHasta($precioHasta): void
    {
        $this->precioHasta = $precioHasta;
    }

    /**
     * @return mixed
     */
    public function getPrecioFiltro()
    {
        return $this->precioFiltro;
    }

    /**
     * @param mixed $operacion
     */
    public function setPrecioFiltro($precio): void
    {
        $this->precioFiltro = $precio;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return ConfiguracionReglas
     */
    public function getRegla(): ConfiguracionReglas
    {
        return $this->regla;
    }

    /**
     * @param ConfiguracionReglas $regla
     */
    public function setRegla(ConfiguracionReglas $regla): void
    {
        $this->regla = $regla;
    }

    /**
     * @return ProveedorArticulos
     */
    public function getProveedor(): ProveedorArticulos
    {
        return $this->proveedor;
    }

    /**
     * @param ProveedorArticulos $proveedor
     */
    public function setProveedor(ProveedorArticulos $proveedor): void
    {
        $this->proveedor = $proveedor;
    }

    /**
     * @return Valores
     */
    public function getMarca(): Valores
    {
        return $this->marca;
    }

    /**
     * @param Valores $marca
     */
    public function setMarca(Valores $marca): void
    {
        $this->marca = $marca;
    }

    /**
     * @return TipoArticulo
     */
    public function getFamilia(): TipoArticulo
    {
        return $this->familia;
    }

    /**
     * @param TipoArticulo $familia
     */
    public function setFamilia(TipoArticulo $familia): void
    {
        $this->familia = $familia;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo): void
    {
        $this->activo = $activo;
    }

}