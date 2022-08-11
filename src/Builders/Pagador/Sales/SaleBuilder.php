<?php

namespace Braspag\Builders\Pagador\Sales;

use Braspag\Entities\Pagador\Address;
use Braspag\Entities\Pagador\Customer;
use Braspag\Entities\Pagador\Payment\Payment;
use Braspag\Entities\Pagador\Sale;
use Braspag\Exceptions\BraspagBuilderException;

class SaleBuilder
{
    /**
     * @var Payment
     */
    protected Payment $payment;

    /**
     * @var Customer|null
     */
    private ?Customer $customer = null;

    /**
     * @var string|null
     */
    private ?string $merchantOrderId = null;

    /**
     * @param Customer $customer
     * @return $this
     */
    public function withCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @param Address|null $address
     * @return $this
     */
    public function withCustomerAddress(?Address $address): self
    {
        $this->customer->Address = $address;
        return $this;
    }

    /**
     * @param Address|null $address
     * @return $this
     */
    public function withCustomerDeliveryAddress(?Address $address): self
    {
        $this->customer->DeliveryAddress = $address;
        return $this;
    }

    /**
     * @param string $merchantOrderId
     * @return $this
     */
    public function withMerchantOrderId(string $merchantOrderId): self
    {
        $this->merchantOrderId = $merchantOrderId;
        return $this;
    }

    /**
     * @return Sale
     * @throws BraspagBuilderException
     */
    public function get(): Sale
    {
        if (is_null($this->customer)) {
            throw new BraspagBuilderException('Customer');
        }

        if (is_null($this->merchantOrderId)) {
            throw new BraspagBuilderException('Merchant Order');
        }

        return new Sale($this->customer, $this->payment, $this->merchantOrderId);
    }
}
