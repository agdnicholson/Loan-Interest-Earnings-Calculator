<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Classes\Investment;
use App\Classes\Investor;
use App\Classes\Tranche;
use App\Classes\Loan;
use App\Classes\InvestmentManager;

/**
 * Investment Manager Test Cases
 *
 * @author Andrew Nicholson (22 October 2020)
 */
final class InvestmentManagerTest extends TestCase
{
    /**
     * Tests we can create an Investment Manager Object
     * 
     * @return void
     */
    public function testInvestmentManagerInstance(): void
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $investmentManager = new InvestmentManager($loan);
        $this->assertInstanceOf(InvestmentManager::class, 
            $investmentManager);
    }

    /**
     * Tests we can create an investment and retrieve it if the amount and 
     *  date constraints pass.
     * 
     * @return void
     */
    public function testInvestmentManagerSuccessfulInvestment(): void
    {
        $loan = new Loan("2020-10-01", "2020-11-15");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $loan->addTranche($trancheA);
        $investor1 = new Investor("Investor 1");

        $investmentManager = new InvestmentManager($loan);
        $investmentManager->makeInvestment("2020-10-03", $trancheA, $investor1, 1000);

        $investment = new Investment(
            $investor1,
            $trancheA,
            100000, 
            "2020-10-03"
        );

        $this->assertEquals([$investment], 
            $investmentManager->getInvestments());
    }


    /**
     * Tests we cannot create an investment and retrieve it if the amount 
     *  constraint does not pass.
     * 
     * @return void
     */
    public function testInvestmentManagerInvestmentErrorAmount(): void
    {
        $loan = new Loan("2020-10-01", "2020-11-15");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $loan->addTranche($trancheA);
        $investor1 = new Investor("Investor 1");

        $investmentManager = new InvestmentManager($loan);
        $investmentManager->makeInvestment("2020-10-03", $trancheA, $investor1, 2000);

        $this->assertEquals([], 
            $investmentManager->getInvestments());
    }

    /**
     * Tests we cannot create an investment and retrieve it if the date 
     *  constraint does not pass.
     * 
     * @return void
     */
    public function testInvestmentManagerInvestmentErrorDate(): void
    {
        $loan = new Loan("2020-10-01", "2020-11-15");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $loan->addTranche($trancheA);
        $investor1 = new Investor("Investor 1");

        $investmentManager = new InvestmentManager($loan);
        $investmentManager->makeInvestment("2020-09-03", $trancheA, $investor1, 1000);

        $this->assertEquals([], 
            $investmentManager->getInvestments());
    }

    /**
     * Tests many aspects of the Investment Manager Class
     * We expect an associative array with the following results:
     * Investor 1 => 28.06
     * Investor 3 => 21.29
     * 
     * @return void
     */
    public function testDemoTestCase(): void
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

        $month = 10;
        $year = 2020;

        $expectedAssociativeArr = [
            $investor1->getName() => 28.06,
            $investor3->getName() => 21.29
        ];
        $this->assertEquals($expectedAssociativeArr, 
            $investmentManager->getInterestEarned($month, $year));
    }
}