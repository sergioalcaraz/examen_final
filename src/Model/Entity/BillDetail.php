<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillDetail Entity
 *
 * @property int $id
 * @property int $bill_id
 * @property int|null $part_id
 * @property string $details
 * @property string $amount
 *
 * @property \App\Model\Entity\Bill $bill
 * @property \App\Model\Entity\Part $part
 */
class BillDetail extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'bill_id' => true,
        'part_id' => true,
        'details' => true,
        'amount' => true,
        'bill' => true,
        'part' => true,
    ];
}
