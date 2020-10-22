<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Investor Class
 * Contains name and available wallet amount attributes.
 * 
 * @author Andrew Nicholson (22 October 2020)
 */
class Investor
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $walletAmount;

    /**
     * Investor constructor, sets the name and wallet amount to 
     *  £1000 to start with 
     * @param string $name
     */
    public function __construct(string $name) {
        $this->walletAmount = 100000;
        $this->name = $name;
    }

    /**
     * Method to deduct the wallet amount
     * 
     * @param int $amount
     * 
     * @return void
     */
    public function deductAmount(int $amount) : void
    {
        $this->walletAmount -= $amount;
    }

    /**
     * Name getter
     * 
     * @return string
     */
    public function getName() : string 
    {
        return $this->name;
    }

    /**
     * Wallet Amount getter
     * 
     * @return int
     */
    public function getWalletAmount() : int 
    {
        return $this->walletAmount;
    }
}