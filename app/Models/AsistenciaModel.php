<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class AsistenciaModel extends Database
{

    public $db = null;
    public $fecha;

    public function __construct()
    {
        $this->db = \config\Database::connect();
        $this->fecha = new \DateTime();
    }

    public function asistencia($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("asistencia");
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion);
                } else {
                    return $builder->get();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();
                break;
            case 'search':
                return $builder->like('nombres', $busqueda)->get()->getResultArray();
                break;
        }

        return null;
    }

    public function listarCursosParalelos()
    {
        $builder = $this->db->table("view_curso_paralelo");
        $builder->select('id_curso_paralelo, id_curso, concat(nivel, " ", paralelo)as curso');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

    public function listarMaestros()
    {
        $builder = $this->db->table("view_maestro");
        $builder->select('id_maestro, nombres_apellidos');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

    public function verificarMarcadoAsistenciaHoy($id_estudiante)
    {
        $fecha_hoy = new \DateTime();
        $builder = $this->db->table("asistencia");
        $builder->select('id_asistencia, fecha');
        $builder->where(array("id_estudiante" => $id_estudiante, "fecha" => $fecha_hoy->format('Y-m-d')));
        return $builder->get()->getResultArray();
    }

    public function verificarFechaAImprimir($ini, $fin, $curso)
    {
        $builder = $this->db->table("view_asistencia_curso");
        $builder->select('distinct(fecha)');
        $builder->where('fecha >=', $ini);
        $builder->where('fecha <=', $fin);
        $builder->where('nivel', $curso[0]);
        $builder->where('paralelo', $curso[1]);
        $builder->where('gestion', $this->fecha->format('Y'));
        return $builder->get()->getResultArray();
    }

    public function verificarEstudiantesAsistencia($ini, $fin, $curso)
    {
        $builder = $this->db->table("view_asistencia_curso");
        $builder->select('distinct(id_persona)');
        $builder->where('nivel', $curso[0]);
        $builder->where('paralelo', $curso[1]);
        $builder->where('gestion', $this->fecha->format('Y'));
        return $builder->get()->getResultArray();
    }

    public function verificarDatos($id_persona, $columna)
    {
        $builder = $this->db->table("view_asistencia_curso");
        $builder->select($columna);
        $builder->where('id_persona', $id_persona);
        return $builder->get()->getResultArray();
    }

    public function verificarAsistenciaFecha($id_persona, $fecha)
    {
        $builder = $this->db->table("view_asistencia_curso");
        $builder->select("valor");
        $builder->where('id_persona', $id_persona);
        $builder->where('fecha', $fecha);
        return $builder->get()->getResultArray();
    }

    public function contarAsistenciaEstudiantes($ini, $fin, $curso, $id_persona, $columna, $valor)
    {
        $builder = $this->db->table("view_asistencia_curso");
        $builder->select("count(".$columna.")as valor");
        $builder->where('fecha >=', $ini);
        $builder->where('fecha <=', $fin);
        $builder->where('nivel', $curso[0]);
        $builder->where('paralelo', $curso[1]);
        $builder->where('id_persona', $id_persona);
        $builder->where('valor', $valor);
        return $builder->get()->getResultArray();
    }

}// class
