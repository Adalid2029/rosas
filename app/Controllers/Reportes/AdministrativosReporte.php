<?php
namespace App\Controllers\Reportes;

use FPDF;

class AdministrativosReporte extends FPDF
{

    public function imprimir($data = null)
    {
        $this->AddPage('P', 'letter');
        $this->Image("img/images/logo_oficial.png", 49 ,5, 17 , 17,'PNG');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 3, utf8_decode('UNIDAD EDUCATIVA "LAS ROSAS"'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 3, utf8_decode('ADMINISTRATIVOS'), 0, 1, 'C', 0);

        $header = array(
            utf8_decode('Nº'),
            utf8_decode('CI'),
            utf8_decode('Nombres y Apellidos'),
            utf8_decode('Nacimiento'),
            utf8_decode('Telefono'),
            utf8_decode('Sexo'),
            utf8_decode('Cargo'),
            utf8_decode('Año ingreso')
        );

        $this->Ln(10);
        $this->SetX(8);
        $this->SetFont('Arial', '', 9);
        $this->imprimirAdministrativos($header, $data);
        $this->Output();
    }

    function imprimirAdministrativos($header, $data)
    {
        $this->SetX(8);
        $this->SetFillColor(105, 105, 105);
        $this->SetTextColor(255);
        $this->SetDrawColor(105, 105, 105);
        $this->SetLineWidth(.3);

        // Header
        $w = array(8, 19, 64, 17, 25, 11, 30, 25);
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
                $this->Cell($w[3], 8, utf8_decode($data[$i]['nacimiento']), 'LR', 0, 'L', $fill);
                $this->Cell($w[4], 8, utf8_decode($data[$i]['telefono']), 'LR', 0, 'C', $fill);
                $this->Cell($w[5], 8, utf8_decode($data[$i]['sexo']), 'LR', 0, 'C', $fill);
                $this->Cell($w[6], 8, utf8_decode($data[$i]['cargo']), 'LR', 0, 'C', $fill);
                $this->Cell($w[7], 8, utf8_decode($data[$i]['gestion_ingreso']), 'LR', 0, 'C', $fill);

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

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        if ($fill || $border == 1) {
            if ($fill)
                $op = ($border == 1) ? 'B' : 'f';
            else
                $op = 'S';
            $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if ($txt != '') {
            if ($align == 'R')
                $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
            elseif ($align == 'C')
                $dx = ($w - $this->GetStringWidth($txt)) / 2;
            elseif ($align == 'FJ') {
                //Set word spacing
                $wmax = ($w - 2 * $this->cMargin);
                $this->ws = ($wmax - $this->GetStringWidth($txt)) / substr_count($txt, ' ');
                $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                $dx = $this->cMargin;
            } else
                $dx = $this->cMargin;
            $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            if ($this->ColorFlag)
                $s .= 'q ' . $this->TextColor . ' ';
            $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt);
            if ($this->underline)
                $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
            if ($this->ColorFlag)
                $s .= ' Q';
            if ($link) {
                if ($align == 'FJ')
                    $wlink = $wmax;
                else
                    $wlink = $this->GetStringWidth($txt);
                $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $wlink, $this->FontSize, $link);
            }
        }
        if ($s)
            $this->_out($s);
        if ($align == 'FJ') {
            //Remove word spacing
            $this->_out('0 Tw');
            $this->ws = 0;
        }
        $this->lasth = $h;
        if ($ln > 0) {
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }

    // Reporte de maestros
    public function imprimirMaestros($data = null)
    {
        $this->AddPage('P', 'letter');
        $this->Image("img/images/logo_oficial.png", 49 ,5, 17 , 17,'PNG');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 3, utf8_decode('UNIDAD EDUCATIVA "LAS ROSAS"'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetFont('Arial', 'BU', 10);
        $this->Cell(0, 3, utf8_decode('MAESTROS'), 0, 1, 'C', 0);

        $header = array(
            utf8_decode('Nº'),
            utf8_decode('CI'),
            utf8_decode('Nombres y Apellidos'),
            utf8_decode('Nacimiento'),
            utf8_decode('Telefono'),
            utf8_decode('Sexo'),
            utf8_decode('Grado Académico')
        );

        $this->Ln(10);
        $this->SetX(15);
        $this->SetFont('Arial', '', 9);
        $this->imprimirMaestrosData($header, $data);
        $this->Output();
    }

    function imprimirMaestrosData($header, $data)
    {
        $this->SetX(15);
        $this->SetFillColor(105, 105, 105);
        $this->SetTextColor(255);
        $this->SetDrawColor(105, 105, 105);
        $this->SetLineWidth(.3);

        // Header
        $w = array(10, 18, 65, 22, 20, 15,35);
        for ($i = 0; $i < count($header); $i++){
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(192, 192, 192);
        $this->SetTextColor(0);

        // Data
        $this->SetX(15);
        $fill = false;
        if ($data != null) {

            for ($i = 0; $i < count($data); $i++) {
                $this->SetX(15);
                $this->SetFont('Arial', '', 8);
                $this->Cell($w[0], 8, $i+1, 'LR', 0, 'C', $fill);
                $this->Cell($w[1], 8, utf8_decode($data[$i]['ci']), 'LR', 0, 'C', $fill);
                $this->Cell($w[2], 8, utf8_decode($data[$i]['nombres_apellidos']), 'LR', 0, 'L', $fill);
                $this->Cell($w[3], 8, utf8_decode($data[$i]['nacimiento']), 'LR', 0, 'L', $fill);
                $this->Cell($w[4], 8, utf8_decode($data[$i]['telefono']), 'LR', 0, 'C', $fill);
                $this->Cell($w[5], 8, utf8_decode($data[$i]['sexo']), 'LR', 0, 'C', $fill);
                $this->Cell($w[6], 8, utf8_decode($data[$i]['grado_academico']), 'LR', 0, 'C', $fill);

                $this->Ln();

                $fill = !$fill;
            }
        } else {
            $this->SetX(15);
            $this->Cell(196, 8, "NO EXISTEN DATOS PARA MOSTRAR", 'LR', 0, 'C', false);
            $this->Ln();
        }



        // Closing line
        $this->SetX(15);
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}// class
