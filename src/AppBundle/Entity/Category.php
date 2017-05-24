<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
   * Get id
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }


  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=255, unique=true)
   */
  private $name;
  /**
   * Set name
   *
   * @param string $name
   * @return Category
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
   * @ORM\ManyToOne(targetEntity="User", inversedBy="categories")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  private $user;
  /**
   * Set user
   *
   * @param \AppBundle\Entity\User $user
   * @return Category
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
   * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
   */
  private $products;
  /**
   * Add product
   *
   * @param \AppBundle\Entity\Product $product
   * @return Category
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



  /**
   * Constructor
   */
  public function __construct($user, $category)
  {
    $this->setUser($user);
    $this->setName($category);
    $this->products = new \Doctrine\Common\Collections\ArrayCollection();
  }
}
