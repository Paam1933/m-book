<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model
{
    protected $table      = 'tb_books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['code', 'judul', 'pengarang', 'tahun_terbit', 'kota_terbit', 'sampul', 'isi_konten'];
    // protected $validationRule = [
    //     'code' => 'required',
    //     'judul' => 'required',
    //     'pengarang' => 'required',
    //     'tahun_terbit' => 'required',
    //     'kota_terbit' => 'required',
    //     'sampul' => 'required',
    //     'isi_konten' => 'required'
    // ];
    // protected $validationMessages = [
    //     'code' => [
    //         'required' => '{field} tidak boleh kosong',
    //         'is_unique' => '{field} sudah tersedia'
    //     ],
    //     'judul' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ],
    //     'pengarang' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ],
    //     'tahun_terbit' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ],
    //     'kota_terbit' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ],
    //     'sampul' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ],
    //     'isi_konten' => [
    //         'required' => '{field} tidak boleh kosong',
    //     ]
    // ];
}
