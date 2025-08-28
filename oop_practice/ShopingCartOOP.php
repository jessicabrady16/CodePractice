<?php


/**
 * Interface for Cart functionality.
 */
interface cartInterface
{
  public function addProduct(Product $product): void;
  public function total(): float;
  public function checkoutUrl(): string;
}

/**
 * Represents a cart that can hold multiple products and return a cart total.
 */
class Cart implements cartInterface
{
  /** List of products in cart. */
  private array $itemList;
  /** Running total as products enter cart. */
  private float $total;


  public function __construct()
  {
    $this->itemList = [];
    $this->total = 0.00;
  }

  /** Add a product to cart and update the total. */
  public function addProduct(Product $product): void
  {

    $this->total += $product->getTotal();
    $this->itemList[] = $product;
  }

  /** Return cart total (unformatted float). */
  public function total(): float
  {
    return $this->total;
  }

  /** Return cart total formatted to 2 decimals. */
  public function totalFormatted(): string
  {
    return number_format($this->total(), 2, '.', '');
  }


  /** Display all products in the cart with details. */
  public function listProducts(): string
  {
    $output = "<ul>";
    foreach ($this->itemList as $product) {
      $output .= "<li>"
        . htmlspecialchars($product->getName())
        . " - $" . number_format($product->getPrice(), 2)
        . " x " . $product->getQuantity()
        . " = $" . $product->getTotalFormatter()
        . "</li>";
    }
    $output .= "</ul>";
    return $output;
  }

  public function checkoutURL(): string
  {
    return 'https://www.instaProduct.com';
  }
}

/** Represents a purchasable item. */
class Product
{

  private string $name;
  private float $price;
  private int $quantity;

  public function __construct(string $name, float $price, int $quantity)
  {
    $this->name = $name;
    $this->price = $price;
    $this->quantity = $quantity;
  }

  // getters used by Cart::listProducts().
  public function getName(): string
  {
    return $this->name;
  }
  public function getPrice(): float
  {
    return $this->price;
  }
  public function getQuantity(): int
  {
    return $this->quantity;
  }

  /** Return total cost of this product (price * quantity). */
  public function getTotal(): float
  {

    return ($this->price && $this->quantity)
      ?    $this->price * $this->quantity
      : 0.00;
  }

  /** Return total cost formatted as currency string */
  public function getTotalFormatter(): string
  {
    return number_format($this->getTotal(), 2, '.', '');
  }
}



/** Example usage */
$cart = new Cart();

$product1 = new Product("Knife", 2.58, 2);
$cart->addProduct($product1);

$product2 = new Product("Stick", 5.11, 4);
$cart->addProduct($product2);

// Cart items
echo "<h3>Cart Items:</hr>";
echo $cart->listProducts();

// Output Cart Total
echo "<strong>Cart Total: $" . $cart->totalFormatted() . "</strong><br/>";

// Check out link 
echo "<br/><a href='{$cart->checkoutURL()}' > Click Here To Proceed To Checkout</a>";


/**
 * Objectives 
 * 1. Add products to cart
 * 2. Output individual product totals
 * 3. Output cart total
 * 4. Troubleshoot errors
 */
