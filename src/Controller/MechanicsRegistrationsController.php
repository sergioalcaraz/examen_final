<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MechanicsRegistrations Controller
 *
 * @property \App\Model\Table\MechanicsRegistrationsTable $MechanicsRegistrations
 * @method \App\Model\Entity\MechanicsRegistration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MechanicsRegistrationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Registrations', 'People'],
        ];
        $mechanicsRegistrations = $this->paginate($this->MechanicsRegistrations);

        $this->set(compact('mechanicsRegistrations'));
    }

    /**
     * View method
     *
     * @param string|null $id Mechanics Registration id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mechanicsRegistration = $this->MechanicsRegistrations->get($id, [
            'contain' => ['Registrations', 'People'],
        ]);

        $this->set(compact('mechanicsRegistration'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mechanicsRegistration = $this->MechanicsRegistrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $mechanicsRegistration = $this->MechanicsRegistrations->patchEntity($mechanicsRegistration, $this->request->getData());
            if ($this->MechanicsRegistrations->save($mechanicsRegistration)) {
                $this->Flash->success(__('The mechanics registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mechanics registration could not be saved. Please, try again.'));
        }
        $registrations = $this->MechanicsRegistrations->Registrations->find('list', ['limit' => 200]);
        $people = $this->MechanicsRegistrations->People->find('list', ['limit' => 200]);
        $this->set(compact('mechanicsRegistration', 'registrations', 'people'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mechanics Registration id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mechanicsRegistration = $this->MechanicsRegistrations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mechanicsRegistration = $this->MechanicsRegistrations->patchEntity($mechanicsRegistration, $this->request->getData());
            if ($this->MechanicsRegistrations->save($mechanicsRegistration)) {
                $this->Flash->success(__('The mechanics registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mechanics registration could not be saved. Please, try again.'));
        }
        $registrations = $this->MechanicsRegistrations->Registrations->find('list', ['limit' => 200]);
        $people = $this->MechanicsRegistrations->People->find('list', ['limit' => 200]);
        $this->set(compact('mechanicsRegistration', 'registrations', 'people'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mechanics Registration id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mechanicsRegistration = $this->MechanicsRegistrations->get($id);
        if ($this->MechanicsRegistrations->delete($mechanicsRegistration)) {
            $this->Flash->success(__('The mechanics registration has been deleted.'));
        } else {
            $this->Flash->error(__('The mechanics registration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
