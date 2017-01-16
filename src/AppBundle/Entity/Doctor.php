<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="doctors")
 *
 * @ExclusionPolicy("all")
 */
class Doctor
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Expose
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Patient", mappedBy="doctor", cascade={"persist"})
     */
    private $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function __toArray(){
        return [
            'id'=>$this->id,
            'name'=>$this->name
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPatients()
    {
        return $this->patients;
    }

    /**
     * @param mixed $patients
     */
    public function setPatients($patients)
    {
        $this->patients = $patients;
    }

    /**
     * @param Patient $patient
     */
    public function addPatient(Patient $patient)
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setDoctor($this);
        }
    }

    /**
     * @param Patient $patient
     */
    public function removePatient(Patient $patient)
    {
        $this->patients->removeElement($patient);
        $patient->setDoctor(null);
    }


}