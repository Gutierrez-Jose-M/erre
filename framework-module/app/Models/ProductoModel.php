<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'slug', 'nombre', 'descripcion', 'marca_id', 'categoria_id',
        'tipo', 'precio', 'old_price', 'unidad', 'imagen',
        'destacado', 'activo',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'slug'    => 'required|min_length[2]|max_length[120]|is_unique[productos.slug,id,{id}]',
        'nombre'  => 'required|max_length[160]',
        'precio'  => 'required|numeric|greater_than_equal_to[0]',
        'imagen'  => 'required|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}
