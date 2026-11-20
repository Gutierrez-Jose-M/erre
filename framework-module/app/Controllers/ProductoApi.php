<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class ProductoApi extends BaseController
{
    /** API REST simple: JSON con códigos de estado HTTP (TP9 + TP10). */
    public function index()
    {
        $model = new ProductoModel();
        $q = trim((string) $this->request->getGet('q'));

        $builder = $model->select('id, slug, nombre, tipo, precio, unidad, imagen')
            ->where('activo', 1);

        if ($q !== '') {
            $builder->groupStart()
                ->like('nombre', $q)
                ->orLike('tipo', $q)
                ->groupEnd();
        }

        $productos = $builder->orderBy('nombre', 'ASC')->limit(20)->get()->getResultArray();

        return $this->response
            ->setStatusCode(200)
            ->setJSON(['status' => 'success', 'data' => $productos]);
    }

    /** Devuelve un producto por id o 404. */
    public function show($id)
    {
        $model = new ProductoModel();
        $producto = $model->where('activo', 1)->find((int) $id);

        if (!$producto) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['status' => 'error', 'message' => 'Producto no encontrado']);
        }

        return $this->response
            ->setStatusCode(200)
            ->setJSON(['status' => 'success', 'data' => $producto]);
    }
}
