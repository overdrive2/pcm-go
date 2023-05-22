<?php

namespace App\Http\Livewire\Traits;

trait CashOrderDetails
{
    public function addCart($product): void
    {
        $cart = $this->getCart();
        array_push($cart['products'], $product);
        $this->setCart($cart);
    }

    public function clearCart(): void
    {
        $this->setCart($this->emptyCart());
    }

    public function emptyCart(): array
    {
        return [
            'products' => [],
        ];
    }

    public function getCart(): ?array
    {
        return session()->get('cart');
    }

    private function setCart($cart): void
    {
        session()->put('cart', $cart);
    }

}
