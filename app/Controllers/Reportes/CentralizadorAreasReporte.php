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
        $this->Image("img/images/logo_oficial.png", 50, 11, 15, 15, 'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('CENTRALIZADOR DE AREAS'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, 'UNIDAD EDUCATIVA: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35, 5, 'LAS ROSAS', 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, 'CURSO: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70, 5, utf8_decode($paralelo), 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 5, utf8_decode('GESTIÓN: '), 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 5, $gestion, 0, 0, 'L', 0);
        $this->Ln(7);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, '', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35, 5, '', 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, 'IMPRESO: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70, 5, $this->fecha->format('d-m-Y H:i'), 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(10);

        //Cabecera de la tabla//
        $curso = explode(' ', $paralelo);

        if (isset($curso[0]) && $curso[0] == "PRIMERO" || $curso[0] == "SEGUNDO") {
            // Imprimir para los paralelos primero y segundo de secundaria
            $this->TablaPrimeroSegundo($data);
        } else if ($curso[0] == "TERCERO" || $curso[0] == "CUARTO") {
            // Imprimir para los paralelos tercero y cuarto de secundaria
            $this->TablaTerceroCuarto($data);
        } else {
            // Imprimir para los paralelos quinto y sexto de secundaria
            $this->TablaQuintoSexto($data);
        }


        $this->Output();
    }

    function TablaPrimeroSegundo($data)
    {
        $this->SetX(25);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(5, 30, "N" . utf8_decode("°"), 1, null, "C");
        $this->TextWithDirection(38, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(38, 50, 'PATERNO', 'R');
        $this->TextWithDirection(74, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(74, 50, 'MATERNO', 'R');
        $this->TextWithDirection(108, 48, 'NOMBRES', 'R');
        for ($n = 1; $n <= 3; $n++) {
            $this->Cell(35, 30, "", 1);
        }
        // $this->SetXY(15,30);
        $this->SetFontSize(6);
        $this->TextWithRotation(142, 51, utf8_decode("COMUNICACÍON "), 90, 0);
        $this->TextWithDirection(145, 50, 'Y  LENGUAJES', 'U');

        $this->TextWithRotation(156, 48, utf8_decode("LENGUA"), 90, 0);
        $this->TextWithDirection(159, 50, 'EXTRANJERA', 'U');

        $this->TextWithRotation(172, 48, utf8_decode("CIENCIAS"), 90, 0);
        $this->TextWithDirection(175, 48, 'SOCIALES', 'U');

        $this->TextWithRotation(185, 49, utf8_decode("EDUCACIÓN"), 90, 0);
        $this->TextWithDirection(188, 46, 'FISICA', 'U');
        $this->TextWithDirection(191, 49, 'Y DEPORTES', 'U');

        $this->TextWithDirection(202, 49, utf8_decode("EDUCACIÓN"), 'U');
        $this->TextWithDirection(205, 47, 'MUSICAL', 'U');

        $this->TextWithDirection(215, 47, 'ARTES', 'U');
        $this->TextWithDirection(218, 49, 'PLASTICAS', 'U');
        $this->TextWithDirection(221, 49, 'Y VISUALES', 'U');

        $this->TextWithDirection(233, 51, 'MATEMATICAS', 'U');

        $this->TextWithDirection(245, 48, 'TECNICA', 'U');
        $this->TextWithDirection(248, 51, 'TECNOLOGICA', 'U');
        $this->TextWithDirection(251, 48, 'GENERAL', 'U');

        $this->TextWithDirection(261, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(264, 49, 'NATURALES', 'U');
        $this->TextWithDirection(267, 48, 'BIOLOGIA', 'U');
        $this->SetFontSize(5);
        $this->TextWithDirection(275, 47, 'VALORES', 'U');
        $this->TextWithDirection(278, 51, 'ESPIRITUALIDADES', 'U');
        $this->TextWithDirection(281, 49, 'Y RELIGIONES', 'U');

        $this->TextWithDirection(291, 51, 'COSMOVISIONES,', 'U');
        $this->TextWithDirection(294, 48, 'FILOSOFIA Y', 'U');
        $this->TextWithDirection(297, 49, 'PSICOLOGÍA', 'U');

        $this->SetFontSize(8);
        $this->TextWithDirection(308, 51, 'PROMEDIO', 'U');
        $this->SetFontSize(6);

        for ($n = 1; $n <= 12; $n++) {
            $this->Cell(15, 20, '', 1);
        }

        $this->ln();
        $this->SetX(135);
        $num = 138.2;
        $num2 = 0;
        for ($n = 1; $n <= 12; $n++) {
            $this->TextWithDirection($num + $num2, 61, '1 TRIM', 'U');
            $this->TextWithDirection($num + 5 + $num2, 61, '2 TRIM', 'U');
            $this->TextWithDirection($num + 10 + $num2, 61, '3 TRIM', 'U');
            $num2 += 15;
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
        }

        $this->ln();

        // llenado de datos

        for ($k = 0; $k < count($data); $k++) {
            $this->SetFontSize(8);
            $this->SetX(25);
            $this->Cell(5, 6, $k+1, 1, null, "C");

            for ($z = 0; $z < 3; $z++)
            {
                $this->Cell(35, 6, $data[$k][$z], 1);
            }

            for ($x = 3; $x <= 38; $x++) {
                $this->SetFontSize(7);
                $this->Cell(5, 6, $data[$k][$x], 1, null, "C");
            }
            $this->ln();
        }
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

    // Cursos de tercero y cuarto de secundaria
    function TablaTerceroCuarto($data)
    {
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(5, 30, "N" . utf8_decode("°"), 1, null, "C");
        $this->TextWithDirection(28, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(28, 50, 'PATERNO', 'R');
        $this->TextWithDirection(64, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(64, 50, 'MATERNO', 'R');
        $this->TextWithDirection(98, 48, 'NOMBRES', 'R');
        for ($n = 1; $n <= 3; $n++) {
            $this->Cell(35, 30, "", 1);
        }
        // $this->SetXY(15,30);
        $this->SetFontSize(6);
        $this->TextWithRotation(132, 51, utf8_decode("COMUNICACÍON "), 90, 0);
        $this->TextWithDirection(135, 50, 'Y  LENGUAJES', 'U');

        $this->TextWithRotation(146, 48, utf8_decode("LENGUA"), 90, 0);
        $this->TextWithDirection(148, 50, 'EXTRANJERA', 'U');

        $this->TextWithRotation(161, 48, utf8_decode("CIENCIAS"), 90, 0);
        $this->TextWithDirection(163, 48, 'SOCIALES', 'U');

        $this->TextWithRotation(175, 49, utf8_decode("EDUCACIÓN"), 90, 0);
        $this->TextWithDirection(178, 46, 'FISICA', 'U');
        $this->TextWithDirection(181, 49, 'Y DEPORTES', 'U');

        $this->TextWithDirection(192, 49, utf8_decode("EDUCACIÓN"), 'U');
        $this->TextWithDirection(195, 47, 'MUSICAL', 'U');

        $this->TextWithDirection(205, 47, 'ARTES', 'U');
        $this->TextWithDirection(208, 49, 'PLASTICAS', 'U');
        $this->TextWithDirection(211, 49, 'Y VISUALES', 'U');

        $this->TextWithDirection(223, 51, 'MATEMATICAS', 'U');

        $this->TextWithDirection(235, 48, 'TECNICA', 'U');
        $this->TextWithDirection(238, 51, 'TECNOLOGICA', 'U');
        $this->TextWithDirection(241, 48, 'GENERAL', 'U');

        $this->TextWithDirection(250, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(253, 49, 'NATURALES', 'U');
        $this->TextWithDirection(256, 47, 'FISICA', 'U');

        $this->TextWithDirection(265, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(268, 49, 'NATURALES', 'U');
        $this->TextWithDirection(271, 48, 'QUIMICA', 'U');

        $this->TextWithDirection(280, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(283, 49, 'NATURALES', 'U');
        $this->TextWithDirection(286, 48, 'BIOLOGIA', 'U');
        $this->SetFontSize(5);
        $this->TextWithDirection(296, 47, 'VALORES', 'U');
        $this->TextWithDirection(299, 51, 'ESPIRITUALIDADES', 'U');
        $this->TextWithDirection(302, 49, 'Y RELIGIONES', 'U');

        $this->TextWithDirection(310, 51, 'COSMOVISIONES,', 'U');
        $this->TextWithDirection(313, 48, 'FILOSOFIA Y', 'U');
        $this->TextWithDirection(316, 49, 'PSICOLOGÍA', 'U');

        $this->SetFontSize(8);
        $this->TextWithDirection(328, 51, 'PROMEDIO', 'U');
        $this->SetFontSize(6);

        for ($n = 1; $n <= 14; $n++) {
            $this->Cell(15, 20, '', 1);
        }

        $this->ln();
        $this->SetX(125);
        $num = 128;
        $num2 = 0;
        for ($n = 1; $n <= 14; $n++) {
            $this->TextWithDirection($num + $num2, 61, '1 TRIM', 'U');
            $this->TextWithDirection($num + 5 + $num2, 61, '2 TRIM', 'U');
            $this->TextWithDirection($num + 10 + $num2, 61, '3 TRIM', 'U');
            $num2 += 15;
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
        }

        $this->ln();

        for ($k = 0; $k < count($data); $k++) {
            $this->SetFontSize(8);
            $this->SetX(15);
            $this->Cell(5, 6, $k+1, 1, null, "C");

            for ($z = 0; $z < 3; $z++)
            {
                $this->Cell(35, 6, $data[$k][$z], 1);
            }

            for ($x = 3; $x <= 44; $x++) {
                $this->SetFontSize(7);
                $this->Cell(5, 6, $data[$k][$x], 1, null, "C");
            }
            $this->ln();
        }
    }

    // Cursos de quinto y sexto de secundaria
    function TablaQuintoSexto($data)
    {
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(5, 30, "N" . utf8_decode("°"), 1, null, "C");
        $this->TextWithDirection(28, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(28, 50, 'PATERNO', 'R');
        $this->TextWithDirection(64, 45, 'APELLIDO', 'R');
        $this->TextWithDirection(64, 50, 'MATERNO', 'R');
        $this->TextWithDirection(98, 48, 'NOMBRES', 'R');
        for ($n = 1; $n <= 3; $n++) {
            $this->Cell(35, 30, "", 1);
        }
        // $this->SetXY(15,30);
        $this->SetFontSize(6);
        $this->TextWithRotation(132, 51, utf8_decode("COMUNICACÍON "), 90, 0);
        $this->TextWithDirection(135, 50, 'Y  LENGUAJES', 'U');

        $this->TextWithRotation(146, 48, utf8_decode("LENGUA"), 90, 0);
        $this->TextWithDirection(148, 50, 'EXTRANJERA', 'U');

        $this->TextWithRotation(161, 48, utf8_decode("CIENCIAS"), 90, 0);
        $this->TextWithDirection(163, 48, 'SOCIALES', 'U');

        $this->TextWithRotation(175, 49, utf8_decode("EDUCACIÓN"), 90, 0);
        $this->TextWithDirection(178, 46, 'FISICA', 'U');
        $this->TextWithDirection(181, 49, 'Y DEPORTES', 'U');

        $this->TextWithDirection(192, 49, utf8_decode("EDUCACIÓN"), 'U');
        $this->TextWithDirection(195, 47, 'MUSICAL', 'U');

        $this->TextWithDirection(205, 47, 'ARTES', 'U');
        $this->TextWithDirection(208, 49, 'PLASTICAS', 'U');
        $this->TextWithDirection(211, 49, 'Y VISUALES', 'U');

        $this->TextWithDirection(223, 51, 'MATEMATICAS', 'U');

        $this->TextWithDirection(235, 48, 'TECNICA', 'U');
        $this->TextWithDirection(238, 51, 'TECNOLOGICA', 'U');
        $this->TextWithDirection(241, 52, ' ESPECIALIZADA', 'U');

        $this->TextWithDirection(250, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(253, 49, 'NATURALES', 'U');
        $this->TextWithDirection(256, 47, 'FISICA', 'U');

        $this->TextWithDirection(265, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(268, 49, 'NATURALES', 'U');
        $this->TextWithDirection(271, 48, 'QUIMICA', 'U');

        $this->TextWithDirection(280, 48, 'CIENCIAS', 'U');
        $this->TextWithDirection(283, 49, 'NATURALES', 'U');
        $this->TextWithDirection(286, 48, 'BIOLOGIA', 'U');
        $this->SetFontSize(5);
        $this->TextWithDirection(296, 47, 'VALORES', 'U');
        $this->TextWithDirection(299, 51, 'ESPIRITUALIDADES', 'U');
        $this->TextWithDirection(302, 49, 'Y RELIGIONES', 'U');

        $this->TextWithDirection(310, 51, 'COSMOVISIONES,', 'U');
        $this->TextWithDirection(313, 48, 'FILOSOFIA Y', 'U');
        $this->TextWithDirection(316, 49, 'PSICOLOGÍA', 'U');

        $this->SetFontSize(8);
        $this->TextWithDirection(328, 51, 'PROMEDIO', 'U');
        $this->SetFontSize(6);

        for ($n = 1; $n <= 14; $n++) {
            $this->Cell(15, 20, '', 1);
        }

        $this->ln();
        $this->SetX(125);
        $num = 128;
        $num2 = 0;
        for ($n = 1; $n <= 14; $n++) {
            $this->TextWithDirection($num + $num2, 61, '1 TRIM', 'U');
            $this->TextWithDirection($num + 5 + $num2, 61, '2 TRIM', 'U');
            $this->TextWithDirection($num + 10 + $num2, 61, '3 TRIM', 'U');
            $num2 += 15;
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
            $this->Cell(5, 10, "", 1);
        }

        $this->ln();
        // llenado de datos
        for ($k = 0; $k < count($data); $k++) {
            $this->SetFontSize(8);
            $this->SetX(15);
            $this->Cell(5, 6, $k+1, 1, null, "C");

            for ($z = 0; $z < 3; $z++)
            {
                $this->Cell(35, 6, $data[$k][$z], 1);
            }

            for ($x = 3; $x <= 44; $x++) {
                $this->SetFontSize(7);
                $this->Cell(5, 6, $data[$k][$x], 1, null, "C");
            }
            $this->ln();
        }
    }
}// class
