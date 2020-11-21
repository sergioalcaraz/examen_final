<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $entry_date
 * @property int $person_id
 * @property int $vehicle_id
 *
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\Vehicle $vehicle
 * @property \App\Model\Entity\Mechanic[] $mechanics
 */
class Registration extends Entity
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
        'entry_date' => true,
        'person_id' => true,
        'vehicle_id' => true,
        'person' => true,
        'vehicle' => true,
        'mechanics' => true,
    ];
}
