<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Classes\Tranche;

/**
 * Tranche Test Cases
 *
 * @author Andrew Nicholson (22 October 2020)
 */
final class TrancheTest extends TestCase
{
    /**
     * Tests we can create a Tranche Object
     * 
     * @return void
     */
    public function testTrancheInstance(): void
    {
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $this->assertInstanceOf(Tranche::class, $trancheA);
    }

    /**
     * Tests we can get a Tranche Name
     * 
     * @return void
     */
    public function testTrancheName(): void
    {
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $this->assertEquals("Tranche A", $trancheA->getName());
    }

    /**
     * Tests we can get a Tranche Interest
     * 
     * @return void
     */
    public function testInterestRate(): void
    {
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $this->assertEquals(3, $trancheA->getInterest());
    }

    /**
     * Tests we can deduct an amount and get expected available amount
     * Note values are multiplied by factor 100 upon instantiation
     * 
     * @return void
     */
    public function testDeductAmount(): void
    {
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $trancheA->deductAmount(40000);
        $this->assertEquals(60000, $trancheA->getAvailableAmount());
    }

    /**
     * Tests we can get the original available amount even after deducting something
     * Note values are multiplied by factor 100 upon instantiation
     * 
     * @return void
     */
    public function testGetOriginalAvailableAmount(): void
    {
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $trancheA->deductAmount(40000);
        $this->assertEquals(100000, $trancheA->getOriginalAvailableAmount());
    }
}