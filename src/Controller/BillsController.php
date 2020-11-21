<?php
declare(strict_types=1);

namespace App\Controller;

use PDOException;

/**
 * Bills Controller
 *
 * @property \App\Model\Table\BillsTable $Bills
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BillsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $bills = $this->Bills->find();

        $this->set(compact('bills'));
        $this->viewBuilder()->setOption('serialize', ['bills']);

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
        $bill = $this->Bills->get($id);

        $this->set(compact('bill'));
        $this->viewBuilder()->setOption('serialize', ['bill']);
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
        $status = $this->Bills->getConnection()->transactional(function ($connection) use ($data) {
            $bill = $this->Bills->newEntity([
                'bill_date' => $data['bill_date'],
                'customer_id' => $data['customer_id'],
                'user_id' => $data['user_id'],
            ]);

            $partsTable = $this->getTableLocator()->get('Parts');

            if ($this->Bills->save($bill, ['atomic' => false])) {
                $details = collection($data['details'])->map(function ($detail) use ($bill, $partsTable) {
                    $detail['bill_id'] = $bill->id;
                    if (!empty($detail['part_id'])) {
                        $part = $partsTable->get($detail['part_id']);
                        $detail['details'] = $part->name;
                        $detail['amount'] = $part->price;
                    }
                    return $detail;
                })->toList();
                $billDetails = $this->Bills->BillDetails->newEntities($details);
                if (!$this->Bills->BillDetails->saveManyOrFail($billDetails, ['atomic' => false])) {
                    return false;
                }
            } else {
                return false;
            }

            return true;
        });
        if ($status) {
            $responseData['message'] = 'Se ha guardado.';
        } else {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se ha guardado.';
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message']);
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
        $bill = $this->Bills->get($id);
        $bill = $this->Bills->patchEntity($bill, $this->request->getData());
        if ($this->Bills->save($bill)) {
            $responseData['message'] = 'Se ha guardado.';
        } else {
            $this->setResponse($this->response->withStatus(400));
            $responseData['message'] = 'No se ha guardado.';
            $responseData['error'] = $bill->getErrors();
        }

        $this->set($responseData);
        $this->viewBuilder()->setOption('serialize', ['message']);
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
        $bill = $this->Bills->get($id);
        try {
            if ($this->Bills->delete($bill)) {
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
}