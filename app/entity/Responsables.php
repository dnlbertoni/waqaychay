<?php


namespace Entidad;


use Doctrine\ORM\Mapping as ORM;

/**
 * Responsables
 *
 * @ORM\Table(name="responsables")
 * @ORM\Entity
 */
class Responsables{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;


    public function __get($property)
    {

        if (property_exists($this, $property)) {
            return $this->$property;
        }

    }

    public function __set($property, $value)
    {

        if (property_exists($this, $property)) {

            $this->$property = $value;

        }
    }
}