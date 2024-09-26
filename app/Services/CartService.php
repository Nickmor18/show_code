<?php

namespace App\Services;

use App\Data\DTO\Cart\CartDto;
use App\Data\DTO\Cart\CreateCartDtoFactory;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\DB;

class CartService
{

    public function __construct(private CartRepository $cartRepository)
    {
    }

    /**
     * Метод возвращает актуальную корзину пользователя
     *
     * @param  Cart  $cart
     * @return Cart
     */
    public function getCustomerCart(Cart $cart): Cart
    {
        return $this->calculate($cart->id);
    }

    /**
     * Добавление/обновление товара в корзине
     *
     * @param  Cart  $cart
     * @param $productVariantId
     * @param $productMainId
     * @param $quantity
     *
     * @return Cart
     */
    public function setProductToCart(
        Cart $cart,
        $productMainId,
        $productVariantId,
        $quantity = 1
    ): Cart {
        $arIdsProductVariantsInCart = $cart->cartItems->pluck("variant_id")
            ->toArray();
        $variant = Product::find($productVariantId);

        if (in_array($productVariantId, $arIdsProductVariantsInCart)) {
            #устанавливаем значение товара в корзине у варианта на указанное
            DB::table('cart_items')
                ->where('cart_id', '=', $cart->id)
                ->where('variant_id', '=', $productVariantId)
                ->update([
                    'quantity' => $quantity,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'price' => $variant->price,
                    'base_price' => $variant->base_price,
                    'price_total' => $variant->price * $quantity,
                    'base_price_total' => $variant->base_price * $quantity,
                ]);
        } else {
            #создаем вариант товара в корзине с указанным значением
            DB::table('cart_items')
                ->insert([
                    'cart_id' => $cart->id,
                    'variant_id' => $productVariantId,
                    'product_main_id' => $productMainId,
                    'quantity' => $quantity,
                    'price' => $variant->price,
                    'base_price' => $variant->base_price,
                    'price_total' => $variant->price * $quantity,
                    'base_price_total' => $variant->base_price * $quantity,
                    'discount' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
        }

        return $this->calculate($cart->id);
    }

    /**
     * Удаление позиции из карт_итемов корзины
     *
     * @param  Cart  $cart
     * @param $productMainId
     * @param $productVariantId
     * @return Cart
     */
    public function deleteProductInCart(
        Cart $cart,
        $productMainId,
        $productVariantId
    ): Cart {
        DB::table('cart_items')
            ->where('cart_id', '=', $cart->id)
            ->where('product_main_id', '=', $productMainId)
            ->where('variant_id', '=', $productVariantId)
            ->delete();

        return $this->calculate($cart->id);
    }

    /**
     * Перерасчет стоимости корзины, обновление значений в таблице cart
     *
     * @param $cartId
     * @return Cart
     */
    public function calculate($cartId): Cart
    {
        $cart = Cart::find($cartId);

        #обновим карт_итемы с актуальными прайсами для товара
        $itemQty = 0;
        $basePriceTotal = 0;
        $priceTotal = 0;
        foreach ($cart->cartItems as $cartItem) {
            $itemQty += $cartItem->quantity;
            $itemPriceTotal = round($cartItem->quantity * floatval($cartItem->product->price));
            $priceTotal += $itemPriceTotal;
            $itemBasePriceTotal = round($cartItem->quantity * floatval($cartItem->product->base_price));
            $basePriceTotal += $itemBasePriceTotal;
            $arCartItemsData = [
                'id' => $cartItem->id,
                'price' => floatval($cartItem->product->price),
                'base_price' => floatval($cartItem->product->base_price),
                'price_total' => $itemPriceTotal,
                'base_price_total' => $itemBasePriceTotal,
            ];
            DB::table('cart_items')
                ->where('id', $cartItem->id)
                ->update($arCartItemsData);
        }

        //обновим информацию о корзине пользователя
        $baseGrandTotal = $basePriceTotal;
        $grandTotal = $priceTotal;
        $discountTotal = 0;
        $cart->item_count = $cart->cartItems->count();
        $cart->item_qty = $itemQty;
        $cart->base_price_total = $basePriceTotal;
        $cart->price_total = $priceTotal;
        $cart->base_grand_total = $baseGrandTotal;
        $cart->grand_total = $grandTotal;
        $cart->discount_total = $discountTotal;
        $cart->save();

        return $cart;
    }

}
