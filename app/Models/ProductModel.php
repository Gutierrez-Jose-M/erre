<?php
/**
 * Modelo de productos (TP10, parte A: MVC nativo).
 * Toda sentencia SQL se ejecuta con PDO + consultas preparadas (TP7).
 */

require_once __DIR__ . '/../../config/conexion.php';

class ProductModel
{
    /** Consulta base con las tablas relacionadas. */
    private static function selectSql()
    {
        return 'SELECT p.id, p.slug, p.nombre, p.descripcion, p.marca_id, p.categoria_id,
                       p.tipo, p.precio, p.old_price, p.unidad, p.imagen, p.destacado, p.activo,
                       m.nombre AS marca, c.slug AS categoria
                FROM productos p
                INNER JOIN marcas m ON m.id = p.marca_id
                INNER JOIN categorias c ON c.id = p.categoria_id';
    }

    /** Convierte una fila de BD al array que usa la vista. */
    private static function map($row)
    {
        return array(
            'id' => (int) $row['id'],
            'slug' => $row['slug'],
            'name' => $row['nombre'],
            'description' => $row['descripcion'],
            'brand' => $row['marca'],
            'marca_id' => (int) $row['marca_id'],
            'category' => $row['categoria'],
            'categoria_id' => (int) $row['categoria_id'],
            'type' => $row['tipo'],
            'price' => (float) $row['precio'],
            'oldPrice' => $row['old_price'] === null ? null : (float) $row['old_price'],
            'unit' => $row['unidad'],
            'image' => $row['imagen'],
            'featured' => (bool) $row['destacado'],
            'active' => (bool) $row['activo'],
        );
    }

    /** Todos los productos activos. */
    public static function all()
    {
        $pdo = db();
        if (!$pdo) {
            return array();
        }
        $sql = self::selectSql() . ' WHERE p.activo = 1 ORDER BY p.id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $out = array();
        foreach ($stmt->fetchAll() as $row) {
            $out[] = self::map($row);
        }
        return $out;
    }

    /** Productos de una categoría (comestibles / limpieza). */
    public static function byCategory($categoriaSlug)
    {
        $pdo = db();
        if (!$pdo) {
            return array();
        }
        $sql = self::selectSql() . ' WHERE p.activo = 1 AND c.slug = :categoria ORDER BY p.id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':categoria' => $categoriaSlug));
        $out = array();
        foreach ($stmt->fetchAll() as $row) {
            $out[] = self::map($row);
        }
        return $out;
    }

    /** Busca por id (admin). */
    public static function find($id)
    {
        $pdo = db();
        if (!$pdo) {
            return null;
        }
        $sql = self::selectSql() . ' WHERE p.id = :id LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => (int) $id));
        $row = $stmt->fetch();
        return $row ? self::map($row) : null;
    }

    /** Busca por slug (ficha de producto). */
    public static function findBySlug($slug)
    {
        $pdo = db();
        if (!$pdo) {
            return null;
        }
        $sql = self::selectSql() . ' WHERE p.slug = :slug AND p.activo = 1 LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':slug' => $slug));
        $row = $stmt->fetch();
        return $row ? self::map($row) : null;
    }

    /** Listado simple para el panel de administración. */
    public static function adminList()
    {
        $pdo = db();
        if (!$pdo) {
            return array();
        }
        $sql = 'SELECT p.id, p.slug, p.nombre, p.tipo, p.precio, p.old_price, p.destacado,
                       m.nombre AS marca, c.slug AS categoria
                FROM productos p
                INNER JOIN marcas m ON m.id = p.marca_id
                INNER JOIN categorias c ON c.id = p.categoria_id
                ORDER BY p.id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Catálogo de marcas para los <select> del admin. */
    public static function marcas()
    {
        return self::lookup('marcas');
    }

    /** Catálogo de categorías para los <select> del admin. */
    public static function categorias()
    {
        return self::lookup('categorias');
    }

    private static function lookup($tabla)
    {
        $pdo = db();
        if (!$pdo) {
            return array();
        }
        $allowed = array('marcas', 'categorias');
        if (!in_array($tabla, $allowed, true)) {
            return array();
        }
        $select = ($tabla === 'categorias') ? 'id, slug, nombre' : 'id, nombre';
        $stmt = $pdo->prepare('SELECT ' . $select . ' FROM ' . $tabla . ' ORDER BY nombre ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** CREATE (INSERT preparado). */
    public static function create($data)
    {
        $pdo = db();
        if (!$pdo) {
            return false;
        }
        $sql = 'INSERT INTO productos
                (slug, nombre, descripcion, marca_id, categoria_id, tipo,
                 precio, old_price, unidad, imagen, destacado, activo)
                VALUES
                (:slug, :nombre, :descripcion, :marca_id, :categoria_id, :tipo,
                 :precio, :old_price, :unidad, :imagen, :destacado, 1)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(self::params($data));
    }

    /** UPDATE (siempre con WHERE id = :id). */
    public static function update($id, $data)
    {
        $pdo = db();
        if (!$pdo) {
            return false;
        }
        $sql = 'UPDATE productos SET
                    slug = :slug, nombre = :nombre, descripcion = :descripcion,
                    marca_id = :marca_id, categoria_id = :categoria_id, tipo = :tipo,
                    precio = :precio, old_price = :old_price, unidad = :unidad,
                    imagen = :imagen, destacado = :destacado
                WHERE id = :id';
        $params = self::params($data);
        $params[':id'] = (int) $id;
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /** DELETE (siempre con WHERE id = :id). */
    public static function delete($id)
    {
        $pdo = db();
        if (!$pdo) {
            return false;
        }
        $stmt = $pdo->prepare('DELETE FROM productos WHERE id = :id');
        return $stmt->execute(array(':id' => (int) $id));
    }

    /** Parámetros compartidos por create() y update(). */
    private static function params($data)
    {
        return array(
            ':slug' => $data['slug'],
            ':nombre' => $data['name'],
            ':descripcion' => $data['description'],
            ':marca_id' => (int) $data['marca_id'],
            ':categoria_id' => (int) $data['categoria_id'],
            ':tipo' => $data['type'],
            ':precio' => (float) $data['price'],
            ':old_price' => $data['oldPrice'] !== '' && $data['oldPrice'] !== null
                ? (float) $data['oldPrice']
                : null,
            ':unidad' => $data['unit'],
            ':imagen' => $data['image'],
            ':destacado' => !empty($data['featured']) ? 1 : 0,
        );
    }
}
