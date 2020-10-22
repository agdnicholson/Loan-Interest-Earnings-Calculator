<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Classes\Loan;
use App\Classes\Tranche;
use App\Classes\Investor;
use App\Classes\InvestmentManager;

use App\Classes\Investment;
/**
 *  IndexController for home page
 */
class Index extends Controller
{
    /**
     * Index Controller / Home
     */
    public function index()
    {   
        //Set up our loan with time period.
        $loan = new Loan("2020-10-01", "2020-11-15");

        //Set up the tranches with name, interest rates & available amount
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $trancheB = new Tranche("Tranche B", 6, 1000);

        //add the tranches to this loan
        $loan->addTranche($trancheA);
        $loan->addTranche($trancheB);

        //Create our 4 investors
        $investor1 = new Investor("Investor 1");
        $investor2 = new Investor("Investor 2");
        $investor3 = new Investor("Investor 3");
        $investor4 = new Investor("Investor 4");

        //Create the investment manager instance
        $investmentManager = new InvestmentManager($loan);

        /**
         * Try to make the investments, if they fail they will return a FALSE value
         * and are not added to the investment manager instance.
         */
        $investmentManager->makeInvestment("2020-10-03", $trancheA, $investor1, 1000);
        $investmentManager->makeInvestment("2020-10-04", $trancheA, $investor2, 100);
        $investmentManager->makeInvestment("2020-10-10", $trancheB, $investor3, 500);
        $investmentManager->makeInvestment("2020-10-25", $trancheB, $investor4, 1100);
        
        //Simple calculation to get last month as integers in month and year
        if(intval(date('j')) === 1) {
            $month = 12; $year = intval(date('Y')) - 1;
        } else {
            $month = intval(date('n')) - 1; $year = intval(date('Y'));
        }

        //although we are feeding in static details for sake of the demonstration so overwrite.
        $month = 10;
        $year = 2020;
        $monthStr = date("F", strtotime(strval($year).'-'.strval($month).'-01'));

        //get the interest amounts earned for October 2020 and push to view.
        return view('index', ["monthStr" => $monthStr, "year" => $year,
            "interestAmounts" => $investmentManager->getInterestEarned($month, $year)]);
    }
}