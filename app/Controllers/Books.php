<?php

namespace App\Controllers;

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
            'code' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah tersedia'
                ]
            ],
            'pengarang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'sampul' => [
                'rules' => 'is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png,image/JPG,image/JPEG,image/PNG]',
                'errors' => [
                    'is_image' => '{field} bukan gambar',
                    'mime_in' => '{field} bukan gambar'
                ]
            ]
        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];

            return $this->failValidationErrors($respons);
        }
        $file = $this->request->getFile('sampul');
        if ($file->getError() == 4) {
            $filename = 'default.png';
        } else {
            $filename = $file->getRandomName();
            $file->move('img', $filename);
        }
        $respond = [
            'status' => true,
            'messege' => 'Add Book successfuly'
        ];
        $data = [
            'code' => $this->request->getVar('code'),
            'judul' => $this->request->getVar('judul'),
            'pengarang' => $this->request->getVar('pengarang'),
            'kota_terbit' => $this->request->getVar('kota_terbit'),
            'tahun_terbit' => $this->request->getVar('tahun_terbit'),
            'isi_konten' => $this->request->getVar('isi_konten'),
            'sampul' => $filename
        ];

        $this->model->insert($data);

        return $this->respond($respond, 200);
    }








    public function update($id = null)
    {
        $rules = $this->validate([
            'judul' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'code' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah tersedia'
                ]
            ],
            'pengarang' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tahun_terbit' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kota_terbit' => [
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
            'sampul' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]'
        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($respons);
        }
        // get file sampul
        $file = $this->request->getFile('sampul');
        // jika user tidak memilih/update sampul
        if ($file->getError() == 4) {
            $sampul = $this->request->getPost('old_sampul');
        } else {
            // jika user update sampul
            // ubah nama file menjadi random
            $sampul = $file->getRandomName();
            // upload ke folder img
            $file->move('img', $sampul);
            // hapus file lama
            unlink('img/' . $this->request->getPost('old_sampul'));
        }
        $this->model->update($id, [
            'judul'         => $this->request->getVar('judul'),
            'code'          => $this->request->getVar('kode'),
            'pengarang'     => $this->request->getVar('pengarang'),
            'tahun_terbit'  => $this->request->getVar('tahun_terbit'),
            'kota_terbit'   => $this->request->getVar('kota_terbit'),
            'isi_konten'    => $this->request->getVar('isi_konten'),
            'sampul' => $sampul,
        ]);
        $respons = [
            'status' => true,
            'message' => 'update data success'
        ];
        return $this->respond($respons, 200);
    }











    public function delete($id = null)
    {
        $oldSampul = $this->model->find($id);
        if ($oldSampul['sampul'] != '') {
            unlink('img/' . $oldSampul['sampul']);
        }
        $this->model->delete($id);
        $respons = [
            'status' => true,
            'message' => 'Delete data success'
        ];
        return $this->respondDeleted($respons);
    }
}
