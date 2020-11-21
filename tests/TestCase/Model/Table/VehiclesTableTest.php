<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VehiclesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VehiclesTable Test Case
 */
class VehiclesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VehiclesTable
     */
    protected $Vehicles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Vehicles',
        'app.Registrations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Vehicles') ? [] : ['className' => VehiclesTable::class];
        $this->Vehicles = $this->getTableLocator()->get('Vehicles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Vehicles);

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
