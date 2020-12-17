<?php

namespace App\Models;

use CodeIgniter\Database\Database;
use CodeIgniter\Database\BaseBuilder;

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
        $builder->join('materia_maestro mm', 'mm.id_maestro = m.id_maestro');
        $builder->join('curso_paralelo cu', 'cu.id_curso_paralelo = mm.id_curso_paralelo');
        $builder->join('curso c', 'c.id_curso = cu.id_curso');
        $builder->join('paralelo p', 'p.id_paralelo = cu.id_paralelo');
        $builder->join('materia ma', 'ma.id_materia = mm.id_materia');
        $builder->join('gestion g', 'g.id_gestion = mm.id_gestion');
        if (is_array($condicion))
            $builder->where($condicion);
        $builder->groupBy($agrupacion);
        $builder->orderBy($orden);
        return $builder->get();
    }

    public function listarCursosEstudiante($condicion = null, $orden = '', $agrupacion = '')
    {
        $builder = $this->db->table('curso_estudiante ce');
        $builder->select('*');
        $builder->join('curso_paralelo cp', 'cp.id_curso_paralelo = ce.id_curso_paralelo');
        $builder->join('materia_maestro mm', 'mm.id_curso_paralelo = cp.id_curso_paralelo');
        $builder->join('curso c', 'c.id_curso = cp.id_curso');
        $builder->join('materia ma', 'ma.id_materia = mm.id_materia');
        $builder->join('gestion g', 'g.id_gestion = mm.id_gestion');
        if (is_array($condicion))
            $builder->where($condicion);
        $builder->groupBy($agrupacion);
        $builder->orderBy($orden);
        return $builder->get();
    }

    public function calificacion($accion, $datos, $condicion = null)
    {
        $builder = $this->db->table('calificacion');
        switch ($accion) {
            case 'select':
                return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();
                break;
        }

        return null;
    }
    public function listarEstudiantes($condicion = null)
    {
        $builder = $this->db->table('persona p');
        $builder->select("e.id_estudiante, concat(p.nombres,' ',p.paterno,' ', p.materno,' CI.: ',p.ci,' ',p.exp) as nombre_completo");
        $builder->join('estudiante e', 'e.id_estudiante = p.id_persona');
        return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
    }

    public function cursosParalelos($condicion = null)
    {
        $builder = $this->db->table('curso_paralelo cp');
        $builder->select("*");
        $builder->join('curso c', 'c.id_curso = cp.id_curso');
        $builder->join('paralelo p', 'p.id_paralelo = cp.id_paralelo');
        return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
    }

    public function estudiantesCalificaciones($condicion = null, $orden = '', $agrupacion = '')
    {
        return $this->db->query("select
        `id_estudiante`,
        `nombres`,
        `materno`,
        `paterno`,
        `nacimiento`,
        `ci`,
        `nota1`,
        `nota2`,
        `nota3`,
        `nota_final`
      from
        (
          SELECT
            e.id_estudiante,
            p.estado,
            rude,
            nombres,
            materno,
            paterno,
            ci,
            rmm.id_maestro,
            cp.id_curso_paralelo,
            rmm.id_materia,
            rc.nota1,
            rc.nota2,
            rc.nota3,
            rc.nota_final,
            nacimiento,
            sexo,
            telefono,
            domicilio
          from
            rs_estudiante e
            join rs_persona p on p.id_persona = e.id_estudiante
            join rs_curso_estudiante rce on rce.id_estudiante = e.id_estudiante
            join rs_curso_paralelo cp on cp.id_curso_paralelo = rce.id_curso_paralelo
            join rs_materia_maestro rmm on rmm.id_curso_paralelo = cp.id_curso_paralelo
            left join rs_calificacion rc on rc.id_materia = rmm.id_materia
            and rc.id_maestro = rmm.id_maestro
            and rc.id_curso_paralelo = rmm.id_curso_paralelo
            and rc.id_estudiante = e.id_estudiante
        ) temp 
         WHERE id_curso_paralelo = " . $condicion['id_curso_paralelo'] . " and id_maestro = " . $condicion['id_maestro'] . " and id_materia = " . $condicion['id_materia'] . "");
    }
}
