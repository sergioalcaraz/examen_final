<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use PDOException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->Users->find()->contain([
            'People'
        ]);
        $users = $users->map(function ($user)  {
            return $this->adaptEntity($user);
        })->toList();
        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);

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
        $user = $this->Users->get($id, [
            'contain' => 'People',
        ]);
        $user = $this->adaptEntity($user);
        $this->set(compact('user'));
        $this->viewBuilder()->setOption('serialize', ['user']);
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
        $person = $this->Users->People->newEntity($data);
        $user = $this->Users->newEntity($data);

        $status = $this->Users->getConnection()->transactional(function ($connection) use (&$person, &$user) {
            if (!$this->Users->People->save($person, ['atomic' => false])) {
                return false;
            }
            $user->person_id = $person->id;
            if (!$this->Users->save($user, ['atomic' => false])) {
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
            } elseif ($user->hasErrors()) {
                $responseData['error'] = $user->getErrors();
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
        $person = $this->Users->People->get($id);
        $user = $this->Users->get($id);
        $person = $this->Users->People->patchEntity($person, $data);
        $user = $this->Users->patchEntity($user, $data);

        $status = $this->Users->getConnection()->transactional(function ($connection) use (&$person, &$user) {
            if (!$this->Users->People->save($person, ['atomic' => false])) {
                return false;
            }
            if (!$this->Users->save($user, ['atomic' => false])) {
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
            } elseif ($user->hasErrors()) {
                $responseData['error'] = $user->getErrors();
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
        $user = $this->Users->get($id);
        try {
            $status = $this->Users->getConnection()->transactional(function ($connection) use ($user) {
                if (!$this->Users->delete($user, ['atomic' => false])) {
                    return false;
                }

                $person = $this->Users->People->get($user->person_id);
                if (!$this->Users->People->delete($person, ['atomic' => false])) {
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

    /**
     * Adapt entity.
     */
    private function adaptEntity(User $user): User
    {
        /** @var \App\Model\Entity\Person */
        $person = $user->person;
        $user->id = $person->get('id');
        $user->name = $person->get('name');
        $user->last_name = $person->get('last_name');
        unset($user->person);
        unset($user->person_id);

        return $user;
    }
}