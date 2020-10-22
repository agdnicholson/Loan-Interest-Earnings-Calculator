<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Tranche class
 * Contains the details of a tranche (name, interest rate, available amount)
 * We can also store the original available amount in case that needs to be
 *  retrieved at some point.
 * 
 * @author Andrew Nicholson (22 October 2020)
 */
class Tranche
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $interest;

    /**
     * @var int
     */
    protected $availableAmount;

    /**
     * @var int
     */
    protected $originalAvailableAmount;

    /**
     * Tranche constructor which sets the name, interest rate and 
     *  available amount.
     * We purposefully make the interest rate input flexible so that we can accepts
     *  integer or float values (always cast to float).
     * 
     * @param string $name
     * @param float|null $interest
     * @param int $availableAmount
     */
    public function __construct(string $name, ?float $interest, int $availableAmount) {
        $this->name = $name;
        $this->interest = floatval($interest);
        $this->availableAmount = $availableAmount * 100;
        $this->originalAvailableAmount = $availableAmount * 100;
    }

    /**
     * Tranche name / reference getter
     * 
     * @return string
     */
    public function getName() : string 
    {
        return $this->name;
    }

    /**
     * Interest rate getter
     * 
     * @return float
     */
    public function getInterest() : float 
    {
        return $this->interest;
    }

    /**
     * Method to deduct amount from the available amount of this tranche
     * 
     * @param int $amount
     * 
     * @return void
     */
    public function deductAmount(int $amount) : void
    {
        $this->availableAmount -= $amount;
    } 

    /**
     * Available amount getter
     * 
     * @return int
     */
    public function getAvailableAmount() : int 
    {
        return $this->availableAmount;
    }

    /**
     * Original available amount getter
     * 
     * @return int
     */
    public function getOriginalAvailableAmount() : int 
    {
        return $this->originalAvailableAmount;
    }
}