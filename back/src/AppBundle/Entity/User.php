<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;


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
     * @return User
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
   * @ORM\OneToMany(targetEntity="ShoppingList", mappedBy="user")
   */
  private $shoppinglists;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shoppinglists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shoppinglist
     *
     * @param \AppBundle\Entity\ShoppingList $shoppinglist
     *
     * @return User
     */
    public function addShoppinglist(\AppBundle\Entity\ShoppingList $shoppinglist)
    {
        $this->shoppinglists[] = $shoppinglist;

        return $this;
    }

    /**
     * Remove shoppinglist
     *
     * @param \AppBundle\Entity\ShoppingList $shoppinglist
     */
    public function removeShoppinglist(\AppBundle\Entity\ShoppingList $shoppinglist)
    {
        $this->shoppinglists->removeElement($shoppinglist);
    }

    /**
     * Get shoppinglists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShoppinglists()
    {
        return $this->shoppinglists;
    }
}
