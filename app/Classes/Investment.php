<?php
declare(strict_types=1);

namespace App\Classes;

use App\Classes\Investor;
use App\Classes\Tranche;

/**
 * Investment class, keeps track of the associated investor, the tranche,
 *  the amount and the investment date.  
 * 
 * @author Andrew Nicholson (22 October 2020)
 */
class Investment
{
    /**
     * @var Investor
     */
    protected $investor;

    /**
     * @var Trance
     */
    protected $tranche;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var string (Y-m-d)
     */
    protected $date;

    /**
     * Investment constructor
     * 
     * @param Investor $investor
     * @param Tranche $tranche
     * @param int $amount
     * @param string $date
     */
    public function __construct(
        Investor $investor,
        Tranche $tranche,
        int $amount,
        string $date
    ) {
        $this->investor = $investor;
        $this->tranche = $tranche;
        $this->amount = $amount;
        $this->date = $date;
        $this->tranche->deductAmount($amount);
    }

    /**
     * Investor getter
     * 
     * @return Investor
     */
    public function getInvestor() : Investor 
    {
        return $this->investor;
    }

    /**
     * Investment Tranche getter
     * 
     * @return Tranche
     */
    public function getTranche() : Tranche 
    {
        return $this->tranche;
    }

    /**
     * Investment Amount getter
     * 
     * @return int
     */
    public function getAmount() : int 
    {
        return $this->amount;
    }

    /**
     * Investment date getter
     * 
     * @return string
     */
    public function getDate() : string 
    {
        return $this->date;
    }
}