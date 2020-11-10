<?php

namespace App\Controllers\Reportes;

use FPDF;

class NotasReporte extends FPDF
{
    public function imp()
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(40, 10, utf8_decode('¡Hola, Mundo!'));
        $this->Output();
    }
}
