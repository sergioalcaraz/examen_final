<?php
declare(strict_types=1);

namespace App\Controller;

use PDOException;

/**
 * Mechanics Controller
 *
 * @property \App\Model\Table\MechanicsTable $Mechanics
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MechanicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $mechanics = $this->Mechanics->find()->contain([
            'People'
        ]);
        $mechanics = $mechanics->map(function ($mechanic)  {
            /** @var \App\Model\Entity\Person */
            // dump($mechanic);
            $person = $mechanic->person;
            $mechanic->id = $person->get('id');
            $mechanic->name = $person->get('name');
            $mechanic->last_name = $person->get('last_name');
            unset($mechanic->person);
            unset($mechanic->person_id);
            return $mechanic;
        })->toList();
        $this->set(compact('mechanics'));
        $this->viewBuilder()->setOption('serialize', ['mechanics']);

    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mechanic = $this->Mechanics->get($id);

        $this->set(compact('mechanic'));
        $this->viewBuilder()->setOption('serialize', ['mechanic']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $data = $this->request->getData();
        $person = $this->Mechanics->People->newEntity($data);
        $mechanic = $this->Mechanics->newEntity($data);

        $status = $this->Mechanics->getConnection()->transactional(function ($connection) use (&$person, &$mechanic) {
            if (!$this->Mechanics->People->save($person, ['atomic' => false])) {
                return false;
            }
            $mechanic->person_id = $person->id;
            if (!$this->Mechanics->save($mechanic, ['atomic' => false])) {
                return false;
            }

            return true;
        });
        if ($status) {
            $responseData['message'] = 'Se ha guardado.';
        } else {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se ha guardado.';

            if ($person->hasErrors()) {
                $responseData['error'] = $person->getErrors();
            } elseif ($mechanic->hasErrors()) {
                $responseData['error'] = $mechanic->getErrors();
            }
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message', 'error']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod('put');
        $data = $this->request->getData();
        $person = $this->Mechanics->People->get($id);
        $mechanic = $this->Mechanics->get($id);
        $person = $this->Mechanics->People->patchEntity($person, $data);
        $mechanic = $this->Mechanics->patchEntity($mechanic, $data);

        $status = $this->Mechanics->getConnection()->transactional(function ($connection) use (&$person, &$mechanic) {
            if (!$this->Mechanics->People->save($person, ['atomic' => false])) {
                return false;
            }
            if (!$this->Mechanics->save($mechanic, ['atomic' => false])) {
                return false;
            }

            return true;
        });
        if ($status) {
            $responseData['message'] = 'Se ha guardado.';
        } else {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se ha guardado.';

            if ($person->hasErrors()) {
                $responseData['error'] = $person->getErrors();
            } elseif ($mechanic->hasErrors()) {
                $responseData['error'] = $mechanic->getErrors();
            }
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message', 'error']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $mechanic = $this->Mechanics->get($id);
        try {
            $status = $this->Mechanics->getConnection()->transactional(function ($connection) use ($mechanic) {
                if (!$this->Mechanics->delete($mechanic, ['atomic' => false])) {
                    return false;
                }

                $person = $this->Mechanics->People->get($mechanic->person_id);
                if (!$this->Mechanics->People->delete($person, ['atomic' => false])) {
                    return false;
                }

                return true;
            });
            if ($status) {
                $responseData['message'] = 'Se ha eliminado.';
            } else {
                $this->setResponse($this->response->withStatus(400));
                $responseData['message'] = 'No se ha eliminado.';
            }
        } catch (PDOException $e) {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se puede eliminar existen registros dependientes.';
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

    public function assign()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();

        $mechanic = $this->Mechanics->find()
            ->where([
                $this->Mechanics->aliasField('is_idle') => true,
                $this->Mechanics->aliasField('person_id') => $data['person_id'],
            ])
            ->firstOrFail();

        $mechanicsRegistrationsTable = $this->getTableLocator()->get('MechanicsRegistrations');
        $registration = $mechanicsRegistrationsTable->newEmptyEntity();
        $registration->registration_id = $data['registration_id'];
        $registration->person_id = $data['person_id'];
        if ($mechanicsRegistrationsTable->save($registration)) {
            $mechanic->is_idle = false;
            $this->Mechanics->save($mechanic);
            $responseData['message'] = 'Se ha guardado.';
        } else {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se ha guardado.';
            $responseData['error'] = $registration->getErrors();
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message', 'error']);
    }
}