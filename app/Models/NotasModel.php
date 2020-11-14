<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class NotasModel extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function listarCursos($condicion = null, $orden = '', $agrupacion = '')
    {
        $builder = $this->db->table('maestro m');
        $builder->select('*');
        $builder->join('clase c', 'c.id_maestro = m.id_maestro');
        $builder->join('curso cu', 'cu.id_curso = c.id_curso');
        $builder->join('materia ma', 'ma.id_materia = c.id_materia');
        $builder->where($condicion);
        $builder->groupBy($agrupacion);
        $builder->orderBy($orden);

        return $builder->get();
    }
}
