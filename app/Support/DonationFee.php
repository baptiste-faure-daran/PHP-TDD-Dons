<?php

namespace App\Support;


use Mockery\Exception;

class DonationFee
{

    private $donation;
    private $commissionPercentage;
    private const FixedFee = 50;

    public function __construct(int $donation, int $commissionPercentage)
    {
        if ($commissionPercentage < 0 || $commissionPercentage > 30 )
        {
            throw new Exception("Commission percentage invalid");
        }
        else $this->commissionPercentage = $commissionPercentage;

        if ($donation < 100)
        {
            throw new Exception("Donation number invalid");
        }
        else $this->donation = $donation;
    }

    public function getCommissionAmount()
    {
        return $this->donation * $this->commissionPercentage / 100;
    }

    public function getAmountCollected()
    {
        return $this->donation - $this->getCommissionAmount();
    }

    public function getFixedAndCommissionFeeAmount()
    {
        $total = self::FixedFee+$this->getCommissionAmount();
        if ($total>500)
        {
            $total=500;
        }
        return $total;
    }

}