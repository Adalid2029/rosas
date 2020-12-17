<?php

namespace App\Controllers\Reportes;

use FPDF;

class NotasReporte extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'Letter')
    {
        parent::__construct($orientation, $unit, $size);
    }
    public function imprimir($notas)
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
        $this->SetXY(10, 76);
        $this->SetWidths([8, 33, 33, 37, 10, 10, 10, 10, 40]);
        $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
        foreach ($notas as $key => $value) {
            $this->Row([$key + 1, $value['paterno'], $value['materno'], $value['nombres'], $value['nota1'], $value['nota2'], $value['nota3'], $value['nota_final'], $value['literal']]);
        }

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
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
}
