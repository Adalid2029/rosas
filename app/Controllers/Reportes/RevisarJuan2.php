<?php

namespace App\Controllers\Reportes;

use FPDF;

class RevisarJuan2 extends FPDF
{
    function Header()
    {
        $this->Image('logo.jpeg', 20, 15, 12);
        $this->SetFont('Arial', 'B', 15);
        $this->setX(20);

        // $this->Line(20, 6, 195, 6); // 20mm from each edge

        //$this->Line(20, 260.5, 200, 260.5); // 20mm from each edge
        //$this->Line(20, 261.5, 200, 261.5); // 20mm from each edge
        // $this->Line(20, 262.5, 200, 262.5); // 20mm from each edge
        $this->SetFont('Arial', 'B', 13);
        $this->SetX(75);
        $this->Cell(120, 10, "CENTRALIZADOR DE CALIFICACIONES");

        // $this->Ln();

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(35);
        $this->Cell(200, 10, "Unidad Educativa:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(70);
        $this->Cell(200, 10, "\"LAS ROSAS\"");
        $this->SetFont('Arial', 'B', 10);

        $this->SetX(100);

        $this->Cell(200, 10, "Curso:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(115);
        $this->Cell(200, 10, "TERCERO   \"A\"   SECUNDARIA");


        $this->setY(17);
        $this->SetX(180);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(200, 10, "Gestion: ");
        $this->SetFont('Arial', '', 10);
        $this->SetX(200);
        $this->Cell(200, 10, " 2020");

        //$this->Cell(200,10,"\"LAS ROSAS\"");

        $this->setY(20);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(57);
        $this->Cell(200, 10, "Area:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(70);
        $this->Cell(200, 10, "MATEMATICAS");
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(100);
        $this->Cell(200, 10, "DOCENTE:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(120);
        $this->Cell(200, 10, "Benedicto Colque  Mayta");
        $this->SetFont('Arial', 'B', 10);

        $this->setY(7);
    }
    function Tabla()
    {
        $this->AddPage('P', 'Letter');

        $this->setY(30);
        $this->SetX(15);
        $this->Cell(10, 60, " No", 1);
        $this->Cell(40, 60, "APELLIDO PATERNO", 1);
        $this->Cell(40, 60, "APELLIDO MATERNO", 1);
        $this->Cell(50, 60, "         NOMBRES", 1);
        $this->Cell(36, 10, "NOTA BIMESTRAL", 1);
        $this->Cell(20, 60, "PROM A ", 1);
        $this->Cell(30, 60, "LITERAL", 1);
        $this->setY(40);
        $this->SetX(155);
        $this->Cell(12, 50, "P.T.", 1);
        $this->Cell(12, 50, "S.T.", 1);
        $this->Cell(12, 50, "T.T.", 1);



        $this->setY(90);
        $this->SetX(15);
        $this->Cell(10, 10, "1", 1);
        $this->Cell(40, 10, "", 1);
        $this->Cell(40, 10, "", 1);
        $this->Cell(50, 10, "  ", 1);
        $this->Cell(12, 10, "", 1);
        $this->Cell(12, 10, "", 1);
        $this->Cell(12, 10, "", 1);
        $this->Cell(20, 10, "", 1);
        $this->Cell(30, 10, "", 1);

        $this->Output();
    }
}
