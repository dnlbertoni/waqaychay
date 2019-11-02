<?php


namespace Entidad;


use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="grupos")
 * @ORM\Entity
 */
class Grupos{

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