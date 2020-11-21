<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MechanicsRegistrationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MechanicsRegistrationsTable Test Case
 */
class MechanicsRegistrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MechanicsRegistrationsTable
     */
    protected $MechanicsRegistrations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MechanicsRegistrations',
        'app.Registrations',
        'app.People',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MechanicsRegistrations') ? [] : ['className' => MechanicsRegistrationsTable::class];
        $this->MechanicsRegistrations = $this->getTableLocator()->get('MechanicsRegistrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MechanicsRegistrations);

        parent::tearDown();
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
