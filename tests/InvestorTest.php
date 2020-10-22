<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Classes\Investor;

/**
 * Investor Test Cases
 *
 * @author Andrew Nicholson (22 October 2020)
 */
final class InvestorTest extends TestCase
{
    /**
     * Tests we can create an Investor Object
     * 
     * @return void
     */
    public function testInvestorInstance(): void
    {
        $investor1 = new Investor("Investor 1");
        $this->assertInstanceOf(Investor::class, $investor1);
    }

    /**
     * Tests we can get the Investor Name
     * 
     * @return void
     */
    public function testInvestorName(): void
    {
        $investor1 = new Investor("Investor 1");
        $this->assertEquals("Investor 1", $investor1->getName());
    }

    /**
     * Tests we can deduct wallet amount and have expected amount left
     * 
     * @return void
     */
    public function testWalletAmount(): void
    {
        $investor1 = new Investor("Investor 1");
        $investor1->deductAmount(77000);
        $this->assertEquals(23000, $investor1->getWalletAmount());
    }
}