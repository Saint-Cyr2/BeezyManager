<?php

namespace KmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Branch
 *
 * @ORM\Table(name="branch")
 * @ORM\Entity(repositoryClass="KmBundle\Repository\BranchRepository")
 */
class Branch
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\OneToMany(targetEntity="TransactionBundle\Entity\STransaction", mappedBy="branch")
     */
    private $stransactions;
    
    /**
     * @ORM\OneToMany(targetEntity="KmBundle\Entity\Expenditure", mappedBy="branch")
     */
    private $expenditures;

    public function __construct() {
        $this->setCreatedAt(new \DateTime("now"));
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Branch
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Branch
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add stransaction
     *
     * @param \TransactionBundle\Entity\STransaction $stransaction
     *
     * @return Branch
     */
    public function addStransaction(\TransactionBundle\Entity\STransaction $stransaction)
    {
        $this->stransactions[] = $stransaction;

        return $this;
    }

    /**
     * Remove stransaction
     *
     * @param \TransactionBundle\Entity\STransaction $stransaction
     */
    public function removeStransaction(\TransactionBundle\Entity\STransaction $stransaction)
    {
        $this->stransactions->removeElement($stransaction);
    }

    /**
     * Get stransactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStransactions()
    {
        return $this->stransactions;
    }

    /**
     * Add expenditure
     *
     * @param \KmBundle\Entity\Expenditure $expenditure
     *
     * @return Branch
     */
    public function addExpenditure(\KmBundle\Entity\Expenditure $expenditure)
    {
        $this->expenditures[] = $expenditure;

        return $this;
    }

    /**
     * Remove expenditure
     *
     * @param \KmBundle\Entity\Expenditure $expenditure
     */
    public function removeExpenditure(\KmBundle\Entity\Expenditure $expenditure)
    {
        $this->expenditures->removeElement($expenditure);
    }

    /**
     * Get expenditures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpenditures()
    {
        return $this->expenditures;
    }
}
