<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillDetailsTable Test Case
 */
class BillDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillDetailsTable
     */
    protected $BillDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.BillDetails',
        'app.Bills',
        'app.Parts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BillDetails') ? [] : ['className' => BillDetailsTable::class];
        $this->BillDetails = $this->getTableLocator()->get('BillDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BillDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
