<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Classes\Loan;
use App\Classes\Tranche;

/**
 * Loan Test Cases
 *
 * @author Andrew Nicholson (22 October 2020)
 */
final class LoanTest extends TestCase
{
    /**
     * Tests we can create a Loan Object
     * 
     * @return void
     */
    public function testLoanInstance(): void
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $this->assertInstanceOf(Loan::class, $loan);
    }

    /**
     * Tests we can get the start date
     * 
     * @return void
     */
    public function testGetStartDate(): void 
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $this->assertEquals("2020-01-01", 
            $loan->getStartDate());
    }

    /**
     * Tests we can get the end date
     * 
     * @return void
     */
    public function testGetEndDate(): void 
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $this->assertEquals("2020-05-05", 
            $loan->getEndDate());
    }

    /**
     * Tests we can add and retrieve a Tranche on the loan
     */
    public function testAddTranche(): void 
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $loan->addTranche($trancheA);
        $this->assertEquals($trancheA, $loan->getTranche("Tranche A"));
    }

    /**
     * Tests we can retrieve all Tranches from the loan
     */
    public function testGetAllTranches(): void 
    {
        $loan = new Loan("2020-01-01", "2020-05-05");
        $trancheA = new Tranche("Tranche A", 3, 1000);
        $trancheB = new Tranche("Tranche B", 6, 1000);
        $loan->addTranche($trancheA);
        $loan->addTranche($trancheB);
        $this->assertEquals([
            "Tranche A" => $trancheA, "Tranche B" => $trancheB], 
            $loan->getAllTranches());
    }
}