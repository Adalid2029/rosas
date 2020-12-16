<?php


namespace App\Controllers\Reportes;

use FPDF;

class TutorReporte extends FPDF
{

    public function imprimir($data = null)
    {
        $this->AddPage('P', 'letter');
        $this->Image("img/images/logo_oficial.png", 49 ,5, 17 , 17,'PNG');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 3, utf8_decode('UNIDAD EDUCATIVA "LAS ROSAS"'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 3, utf8_decode('LISTADO DE TUTORES'), 0, 1, 'C', 0);

        $header = array( //ci, nombres_apellidos, correo, telefono, sexo, parentesco
            utf8_decode('Nº'),
            utf8_decode('CI'),
            utf8_decode('Nombres y Apellidos'),
            utf8_decode('Correo'),
            utf8_decode('Telefono'),
            utf8_decode('Sexo'),
            utf8_decode('Parentesco')
        );

        $this->Ln(10);
        $this->SetX(8);
        $this->SetFont('Arial', '', 9);
        $this->imprimirTutores($header, $data);
        $this->Output();
    }

    function imprimirTutores($header, $data)
    {
        $this->SetX(8);
        $this->SetFillColor(105, 105, 105);
        $this->SetTextColor(255);
        $this->SetDrawColor(105, 105, 105);
        $this->SetLineWidth(.3);

        // Header
        $w = array(8, 22, 58, 45, 25, 11, 30);
        for ($i = 0; $i < count($header); $i++){
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(192, 192, 192);
        $this->SetTextColor(0);

        // Data
        $this->SetX(8);
        $fill = false;
        if ($data != null) {

            for ($i = 0; $i < count($data); $i++) {
                $this->SetX(8);
                $this->SetFont('Arial', '', 8);
                $this->Cell($w[0], 8, $i+1, 'LR', 0, 'C', $fill);
                $this->Cell($w[1], 8, utf8_decode($data[$i]['ci']), 'LR', 0, 'L', $fill);
                $this->Cell($w[2], 8, utf8_decode($data[$i]['nombres_apellidos']), 'LR', 0, 'L', $fill);
                $this->Cell($w[3], 8, utf8_decode($data[$i]['correo']), 'LR', 0, 'L', $fill);
                $this->Cell($w[4], 8, utf8_decode($data[$i]['telefono']), 'LR', 0, 'C', $fill);
                $this->Cell($w[5], 8, utf8_decode($data[$i]['sexo']), 'LR', 0, 'C', $fill);
                $this->Cell($w[6], 8, utf8_decode($data[$i]['parentesco']), 'LR', 0, 'C', $fill);

                $this->Ln();

                $fill = !$fill;
            }
        } else {

            $this->Cell(196, 8, "NO EXISTEN DATOS PARA MOSTRAR", 'LR', 0, 'C', false);
            $this->Ln();
        }



        // Closing line
        $this->SetX(8);
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}
