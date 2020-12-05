<?php

namespace App\Controllers\Reportes;
use FPDF;

class SeguimientoReporte extends FPDF
{
    public $fecha;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->fecha = new \DateTime();
    }

    public function imprimir($data, $fechaInicial, $fechaFinal, $curso)
    {
        $this->AddPage('L', 'legal');
        $this->Image("img/images/logo_oficial.png", 45 ,10, 17 , 18,'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('SEGUIMIENTO ACADÉMICO'), 0, 1, 'C', 0);
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
        $this->Cell(70,5,utf8_decode("PRIMERO DE SECUNDARIA"),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30,5,'2020',0,0,'L',0);
        $this->Ln(7);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'DE: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,$fechaInicial . ' a ' . $fechaFinal,0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'IMPRESO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,$this->fecha->format('d-m-Y H:i'),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(10);
        $this->Output();
    }


}// class
