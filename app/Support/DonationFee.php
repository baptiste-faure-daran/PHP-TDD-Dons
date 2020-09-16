<?php

namespace App\Support;


use Mockery\Exception;

class DonationFee
{

    private $donation;
    private $commissionPercentage;

    public function __construct(int $donation, int $commissionPercentage)
    {
        if ($commissionPercentage < 0 || $commissionPercentage > 30 )
        {
            throw new Exception("Commission percentage invalid");
        }
        else $this->commissionPercentage = $commissionPercentage;

        
    }

    public function getCommissionAmount()
    {
        return $this->donation * $this->commissionPercentage / 100;
    }

    public function getAmountCollected()
    {
        return $this->donation - $this->getCommissionAmount();
    }


}