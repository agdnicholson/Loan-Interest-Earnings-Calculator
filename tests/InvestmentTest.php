<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Classes\Investment;
use App\Classes\Investor;
use App\Classes\Tranche;

/**
 * Investment Test Cases
 *
 * @author Andrew Nicholson (22 October 2020)
 */
final class InvestmentTest extends TestCase
{
    /**
     * Tests we can create an Investment Object
     * 
     * @return void
     */
    public function testInvestmentInstance(): void
    {
        $investor1 = new Investor("Investor 1");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $investment = new Investment(
            $investor1,
            $trancheA,
            50000, 
            "2020-10-01"
        );
        $this->assertInstanceOf(Investment::class, $investment);
    }

    /**
     * Tests we can get an investor from an investment
     * 
     * @return void
     */
    public function testGetInvestor(): void
    {
        $investor1 = new Investor("Investor 1");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $investment = new Investment(
            $investor1,
            $trancheA,
            50000, 
            "2020-10-01"
        );
        $this->assertEquals($investor1, $investment->getInvestor());
    }

     /**
     * Tests we can get a tranche from an investment
     * 
     * @return void
     */
    public function testGetTranche(): void
    {
        $investor1 = new Investor("Investor 1");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $investment = new Investment(
            $investor1,
            $trancheA,
            50000, 
            "2020-10-01"
        );
        $this->assertEquals($trancheA, $investment->getTranche());
    }

     /**
     * Tests we can get the amount from an investment
     * 
     * @return void
     */
    public function testGetAmount(): void
    {
        $investor1 = new Investor("Investor 1");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $investment = new Investment(
            $investor1,
            $trancheA,
            50000, 
            "2020-10-01"
        );
        $this->assertEquals(50000, $investment->getAmount());
    }

     /**
     * Tests we can get the date from an investment
     * 
     * @return void
     */
    public function testGetDate(): void
    {
        $investor1 = new Investor("Investor 1");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $investment = new Investment(
            $investor1,
            $trancheA,
            50000, 
            "2020-10-01"
        );
        $this->assertEquals("2020-10-01", $investment->getDate());
    }
}