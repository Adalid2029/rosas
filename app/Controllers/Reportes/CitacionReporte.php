<?php

namespace App\Controllers\Reportes;

use Cassandra\Date;
use FPDF;

class CitacionReporte extends FPDF
{
    public function imprimir($name, $fecha)
    {
        $this->AddPage('P', 'letter');
        $this->SetY(12);
        $this->Image("img/images/escudo_rosas.png", 65 ,10, 18 , 18,'PNG', 'https://rosas.com');
        $this->SetFont('Arial', 'B', 14);
        $this->Ln(7);
        $this->SetX(10);
        $this->Cell(0, 3, utf8_decode('CITACIÓN 01/2020'), 0, 1, 'C', 0);
        $fecha1 = new \DateTime($fecha);
        $dia = $fecha1 -> format("d");
        $mes = $fecha1 -> format("m");
        $anio = $fecha1 -> format("Y");
        $this->Ln(9);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 3, utf8_decode("El Alto, " . $dia . " de " . $this->sacar_mes($mes) . " del " . $anio), 0, 1, 'R', 0);

        $this->Ln(9);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(196, 7, utf8_decode("La Comisión Técnica Pedagógica de nivel secundaria en coordinación con la Dirección, cita a usted señor padre o madre de familia a la entrevista con el asesor de curso y secretaria durante la semana del año en curso entre los horarios de 8:00 AM a 13:30 PM en los predios de la Unidad Educativa, para tratar el rendimiento curricular de su hijo/a:"), 0, 'J', 0);
        $this->MultiCell(196, 7, strtoupper(utf8_decode($name)), 0, 'C', 0);
        $this->MultiCell(196, 7, utf8_decode("Se le recuerda, la no asistencia compromete estar de acuerdo con las observaciones del kardex y sus consecuencias."), 0, 'J', 0);
        $this->MultiCell(196, 7, utf8_decode("Atte. COMISIÓN TÉCNICA PEDAGÓGICA y DIRECCIÓN"), 0, 'C', 0);

        $this->Output();
    }

    public function sacar_mes($mes){
        $m = "";
        if($mes === '01' || $mes == '1'){
            $m = "enero";
        }else if($mes == '02' || $mes == '2'){
            $m = "febrero";
        }else if($mes == '03' || $mes == '3'){
            $m = "marzo";
        }else if($mes == '04' || $mes == '4'){
            $m = "abril";
        }else if($mes == '05' || $mes == '5'){
            $m = "mayo";
        }else if($mes == '06' || $mes == '6'){
            $m = "junio";
        } else if($mes == '07' || $mes == '7'){
            $m = "julio";
        } else if($mes == '08' || $mes == '8'){
            $m = "agosto";
        } else if($mes == '09' || $mes == '9'){
            $m = "septiembre";
        } else if($mes == '10'){
            $m = "octubre";
        } else if($mes == 11){
            $m = "noviembre";
        }else
        {
            $m = "diciembre";
        }
        return $m;
    }

}
