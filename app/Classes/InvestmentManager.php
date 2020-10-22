<?php
declare(strict_types=1);

namespace App\Classes;

use App\Classes\Loan;
use App\Classes\Investment;
use App\Classes\Tranche;
use App\Classes\Investor;

/**
 * Investment Manager class
 * Does the heavy lifting of organising the investments.
 * It checks these can be made and adds them in an array to keep track of.
 * The class also contains the interest calculation method.
 * To minimise rounding and since no calculations happen in associated classes we
 *  can multiply amounts by 100 and when returned divide them by 100 so that the
 *  associated classes can simply deal with integers.
 * 
 * @author Andrew Nicholson (22 October 2020)
 */
class InvestmentManager
{
    /**
     * @var Loan
     */
    protected $loan;

    /**
     * @var array
     */
    protected $investments;
    
    /**
     * Investment Manager constructor
     * 
     * @param Loan $loan
     */
    public function __construct(Loan $loan) {
        $this->loan = $loan;
        $this->investments = [];
    }

    /**
     * Make investment method. Calls a private
     *  method to check whether investment can be made.
     * This method returns false if that fails and 
     *  true if it is possible and then adds the investment
     *  to the investment array of this instance.
     * Allow input to accept integer or floats but we multiply it
     *  by 100 and cast as integer.
     * @param string $date (Y-m-d)
     * @param Tranche $tranche
     * @param Investor $investor
     * @param float|null $amount
     * 
     * @return bool
     */
    public function makeInvestment(
        string $date,
        Tranche $tranche,
        Investor $investor,
        ?float $amount
    ) : bool {
        $amount = intval($amount * 100.00);
        if (! $this->canMakeInvestment(
                $date, 
                $tranche,
                $investor,
                $amount
            )) return FALSE;
        $investment = new Investment(
            $investor,
            $tranche,
            $amount, 
            $date
        );
        $this->investments[] = $investment;
        
        return TRUE;
    }

    /**
     * Protected method that can check whether we can make an investment.
     * That will be based on the amount of the investment, the available amount
     *  of the loan and the available funds of an investor.
     * We also check if the tranche is associated with this loan
     * Returns True or False
     * 
     * @param string $date (Y-m-d)
     * @param Tranche $tranche
     * @param Investor $investor
     * @param int $amount
     * 
     * @return bool
     */
    protected function canMakeInvestment(
        string $date,
        Tranche $tranche,
        Investor $investor,
        int $amount
    ) : bool {
        //check date
        if ((strtotime($date) >= 
            strtotime($this->loan->getEndDate())) ||
            strtotime($date) < strtotime($this->loan->getStartDate())) {
            return FALSE;
        }

        //check tranche 
        if($this->loan->getTranche($tranche->getName()) != $tranche) {
            return FALSE;
        }

        //check investor amount
        if ($amount > $investor->getWalletAmount()) {
            return FALSE;
        }

        //check available tranche amount
        if ($amount > $tranche->getAvailableAmount()) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Method to return the investments added to this investment manager instance
     * 
     * @return array
     */
    public function getInvestments() : array 
    {
        return $this->investments;
    }

    /**
     * Method to calculate and return the interest earned for a certain month.
     * It will consider the beginning 
     * @param int $month
     * @param int $year
     * 
     * @return array
     */
    public function getInterestEarned(int $month, int $year) : array 
    {
        $interestArr = [];

        //we need to know the days of this month.
        $daysInMonth = intval(date('t', mktime(0, 0, 0, $month, 1, $year))); 

        //create our dates
        $month = str_pad(strval($month), 2, "0", STR_PAD_LEFT);
        $year = strval($year);
        $begin = date($year.'-'.$month.'-01');
        $end = date($year.'-'.$month.'-'.strval($daysInMonth));
 
        /**
         * If the loan ends before the end of the month we need to calculate
         *  the fraction of the month we want to calculate the interest of.
         */
        $calcFraction = 1;
        if ($this->loan->getEndDate() < $end || 
            $this->loan->getStartDate() > $begin) {
            if ($this->loan->getEndDate() < $end) $end = $this->loan->getEndDate();
            if ($this->loan->getStartDate() > $begin) $begin = $this->loan->getStartDate();
            $calcFraction = $this->getDaysFraction($daysInMonth, $begin, $end);
        }

        //no interest if loan start > end or if loan start date is after end period
        if (strtotime($this->loan->getStartDate()) > strtotime($end) || 
            strtotime($begin) > strtotime($this->loan->getEndDate())) {
            foreach($this->investments as $investment) {
                $interestArr[$investment->getInvestor()->getName()] = 0;
            }
        } else {
            //iterate through the investments and calculate any interest and add it to the return array
            foreach($this->investments as $investment) {
                /**
                 * If the investment date was made after the begin date of this period
                 *  we need to adjust the calcFraction.
                 */
                if (strtotime($investment->getDate()) > strtotime($begin)) {
                    $calcFraction = $this->getDaysFraction($daysInMonth, 
                        $investment->getDate(), $end);
                }

                //calculate the interest amount
                $thisAmount = ($calcFraction * 
                    $investment->getAmount() * 
                    ($investment->getTranche()->getInterest() / 100)) / 100;

                /**
                 * We use the name of the investor as key. If the investor has multiple
                 *  investments we just add them together.
                 */ 
                if (array_key_exists(
                    $investment->getInvestor()->getName(), $interestArr)) {
                    $interestArr[$investment->getInvestor()->getName()] += $thisAmount;
                } else {
                    $interestArr[$investment->getInvestor()->getName()] = $thisAmount;
                }
            }
            //rounding
            foreach($interestArr as $investorName => $interest) {
                $interestArr[$investorName] = round($interestArr[$investorName], 2);
            }
        }

        return $interestArr;
    }

    /**
     * Method to calculate the fraction of a month a certain period is. We need
     *  to pass the days of the month so that we can work out the difference in 
     *  days divided by num days in the month.  We also always add 1 day to the difference
     *  for proper interest fraction calculations.
     * 
     * @param int $daysInMonth
     * @param string $begin (Y-m-d)
     * @param string $end (Y-m-d)
     * 
     * @return float
     */
    protected function getDaysFraction(int $daysInMonth, string $begin, string $end) : float {
        $diffDays = (strtotime($end) - 
            strtotime($begin)) / 60 / 60 / 24;
        $diffDays += 1;
        $calcFraction = $diffDays / $daysInMonth;
        return floatval($calcFraction);
    }
}
