<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $person_id
 * @property string $dni
 * @property string $address
 * @property string $phone
 */
class Customer extends Entity
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
        'id',
        'name',
        'last_name',
        'dni' => true,
        'address' => true,
        'phone' => true,
    ];
}
