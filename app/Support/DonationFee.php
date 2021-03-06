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
        return $this->donation - $this->getFixedAndCommissionFeeAmount();
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

    public function getSummary()
    {
        $summary = array();
        $summary['Dotation']=$this->donation;
        $summary['Fixed Fee']=self::FixedFee;
        $summary['Commission']=$this->getCommissionAmount();
        $summary['Fixed And Commission']=$this->getFixedAndCommissionFeeAmount();
        $summary['Amount Collected']=$this->getAmountCollected();

        return $summary;

    }

}