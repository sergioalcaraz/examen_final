<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillDetailsFixture
 */
class BillDetailsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'bill_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'part_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'details' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_520_ci', 'comment' => '', 'precision' => null],
        'amount' => ['type' => 'decimal', 'length' => 16, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'bill_id' => ['type' => 'index', 'columns' => ['bill_id'], 'length' => []],
            'part_id' => ['type' => 'index', 'columns' => ['part_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'bill_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['part_id'], 'references' => ['parts', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'bill_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['bill_id'], 'references' => ['bills', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'id' => 1,
                'bill_id' => 1,
                'part_id' => 1,
                'details' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
            ],
        ];
        parent::init();
    }
}
