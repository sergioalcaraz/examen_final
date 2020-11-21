<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mechanics Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsToMany $Registrations
 *
 * @method \App\Model\Entity\Mechanic newEmptyEntity()
 * @method \App\Model\Entity\Mechanic newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Mechanic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mechanic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mechanic findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Mechanic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mechanic[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mechanic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mechanic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mechanic[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mechanic[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mechanic[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Mechanic[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MechanicsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('mechanics');
        $this->setDisplayField('person_id');
        $this->setPrimaryKey('person_id');

        $this->hasOne('People')
            ->setProperty('person')
            ->setForeignKey('id')
            ->setBindingKey('person_id');

        $this->belongsToMany('Registrations', [
            'foreignKey' => 'person_id',
            'targetForeignKey' => 'registration_id',
            'joinTable' => 'mechanics_registrations',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('person_id')
            ->allowEmptyString('person_id', null, 'create');

        $validator
            ->boolean('is_idle')
            ->notEmptyString('is_idle');

        return $validator;
    }
}
