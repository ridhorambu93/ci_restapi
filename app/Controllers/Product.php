<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController {
    use ResponseTrait;
    // get all
    public function index() {
        $model = new ProductModel();
        $data['product'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create() {
        $model = new ProductModel();
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'  => $this->request->getVar('harga'),
        ];
        $model->insert($data);
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'Berhasil menambah produk baru.'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single user
    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data produk tidak ditemukan.');
        }
    }
     // update
    public function update($id = null){
        $model = new ProductModel();
        $id = $this->request->getVar('id');
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'  => $this->request->getVar('harga'),
        ];
        $model->update($id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'Produk berhasil di update'
          ]
      ];
      return $this->respond($response);
    }

    public function delete($id = null){
        $model = new ProductModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data produk berhasil dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Produk tidak ditemukan');
        }
    }
}