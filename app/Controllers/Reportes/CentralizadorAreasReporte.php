<?php

namespace App\Controllers\Reportes;

use FPDF;

class CentralizadorAreasReporte extends FPDF
{
    public $fecha;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->fecha = new \DateTime();
    }

    public function imprimir($data, $paralelo, $gestion)
    {
        $this->AddPage('L', 'legal');
        $this->Image("img/images/logo_oficial.png", 50 ,11, 15 , 15,'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('CENTRALIZADOR DE AREAS'), 0, 1, 'C', 0);
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
        $this->Cell(70,5,utf8_decode($paralelo),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30,5,$gestion,0,0,'L',0);
        $this->Ln(7);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,'',0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'IMPRESO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,$this->fecha->format('d-m-Y H:i'),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(10);
        //Cabecera de la tabla//
        $this->Tabla($data);
        // imprimir fechas //
//        $this->imprimirFechas($fechas);
        $this->Output();
    }

    function Tabla()
    {
        $this->SetX(10);
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
            $this->SetX(10);
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

}// class
