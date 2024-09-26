<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orderItems = [];
        foreach ($this->resource->orderDto->orderItems as $orderItem){
            $productInfo = $orderItem->product;
            $orderItems[] = $orderItem->toArray();
        }
        return [
            'cart' => [
                'id' => $this->resource->cartDto->id,
                'itemCount' => $this->resource->cartDto->itemCount,
                'itemQty' => $this->resource->cartDto->itemQty,
                'priceTotal' => $this->resource->cartDto->priceTotal,
                'basePriceTotal' => $this->resource->cartDto->basePriceTotal,
                'grandTotal' => $this->resource->cartDto->grandTotal,
                'baseGrandTotal' => $this->resource->cartDto->baseGrandTotal,
                'discountTotal' => $this->resource->cartDto->discountTotal,
            ],

            'customer' => [
                'id' => $this->resource->customerDto->id,
                'phone' => $this->resource->customerDto->phone,
                'email' => $this->resource->customerDto->email,
                'name' => $this->resource->customerDto->name,
                'lastname' => $this->resource->customerDto->lastname,
                'middlename' => $this->resource->customerDto->middlename,
                'county' => $this->resource->customerDto->county,
            ],

            'order' => [
                'id' => $this->resource->orderDto->id,
                'itemCount' => $this->resource->orderDto->itemCount,
                'itemQty' => $this->resource->orderDto->itemQty,
                'priceTotal' => $this->resource->orderDto->priceTotal,
                'basePriceTotal' => $this->resource->orderDto->basePriceTotal,
                'grandTotal' => $this->resource->orderDto->grandTotal,
                'baseGrandTotal' => $this->resource->orderDto->baseGrandTotal,
                'discountTotal' => $this->resource->orderDto->discountTotal,
                'deliveryPrice' => $this->resource->orderDto->deliveryPrice,
                'baseDeliveryPrice' => $this->resource->orderDto->baseDeliveryPrice,
                #'locality' => $this->resource->orderDto->locality,
                #'localityFias' => $this->resource->orderDto->localityFias,
                'deliveryObtaing' => $this->resource->orderDto->deliveryObtaing,
                'addressId' => $this->resource->orderDto->addressId,
                #'addressTitle' => $this->resource->orderDto->addressTitle,
                'deliveryService' => $this->resource->orderDto->deliveryService,
                'paymentMethodId' => $this->resource->orderDto->paymentMethodId,
                'comment' => $this->resource->orderDto->comment,
                'city' => $this->resource->orderDto->city,
                'payment' => $this->resource->orderDto->payment,
                'orderItems' => $orderItems,
            ],
        ];
    }
}
