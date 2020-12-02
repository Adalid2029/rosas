<?php

namespace App\Controllers\Reportes;

use FPDF;

class RevisarJuan3 extends FPDF
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


        $this->setY(30);
        $this->SetX(15);
        $this->Cell(10, 60, " No", 1);
        $this->Cell(40, 60, "APELLIDO PATERNO", 1);
        $this->Cell(40, 60, "APELLIDO MATERNO", 1);
        $this->Cell(50, 60, "         NOMBRES", 1);
        $this->Cell(36, 10, "NOTA BIMESTRAL", 1);
        $this->Cell(20, 60, " ", 1);
        $this->TextWithRotation(202, 85, utf8_decode("PROMEDIO ANUAL"), 90, 0);

        $this->Cell(30, 60, "       LITERAL", 1);
        $this->setY(40);
        $this->SetX(155);
        $this->Cell(12, 50, "", 1);
        $this->TextWithRotation(165, 85, utf8_decode("PRIMER TRIMESTRE "), 90, 0);
        $this->Cell(12, 50, "", 1);
        $this->TextWithRotation(177, 85, utf8_decode("SEGUNDO TRIMESTRE "), 90, 0);

        $this->Cell(12, 50, "", 1);
        $this->TextWithRotation(189, 85, utf8_decode("TERCER TRIMESTRE "), 90, 0);



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
    function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'L')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'U')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'D')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        else
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle = 0)
    {
        $font_angle += 90 + $txt_angle;
        $txt_angle *= M_PI / 180;
        $font_angle *= M_PI / 180;

        $txt_dx = cos($txt_angle);
        $txt_dy = sin($txt_angle);
        $font_dx = cos($font_angle);
        $font_dy = sin($font_angle);

        $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }
}
