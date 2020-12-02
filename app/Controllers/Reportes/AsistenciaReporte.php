<?php

namespace App\Controllers\Reportes;

use FPDF;

class AsistenciaReporte extends FPDF
{

    public function imprimir($data = null)
    {
        $this->AddPage('L', 'legal');
        $this->Image("img/images/logo_oficial.png", 60 ,14, 15 , 15,'PNG', '');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 3, utf8_decode('CUADRO DE ASISTENCIA"'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetX(80);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'UNIDAD EDUCATIVA: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,'LAS ROSAS',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,'CURSO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,'TERCERO "A" SECUNDARIA',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30,5,'2020',0,0,'L',0);

        $this->Ln(10);
        $this->Output();
    }

    function imprimirCabecera($data)
    {
        // Datos
        foreach($data as $row)
        {
            $this->Cell(40,6,$row,1);
            $this->Ln();
        }
    }

}
