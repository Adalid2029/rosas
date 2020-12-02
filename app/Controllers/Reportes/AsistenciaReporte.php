<?php

namespace App\Controllers\Reportes;

use FPDF;

class AsistenciaReporte extends FPDF
{

    public function imprimir($data = null)
    {
        $this->AddPage('L', 'legal');
        $this->Image("img/images/logo_oficial.png", 50 ,14, 15 , 15,'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('CUADRO DE ASISTENCIA'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'UNIDAD EDUCATIVA: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,'LAS ROSAS',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'CURSO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,'TERCERO "A" SECUNDARIA',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30,5,'2020',0,0,'L',0);
        $this->Ln(7);
        $this->SetX(75);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'DE: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,'24-05-2020  a 30-05-2020',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'IMPRESO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,'20-05-2020',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);

        $this->Ln(10);
        $this->Output();
    }

}
