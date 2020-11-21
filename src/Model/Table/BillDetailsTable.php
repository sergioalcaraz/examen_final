<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillDetails Model
 *
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\BelongsTo $Bills
 * @property \App\Model\Table\PartsTable&\Cake\ORM\Association\BelongsTo $Parts
 *
 * @method \App\Model\Entity\BillDetail newEmptyEntity()
 * @method \App\Model\Entity\BillDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BillDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\BillDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BillDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BillDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BillDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BillDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BillDetailsTable extends Table
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

        $this->setTable('bill_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bills', [
            'foreignKey' => 'bill_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Parts', [
            'foreignKey' => 'part_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('details')
            ->maxLength('details', 250)
            ->requirePresence('details', 'create')
            ->notEmptyString('details');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['bill_id'], 'Bills'), ['errorField' => 'bill_id']);
        $rules->add($rules->existsIn(['part_id'], 'Parts'), ['errorField' => 'part_id']);

        return $rules;
    }
}
