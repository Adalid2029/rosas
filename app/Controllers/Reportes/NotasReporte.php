<?php

namespace App\Controllers\Reportes;

use FPDF;

class NotasReporte extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'Letter')
    {
        parent::__construct($orientation, $unit, $size);
    }
    public function imprimir()
    {
        $this->AddPage('P', 'Letter');
        $this->Image("img/images/logo_oficial.png", 50, 14, 15, 15, 'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('CENTRALIZADOR INTERNO'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetX(40);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 5, 'UNIDAD EDUCATIVA: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35, 5, 'LAS ROSAS', 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, 'CURSO: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70, 5, utf8_decode('cursi' . ' "' . 'skdhasjld' . '" SECUNDARIA'), 0, 0, 'L', 0);
        $this->Ln(7);
        $this->SetX(40);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 5, 'DE: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35, 5, 'as' . ' a ' . 'as', 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45, 5, 'IMPRESO: ', 0, 0, 'R', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70, 5, date('d-m-Y H:i'), 0, 0, 'L', 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(10);
        //Cabecera de la tabla//
        $this->Tabla();
        // imprimir fechas //
        // $this->imprimirFechas($fechas);
        return $this->Output('S');
    }

    function Tabla()
    {
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(8, 43, utf8_decode("Nº"), 1, "", "C");
        $this->Cell(33, 43, "APELLIDO PATERNO", 1, "", "C");
        $this->Cell(33, 43, "APELLIDO MATERNO", 1, "", "C");
        $this->Cell(37, 43, "NOMBRES", 1, "", "C");
        $this->Cell(30, 10, "NOTA BIMESTRAL", 1, "", "C");
        $this->Cell(10, 43, "", 1, "", "C");
        $this->Cell(40, 43, "LITERAL", 1, "", "C");
        // $this->Ln();
        $this->SetXY(121, 43);
        $this->Cell(10, 33, "", 1, "", "C");
        $this->Cell(10, 33, "", 1, "", "C");
        $this->Cell(10, 33, "", 1, "", "C");
        $this->Ln();
        $this->SetX(130);
        $this->SetFont('Arial', '', 8);

        // $this->SetX(100);
        $x = 127;
        $this->TextWithDirection($x, 75, 'PRIMER TRIMESTRE', 'U');
        $this->TextWithDirection($x += 10, 75, 'SEGUNDO TRIMESTRE', 'U');
        $this->TextWithDirection($x += 10, 75, 'TERCER TRIMESTRE', 'U');
        $this->TextWithDirection($x += 10, 75, 'PROMEDIO ANUAL', 'U');

        $this->Ln();

        //$this->Cell(20.5,15,"FALTAS",1);
        // if (count($data) != 0) {

        //     // LLenado de datos
        //     //            var_dump($data[0][0]);
        //     $this->SetFont('Arial', '', 10);
        //     $tamanioCelda = array(8, 35, 35, 45, 6.5, 20.5);
        //     for ($i = 0; $i < count($data); $i++) :
        //         // se imprime el numero
        //         $this->Cell(8, 7, ($i + 1), 1, "", "C");
        //         // Se imprime: paterno, materno, $nombres
        //         for ($j = 0; $j < 3; $j++) :
        //             $this->Cell($tamanioCelda[$j + 1], 7, $data[$i][$j], 1);
        //         endfor;
        //         // se llena las: A, F, L, R
        //         $tam = count($data[$i]) - 7;
        //         for ($j = 3; $j < (3 + $tam); $j++) :
        //             $this->Cell($tamanioCelda[4], 7, $data[$i][$j], 1, "", "C");
        //         endfor;

        //         // Llenamos los espacios vacios
        //         $tam_asistencias = 20 - (count($data[$i]) - 7);
        //         for ($j = 0; $j < $tam_asistencias; $j++) :
        //             $this->Cell($tamanioCelda[4], 7, " ", 1, "", "C");
        //         endfor;

        //         // Llenamos las asistencia, retrasos, licencias y faltas totales
        //         for ($j = (count($data[$i]) - 4); $j < count($data[$i]); $j++) :
        //             $this->Cell($tamanioCelda[5], 7, $data[$i][$j], 1, "", "C");
        //         endfor;
        //         $this->Ln();
        //     endfor;
        // } else {
        //     $this->SetFont('Arial', '', 12);
        //     $this->Cell(335, 8, "No existen registros de asistencia", 1, "", "C");
        // }
    }

    function imprimirFechas($fechas)
    {
        $this->SetXY(133, 35);
        $valorx = 137;
        for ($i = 0; $i < count($fechas); $i++) {
            $this->fecha = new \DateTime($fechas[$i]["fecha"]);
            $this->TextWithDirection($valorx, 54, $this->fecha->format("d-m-Y"), 'U');
            $valorx = $valorx + 6.5;
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


    //***** Aquí comienza código para ajustar texto *************

    //***********************************************************

    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        //Get string width

        $str_width = $this->GetStringWidth($txt);


        //Calculate ratio to fit cell

        if ($w == 0)

            $w = $this->w - $this->rMargin - $this->x;

        $ratio = ($w - $this->cMargin * 2) / $str_width;


        $fit = ($ratio < 1 || ($ratio > 1 && $force));

        if ($fit) {

            if ($scale) {

                //Calculate horizontal scaling

                $horiz_scale = $ratio * 100.0;

                //Set horizontal scaling

                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {

                //Calculate character spacing in points

                $char_space = ($w - $this->cMargin * 2 - $str_width) / max($this->MBGetStringLength($txt) - 1, 1) * $this->k;

                //Set character spacing

                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }

            //Override user alignment (since text will fill up cell)

            $align = '';
        }


        //Pass on to Cell method
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }


    function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);
    }


    //Patch to also work with CJK double-byte text

    function MBGetStringLength($s)

    {

        if ($this->CurrentFont['type'] == 'Type0') {

            $len = 0;

            $nbbytes = strlen($s);

            for ($i = 0; $i < $nbbytes; $i++) {

                if (ord($s[$i]) < 128)

                    $len++;

                else {

                    $len++;

                    $i++;
                }
            }

            return $len;
        } else

            return strlen($s);
    }
}
