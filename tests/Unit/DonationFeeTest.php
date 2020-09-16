<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DonationFeeTest extends TestCase
{

    public function testCommissionAmountIs10CentsFormDonationOf100CentsAndCommissionOf10Percent()
    {
        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new \App\Support\DonationFee(100, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getCommissionAmount();

        // Alors la Valeur de la commission doit être de 10
        $expected = 10;
        $this->assertEquals($expected, $actual);
    }

    public function testCommissionAmountIs20CentsFormDonationOf200CentsAndCommissionOf10Percent()
    {
        // Etant donné une donation de 200 et commission de 10%
        $donationFees = new \App\Support\DonationFee(200, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getCommissionAmount();

        // Alors la Valeur de la commission doit être de 20
        $expected = 20;
        $this->assertEquals($expected, $actual);
    }

    public function testAmountCollectedIs180CentsFormDonationOf200CentsAndCommissionOf10Percent() {
        // GIVEN
        $donationFees = new \App\Support\DonationFee(200, 10);

        // WHEN
        $amountCollected = $donationFees->getAmountCollected();

        // THEN
        $expectedAmount= 130;
        $this->assertEquals($expectedAmount, $amountCollected);
    }

    public function testGetCommissionPercentage()
    {
        $this->expectException('Exception');

        $donationFees = new \App\Support\DonationFee(100, 31);
    }

    public function testDonationInf100()
    {
        $this->expectException('Exception');

        $donationFees = new \App\Support\DonationFee(99,10);
    }

    public function testMaximalTotalCommissionEquals500()
    {
        // GIVEN
        $donationFees = new \App\Support\DonationFee(10000,10);

        // WHEN
        $actual = $donationFees->getFixedAndCommissionFeeAmount();

        // THEN
        $expected= 500;
        $this->assertEquals($expected, $actual);
    }

    public function testArraySummary()
    {
        //GIVEN
        $donationFees = new \App\Support\DonationFee(1000,10);

        // WHEN
        $actual = $donationFees->getSummary();

        //THEN
        $expected = [
            'Dotation'=>1000,
            'Fixed Fee'=>50,
            'Commission'=>100,
            'Fixed And Commission'=> 150,
            'Amount Collected' => 850,
        ];
        $this->assertEquals($expected, $actual);
    }
}
