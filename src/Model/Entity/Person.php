<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 *
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Mechanic[] $mechanics
 * @property \App\Model\Entity\MechanicsRegistration[] $mechanics_registrations
 * @property \App\Model\Entity\Registration[] $registrations
 * @property \App\Model\Entity\User[] $users
 */
class Person extends Entity
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
        'name' => true,
        'last_name' => true,
        'customers' => true,
        'mechanics' => true,
        'mechanics_registrations' => true,
        'registrations' => true,
        'users' => true,
    ];
}
