<?php
declare(strict_types=1);

namespace App\Classes;

use App\Classes\Tranche;

/**
 * Loan class, contains start and end dates and the 
 *  available Tranches for this loan
 * 
 * @author Andrew Nicholson (22 October 2020)
 */
class Loan
{
    /**
     * @var string
     */
    protected $startDate;

    /**
     * @var string
     */
    protected $endDate;

    /**
     * @var Tranche
     */
    protected $tranches;

    /**
     * Loan constructor. Sets the dates and initiates the tranches array
     * 
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tranches = [];
    }

    /**
     * Adds a tranche to this loan
     * 
     * @param Tranche $tranche
     * 
     * @return void
     */
    public function addTranche(Tranche $tranche) : void 
    {
        if(!array_key_exists($tranche->getName(), $this->tranches)) {
            $this->tranches[$tranche->getName()] = $tranche;
        }
    }

    /**
     * Start date getter
     * 
     * @return string
     */
    public function getStartDate() : string 
    {
        return $this->startDate;
    }

    /**
     * End date getter 
     * 
     * @return string
     */
    public function getEndDate() : string 
    {
        return $this->endDate;
    }

    /**
     * Returns the associated tranche based on the tranche reference 
     *  if this loan contains it. If not null is returned.
     * 
     * @param string $trancheRef
     * 
     * @return Tranche|null
     */
    public function getTranche(string $trancheRef) : ?Tranche
    {
        return array_key_exists($trancheRef, $this->tranches) ?
            $this->tranches[$trancheRef] : null;
    }

    /**
     * Returns all tranches of this loan
     * 
     * @return array
     */
    public function getAllTranches() : array 
    {
        return $this->tranches;
    }
}