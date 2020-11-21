<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MechanicsRegistrationsFixture
 */
class MechanicsRegistrationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'registration_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'person_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'person_id' => ['type' => 'index', 'columns' => ['person_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['registration_id', 'person_id'], 'length' => []],
            'mechanics_registrations_ibfk_2' => ['type' => 'foreign', 'columns' => ['person_id'], 'references' => ['mechanics', 'person_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mechanics_registrations_ibfk_1' => ['type' => 'foreign', 'columns' => ['registration_id'], 'references' => ['registrations', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_520_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'registration_id' => 1,
                'person_id' => 1,
            ],
        ];
        parent::init();
    }
}
