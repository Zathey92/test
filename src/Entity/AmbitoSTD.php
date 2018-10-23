<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;


/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="AMBITOS_STD") 
 * 
 */
class AmbitoSTD  implements JsonSerializable{

    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="integer", length=3)   
     */
    private $id;
  
    /**
     * @ORM\Column(name="DENOMINACION", type="string", length=64)
     */
    private $denominacion;


    /**
     * Set id
     *
     * @param integer $id
     * @return AmbitoSTD
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set denominacion
     *
     * @param string $denominacion
     * @return AmbitoSTD
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;
    
        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string 
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    public function toArray() {

        return array('id' => $this->id, 'denominacion' => $this->denominacion);

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
            'id' => $this->id,
            'denominacion'=> $this->denominacion,

        );
    }
}