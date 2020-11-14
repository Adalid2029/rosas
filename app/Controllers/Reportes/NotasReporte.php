<?php

namespace App\Controllers\Reportes;

use FPDF;

class NotasReporte extends FPDF
{
    public function imp()
    {
        $this->AddPage('P', 'letter');
        // $this->encabezado_posgraduante($datos_programa);
        $this->AliasNbPages();
        $this->SetFillColor(229, 229, 229); // DEFINE EL COLOR// Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->SetLineWidth(0);
        //$this->SetFont('Arial', 'B', 10);


        $this->SetTextColor(0, 0, 0, 0); //Color de texto
        $this->SetFillColor(255, 255, 255, 255); //Color de relleno    
        $this->SetDrawColor(235, 238, 245, 1); //Color de borde
        if (!empty($lista_posgraduante)) {
            $x = 1;
            foreach ($lista_posgraduante as $lista_posgraduante_fila) {
                $this->AjustCell(10, 5, utf8_decode($x++), 1, 0, 'L', 1);
                $this->AjustCell(20, 5, utf8_decode($lista_posgraduante_fila->ci . ' ' . $lista_posgraduante_fila->expedido), 1, 0, 'L', 1);
                $this->AjustCell(20, 5, utf8_decode($lista_posgraduante_fila->registro_universitario), 1, 0, 'L', 1);
                $this->AjustCell(30, 5, utf8_decode($lista_posgraduante_fila->paterno), 1, 0, 'L', 1);
                $this->AjustCell(30, 5, utf8_decode($lista_posgraduante_fila->materno), 1, 0, 'L', 1);
                $this->AjustCell(30, 5, utf8_decode($lista_posgraduante_fila->nombre), 1, 0, 'L', 1);
                $this->AjustCell(15, 5, utf8_decode($lista_posgraduante_fila->celular), 1, 0, 'L', 1);
                $this->AjustCell(30, 5, utf8_decode($lista_posgraduante_fila->email), 1, 1, 'L', 1);
            }
        }
    }
    function AjustCell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $TamanoInicial = $this->FontSizePt;
        $TamanoLetra = $this->FontSizePt;
        $Decremento = 0.5;
        while ($this->GetStringWidth($txt) > $w)
            $this->SetFontSize($TamanoLetra -= $Decremento);
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        $this->SetFontSize($TamanoInicial);
    }
}
