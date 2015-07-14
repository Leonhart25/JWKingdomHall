<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 6:15 PM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;

/**
 * Class Publisher
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="publisher")
 */
class Publisher {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Congregation
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Congregation", inversedBy="publishers")
     * @ORM\JoinColumn(name="congregation_id", referencedColumnName="id")
     * @Exclude()
     */
    protected $congregation;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     * @Accessor(getter="getFullName")
     * @Type(name="string")
     */
    protected $fullName;

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->lastName . ' ' . $this->firstName;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Territory", mappedBy="publisher")
     * @Exclude()
     */
    protected $territories;

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
     * Set firstName
     *
     * @param string $firstName
     * @return Publisher
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Publisher
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set congregation
     *
     * @param \KingdomHall\DataBundle\Entity\Congregation $congregation
     * @return Publisher
     */
    public function setCongregation(\KingdomHall\DataBundle\Entity\Congregation $congregation = null)
    {
        $this->congregation = $congregation;

        return $this;
    }

    /**
     * Get congregation
     *
     * @return \KingdomHall\DataBundle\Entity\Congregation 
     */
    public function getCongregation()
    {
        return $this->congregation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->territories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add territories
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territories
     * @return Publisher
     */
    public function addTerritory(\KingdomHall\DataBundle\Entity\Territory $territories)
    {
        $this->territories[] = $territories;

        return $this;
    }

    /**
     * Remove territories
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territories
     */
    public function removeTerritory(\KingdomHall\DataBundle\Entity\Territory $territories)
    {
        $this->territories->removeElement($territories);
    }

    /**
     * Get territories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTerritories()
    {
        return $this->territories;
    }


    /**
     * Set email
     *
     * @param string $email
     * @return Publisher
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}
