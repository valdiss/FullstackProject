<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * Constructor
     */
    public function __construct($shoppingList, $category, $name, $quantity)
    {
      $this->setShoppingList($shoppingList);
      $this->setCategory($category);
      $this->setName($name);
      $this->setQuantity($quantity);
      $this->setBought(false);
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
   * @var string
   *
   * @ORM\Column(name="Name", type="string", length=255)
   */
  private $name;

  /**
   * @var int
   *
   * @ORM\Column(name="Quantity", type="integer")
   */
  private $quantity;

  /**
   * @var bool
   *
   * @ORM\Column(name="Bought", type="boolean")
   */
  private $bought;


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
   * Set quantity
   *
   * @param integer $quantity
   *
   * @return Product
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }

  /**
   * Get quantity
   *
   * @return int
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Set bought
   *
   * @param boolean $bought
   *
   * @return Product
   */
  public function setBought($bought)
  {
    $this->bought = $bought;

    return $this;
  }

  /**
   * Get bought
   *
   * @return bool
   */
  public function getBought()
  {
    return $this->bought;
  }



  /**
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   */
  private $category;

  /**
   * @ORM\ManyToOne(targetEntity="ShoppingList", inversedBy="products")
   * @ORM\JoinColumn(name="shoppinglist_id", referencedColumnName="id")
   */
  private $shoppinglist;

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set shoppinglist
     *
     * @param \AppBundle\Entity\ShoppingList $shoppinglist
     *
     * @return Product
     */
    public function setShoppinglist(\AppBundle\Entity\ShoppingList $shoppinglist = null)
    {
        $this->shoppinglist = $shoppinglist;

        return $this;
    }

    /**
     * Get shoppinglist
     *
     * @return \AppBundle\Entity\ShoppingList
     */
    public function getShoppinglist()
    {
        return $this->shoppinglist;
    }
}
