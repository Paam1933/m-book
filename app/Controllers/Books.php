<?php

namespace App\Controllers;

use App\Models\BooksModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Books extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\BooksModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->orderBy('id', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->model->where('id', $id)->find();
        $respond = [
            'status' => true,
            'message' => 'Geting Book succesfuly',
            'data' => $data,
        ];
        if ($data) {
            return $this->respond($respond, 200);
        } else {
            return $this->failNotFound('Book Not Found');
        }
    }
    public function create()
    {
        $rules = $this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah tersedia'
                ]
            ],

        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];

            return $this->failValidationErrors($respons, 404);
        }

        $respond = [
            'status' => true,
            'messege' => 'Add Book successfuly'
        ];
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi_konten' => $this->request->getVar('isi_konten'),
        ];

        $this->model->insert($data);
        return $this->respond($respond, 200);
    }


    public function update($id = null)
    {
        $model = new BooksModel();
        $rules = $model->validate([
            'judul' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'isi_konten' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],

        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($respons);
        }
        $data = [
            'judul'         => $this->request->getVar('judul'),
            'isi_konten'    => $this->request->getVar('isi_konten'),
            // 'sampul' => $sampul,
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);

        $respons = [
            'status' => true,
            'message' => 'update data success'
        ];
        return $this->respond($respons, 200);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        $respons = [
            'status' => true,
            'message' => 'Delete data success'
        ];
        return $this->respondDeleted($respons);
    }
}
