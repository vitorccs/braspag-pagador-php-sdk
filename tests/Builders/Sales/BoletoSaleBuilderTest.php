<?php

namespace Braspag\Test\Builders\Sales;

use Braspag\Builders\Pagador\CustomerBuilder;
use Braspag\Builders\Pagador\Sales\BoletoSaleBuilder;
use Braspag\Entities\Pagador\Payment\BoletoPayment;
use Braspag\Helpers\DateTimeHelper;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class BoletoSaleBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validBoletoSale
     */
    public function teste_create_boleto(array $properties)
    {
        $merchantOrderId = $properties['MerchantOrderId'];
        $customerProps = $properties['Customer'];
        $paymentProps = $properties['Payment'];

        $customer = CustomerBuilder::create($customerProps['Name'])->get();

        $sale = BoletoSaleBuilder::create($paymentProps['Provider'], $paymentProps['Amount'])
            ->withMerchantOrderId($merchantOrderId)
            ->withCustomer($customer)
            ->setBoletoNumber($paymentProps['BoletoNumber'])
            ->setAssignor($paymentProps['Assignor'])
            ->setDemonstrative($paymentProps['Demonstrative'])
            ->setExpirationDate($paymentProps['ExpirationDate'])
            ->setIdentification($paymentProps['Identification'])
            ->setInstructions($paymentProps['Instructions'])
            ->setNullifyDays($paymentProps['NullifyDays'])
            ->setDaysToFine($paymentProps['DaysToFine'])
            ->setFineRate($paymentProps['FineRate'])
            ->setFineAmount($paymentProps['FineAmount'])
            ->setDaysToInterest($paymentProps['DaysToInterest'])
            ->setInterestRate($paymentProps['InterestRate'])
            ->setInterestAmount($paymentProps['InterestAmount'])
            ->setDiscountAmount($paymentProps['DiscountAmount'])
            ->setDiscountLimitDate($paymentProps['DiscountLimitDate'])
            ->setDiscountRate($paymentProps['DiscountRate'])
            ->get();

        if ($paymentProps['ExpirationDate'] instanceof \DateTime) {
            $paymentProps['ExpirationDate'] = DateTimeHelper::toDateString($paymentProps['ExpirationDate']);
        }

        if ($paymentProps['DiscountLimitDate'] instanceof \DateTime) {
            $paymentProps['DiscountLimitDate'] = DateTimeHelper::toDateString($paymentProps['DiscountLimitDate']);
        }

        $objPayment = $this->fillObject(
            new BoletoPayment($paymentProps['Provider'], $paymentProps['Amount']),
            $paymentProps,
        );

        $this->assertEquals($sale->Payment, $objPayment);
        $this->assertEquals($sale->MerchantOrderId, $merchantOrderId);
    }
}
