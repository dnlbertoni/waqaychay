<?php


namespace Entidad;


use Doctrine\ORM\Mapping as ORM;

/**
 * Tareas
 *
 * @ORM\Table(name="tareas")
 * @ORM\Entity
 */

class Tareas
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $detalle;
    /**
     * @ORM\Column(name="idsubproceso", type="integer", length=5)
     */
    private $idtarea;

    /**
     * @ORM\Column(name="estado", type="integer", length=5)
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