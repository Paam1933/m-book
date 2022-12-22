<?php

namespace App\Controllers;

use App\Models\BooksModel;
use CodeIgniter\RESTful\ResourceController;

class Upload extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new BooksModel();
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'sampul' => [
                'label' => 'File Image',
                'rules' => 'uploaded[sampul]|is_image[sampul]|ext_in[sampul,png,jpg,jpeg]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'error' => [
                    'uploaded' => '{field} harus upload',
                    'mime_in' => '{field} kesalahan mime'
                ]
            ]
        ]);
        if (!$valid) {
            $error_msg = [
                'err_upload' => $validation->getError('sampul')
            ];
            $response = [
                'status' => 404,
                'error' => 404,
                'message' => $error_msg
            ];
            return $this->respond($response, 404);
        } else {
            // get file sampul
            $file = $this->request->getFile('sampul');
            $sampul_lama = $model->find($id);
            // jika user tidak memilih/update sampul
            $sampul = $file->getRandomName();
            // print_r($file->getName());
            // die;
            $file->move('img', $sampul);
            if ($sampul_lama['sampul'] != 'default.png') {
                unlink('img/' . $sampul_lama['sampul']);
            }
            $data = [
                'sampul' => $sampul
            ];
            $model->update($id, $data);
            $response = [
                'status' => 201,
                'error' => true,
                'message' => 'upload sampul berhasil'
            ];
            return $this->respond($response, 201);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
