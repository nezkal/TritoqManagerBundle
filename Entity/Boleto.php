<?php

namespace Tritoq\Bundle\ManagerBoletoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Boleto
 *
 * @ORM\Table(name="tritoq_manager_boletos")
 * @ORM\Entity(repositoryClass="Tritoq\Bundle\ManagerBoletoBundle\Entity\BoletoRepository")
 */
class Boleto
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="string")
     */
    private $hash;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sequencial;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date_updated;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $nosso_numero;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date_validate;


    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $sacado;


    /**
     * @ORM\Column(type="integer", options={"default"=1})
     * @var integer
     */
    private $status;


    /**
     *
     */
    public function __construct()
    {
        $this->hash = md5(time());
        $this->date_created = new \DateTime('now');
        $this->date_updated = new \DateTime('now');
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }



    /**
     * @param string $sacado
     */
    public function setSacado($sacado)
    {
        $this->sacado = $sacado;
    }

    /**
     * @return string
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * @param int $sequencial
     */
    public function setSequencial($sequencial)
    {
        $this->sequencial = $sequencial;
    }

    /**
     * @return int
     */
    public function getSequencial()
    {
        return $this->sequencial;
    }




    /**
     * @param \DateTime $date_validate
     */
    public function setDateValidate($date_validate)
    {
        $this->date_validate = $date_validate;
    }

    /**
     * @return \DateTime
     */
    public function getDateValidate()
    {
        return $this->date_validate;
    }


    /**
     * @param \DateTime $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param \DateTime $date_updated
     */
    public function setDateUpdated($date_updated)
    {
        $this->date_updated = $date_updated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nosso_numero
     */
    public function setNossoNumero($nosso_numero)
    {
        $this->nosso_numero = $nosso_numero;
    }

    /**
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nosso_numero;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }


}