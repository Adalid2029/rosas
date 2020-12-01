<?php

namespace App\Controllers\Reportes;

use FPDF;

class AsistenciaReporte extends FPDF
{

    public function imprimir($data = null)
    {
        $this->AddPage('P', 'letter');
        $this->Image("img/images/reporte_encabezado.png", 6 ,5, 200 , 20,'PNG', 'https://rosas.com');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 3, utf8_decode('UNIDAD EDUCATIVA "LAS ROSAS"'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 3, utf8_decode('asistencia'), 0, 1, 'C', 0);

        $header = array(
            utf8_decode('Nº'),
            utf8_decode('CI'),
            utf8_decode('Nombres y Apellidos'),
            utf8_decode('Nacimiento'),
            utf8_decode('Telefono'),
            utf8_decode('Sexo'),
            utf8_decode('Cargo'),
            utf8_decode('Año ingreso')
        );

        $this->Ln(10);
        $this->SetX(8);
        $this->SetFont('Arial', '', 9);
        $this->Output();
    }

}
