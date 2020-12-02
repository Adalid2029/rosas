<?php

namespace App\Controllers\Reportes;

use FPDF;

class RevisarJuan1 extends FPDF
{
    // Cargar los datos
    function LoadData($file)
    {
        // Leer las líneas del fichero
    }
    function Header()
    {
        $this->Image('logo.jpeg', 20, 12, 15);
        $this->SetFont('Arial', 'B', 13);
        $this->SetX(120);
        $this->Cell(100, 10, "CENTRALIZADOR DE AREAS");
        $this->SetY(20);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(40);
        $this->Cell(200, 10, "Unidad Educativa:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(75);
        $this->Cell(200, 10, "\"LAS ROSAS\"");
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(105);
        $this->Cell(200, 10, "Curso:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(120);
        $this->Cell(200, 10, "TERCERO 'A' SECUNDARIA");
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(170);
        $this->Cell(200, 10, "Gestion:");
        $this->SetFont('Arial', '', 10);
        $this->SetX(190);
        $this->Cell(200, 10, "2020");
        $this->SetY(60);
        $this->ln();
    }
    // Tabla simple
    function Tabla()
    {
        $this->AddPage('P', 'Letter');
        // $this->TextWithDirection(110,50,'comunicacion','L');
        // $this->TextWithDirection(110,50,'dfsdf','R');
        // $this->TextWithDirection(110,50,'dfsdf','D');
        $this->setY(30);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(5, 30, "N" . utf8_decode("°"), 1);
        $this->TextWithDirection(21, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(21, 50, 'PATERNO', 'R');
        $this->TextWithDirection(41, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(41, 50, 'MATERNO', 'R');
        $this->TextWithDirection(61, 48, 'NOMBRES', 'R');
        for ($n = 1; $n <= 3; $n++) {
            $this->Cell(20, 30, "", 1);
        }
        // $this->SetXY(15,30);
        $this->SetFontSize(6);
        $this->TextWithRotation(85, 48, utf8_decode("COMUNICACÍON "), 90, 0);
        $this->TextWithDirection(88, 46, 'Y LENGUAJES', 'U');
        $this->TextWithRotation(101, 44, utf8_decode("LENGUA"), 90, 0);
        $this->TextWithDirection(105, 46, 'EXTRANJERA', 'U');
        $this->TextWithRotation(115, 44, utf8_decode("CIENCIAS"), 90, 0);
        $this->TextWithDirection(120, 45, 'SOCIALES', 'U');
        $this->TextWithRotation(130, 46, utf8_decode("EDUCACIÓN"), 90, 0);
        $this->TextWithDirection(133, 45, 'FISICA', 'U');
        $this->TextWithDirection(136, 46, 'Y DEPORTES', 'U');
        $this->TextWithDirection(145, 46, utf8_decode("EDUCACIÓN"), 'U');
        $this->TextWithDirection(148, 45, 'MUSICAL', 'U');
        $this->TextWithDirection(160, 45, 'ARTES', 'U');
        $this->TextWithDirection(163, 46, 'PLASTICAS', 'U');
        $this->TextWithDirection(166, 48, 'Y VISUALES', 'U');
        $this->TextWithDirection(180, 48, 'MATEATICAS', 'U');
        $this->TextWithDirection(190, 45, 'TECNICA', 'U');
        $this->TextWithDirection(194, 48, 'TECNOLOGICA', 'U');
        $this->TextWithDirection(205, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(208, 48, 'NATURALES', 'U');
        $this->TextWithDirection(212, 48, 'BIOLOGICAS', 'U');
        $this->TextWithDirection(225, 45, 'FISICA', 'U');
        $this->TextWithDirection(240, 45, 'QUIMICA', 'U');
        $this->TextWithDirection(250, 49, 'COSMOVISIONES', 'U');
        $this->TextWithDirection(255, 45, 'FILOSOFIA', 'U');
        $this->TextWithDirection(258, 46, 'PSICOLOGIA', 'U');
        $this->SetFontSize(5);
        $this->TextWithDirection(265, 45, 'VALORES', 'U');
        $this->TextWithDirection(268, 49, 'ESPIRITUALIDADES', 'U');
        $this->TextWithDirection(272, 48, 'Y RELIGIONES', 'U');
        $this->SetFontSize(8);
        $this->TextWithDirection(284, 48, 'PROMEDIO', 'U');
        $this->SetFontSize(6);
        for ($n = 1; $n <= 14; $n++) {
            $this->Cell(15, 20, '', 1);
        }
        $this->ln();
        $this->SetX(80);
        $num = 83;
        $num2 = 0;
        for ($n = 1; $n <= 14; $n++) {
            $this->TextWithDirection($num + $num2, 59, '1 TRIM', 'U');
            $this->TextWithDirection($num + 5 + $num2, 59, '2 TRIM', 'U');
            $this->TextWithDirection($num + 10 + $num2, 59, '3 TRIM', 'U');
            $num2 += 15;
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
        }
        $this->ln();
        // llenado de datos
        for ($n = 1; $n <= 2; $n++) {
            $this->SetX(15);
            $this->Cell(5, 10, "$n", 1);
            $this->Cell(20, 10, " ", 1);
            $this->Cell(20, 10, " ", 1);
            $this->Cell(20, 10, " ", 1);
            for ($n = 1; $n <= 42; $n++) {
                $this->Cell(5, 10, "  ", 1);
            }
            $this->ln();
        }

        // $this->Cell(20,10,"BAUTISTA",1);
        // $this->Cell(20,10,"HUANCA",1);
        // $this->Cell(20,10,"JHON BRAYAN",1);
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

//$pdf = new FPDF('P', 'mm', array(100,150));

// $pdf = new PDF('L', 'mm', array(300, 200));
// $pdf=new RPDF();
// $pdf->AddPage();
// $pdf->Header();
// $pdf->Tabla();

// $this->SetFontSize(30);
//echo $name;
// $pdf->Output();
//print "<script>window.location=\"".$name."\";</script>";
