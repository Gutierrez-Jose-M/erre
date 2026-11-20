<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Productos extends BaseController
{
    /** Vista del módulo usando el motor de plantillas de CodeIgniter. */
    public function index()
    {
        $model = new ProductoModel();

        $data = [
            'productos' => $model->orderBy('id', 'DESC')->findAll(),
        ];

        return view('productos/index', $data);
    }
}
