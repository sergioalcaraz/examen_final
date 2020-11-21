<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Customer;
use PDOException;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $customers = $this->Customers->find()->contain([
            'People'
        ]);
        $customers = $customers->map(function ($customer)  {
            return $this->adaptEntity($customer);
        })->toList();
        $this->set(compact('customers'));
        $this->viewBuilder()->setOption('serialize', ['customers']);

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
        $customer = $this->adaptEntity($this->Customers->get($id, [
            'contain' => 'People',
        ]));

        $this->set(compact('customer'));
        $this->viewBuilder()->setOption('serialize', ['customer']);
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
        $person = $this->Customers->People->newEntity($data);
        $customer = $this->Customers->newEntity($data);

        $status = $this->Customers->getConnection()->transactional(function ($connection) use (&$person, &$customer) {
            if (!$this->Customers->People->save($person, ['atomic' => false])) {
                return false;
            }
            $customer->person_id = $person->id;
            if (!$this->Customers->save($customer, ['atomic' => false])) {
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
            } elseif ($customer->hasErrors()) {
                $responseData['error'] = $customer->getErrors();
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
        $person = $this->Customers->People->get($id);
        $customer = $this->Customers->get($id);
        $person = $this->Customers->People->patchEntity($person, $data);
        $customer = $this->Customers->patchEntity($customer, $data);

        $status = $this->Customers->getConnection()->transactional(function ($connection) use (&$person, &$customer) {
            if (!$this->Customers->People->save($person, ['atomic' => false])) {
                return false;
            }
            if (!$this->Customers->save($customer, ['atomic' => false])) {
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
            } elseif ($customer->hasErrors()) {
                $responseData['error'] = $customer->getErrors();
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
        $customer = $this->Customers->get($id);
        try {
            $status = $this->Customers->getConnection()->transactional(function ($connection) use ($customer) {
                if (!$this->Customers->delete($customer, ['atomic' => false])) {
                    return false;
                }

                $person = $this->Customers->People->get($customer->person_id);
                if (!$this->Customers->People->delete($person, ['atomic' => false])) {
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

    private function adaptEntity(Customer $customer): Customer
    {
        /** @var \App\Model\Entity\Person */
        $person = $customer->person;
        $customer->id = $person->get('id');
        $customer->name = $person->get('name');
        $customer->last_name = $person->get('last_name');
        unset($customer->person);
        unset($customer->person_id);

        return $customer;
    }
}