<?php

namespace TransactionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="TransactionBundle\Repository\ProductRepository")
 * @UniqueEntity("barcode", message="this barcode has been already used")
 * @UniqueEntity("name", message="this name has been already used")
 * @ORM\HasLifecycleCallbacks
 */
class Product
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
     * Unmapped property to handle file uploads
     */
    private $file;
    
    /**
     * @var string
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, unique=false, nullable=true)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=255, nullable=true, unique=true)
     */
    private $barcode;
    
    /**
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="float")
     */
    private $unitPrice;
    
    /**
     * @var float
     *
     * @ORM\Column(name="WholeSalePrice", type="float")
     */
    private $wholeSalePrice;
    
    public function __toString() {
        return $this->name;
    }
    
    /**
    * Sets file.
    *
    * @param UploadedFile $file
    */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
    * Get file.
    *
    * @return UploadedFile
    */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime());
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function removeUPdate()
    {
        //Check whether the file exists first
        if (file_exists(getcwd().'/upload/product/'.$this->getImage())){
            //Remove it
            @unlink(getcwd().'/upload/product/'.$this->getImage());
            
        }
        
        return;
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        // move takes the target directory and target filename as params
        $this->getFile()->move(getcwd().'/upload/product', $this->getId().'.'.$this->getFile()->guessExtension());
        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }
    
    /**
     * Set image
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @param string $image
     *
     * @return PrDependentCandidate
     */
    public function setImage($image)
    {
        if($this->getFile() !== null){
            $this->image = $this->getFile()->guessExtension();
        }
        
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getId().'.'.$this->image;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return PrParty
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
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
     * @return Product
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
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return Product
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return Product
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set wholeSalePrice
     *
     * @param float $wholeSalePrice
     *
     * @return Product
     */
    public function setWholeSalePrice($wholeSalePrice)
    {
        $this->wholeSalePrice = $wholeSalePrice;

        return $this;
    }

    /**
     * Get wholeSalePrice
     *
     * @return float
     */
    public function getWholeSalePrice()
    {
        return $this->wholeSalePrice;
    }

    /**
     * Set category
     *
     * @param \TransactionBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\TransactionBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \TransactionBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
