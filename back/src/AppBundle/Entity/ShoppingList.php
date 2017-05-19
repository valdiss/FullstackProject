<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingList
 *
 * @ORM\Table(name="shopping_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoppingListRepository")
 */
class ShoppingList
{
  /**
   * Constructor
   */
  public function __construct($user, $name)
  {
    $this->setUser($user);
    $this->setName($name);
    $this->products = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
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
   * @ORM\ManyToOne(targetEntity="User", inversedBy="shoppinglists")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  private $user;
  /**
   * Set user
   *
   * @param \AppBundle\Entity\User $user
   * @return ShoppingList
   */
  public function setUser(\AppBundle\Entity\User $user = null)
  {
    $this->user = $user;
    return $this;
  }
  /**
   * Get user
   *
   * @return \AppBundle\Entity\User
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * @var string
   *
   * @ORM\Column(name="Name", type="string", length=255, unique=false)
   */
  private $name;
  /**
   * Set name
   *
   * @param string $name
   * @return ShoppingList
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
   * @ORM\OneToMany(targetEntity="Product", mappedBy="shoppinglist")
   */
  private $products;

  /**
   * Add product
   *
   * @param \AppBundle\Entity\Product $product
   *
   * @return ShoppingList
   */
  public function addProduct(\AppBundle\Entity\Product $product)
  {
    $this->products[] = $product;
    return $this;
  }

  /**
   * Remove product
   *
   * @param \AppBundle\Entity\Product $product
   */
  public function removeProduct(\AppBundle\Entity\Product $product)
  {
    $this->products->removeElement($product);
  }

  /**
   * Get products
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getProducts()
  {
    return $this->products;
  }
}
