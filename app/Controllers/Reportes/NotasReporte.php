<?php

namespace App\Controllers\Reportes;

use FPDF;

class NotasReporte extends FPDF
{
    public function encabezado_posgraduante($lista_programa_modulo_paralelo_fila = null)
    {
        $this->Ln(4);
        $this->SetFont('Arial', 'I', 15);
        $this->Cell(0, 3, utf8_decode('titulo va aqui'), 0, 1, 'C', 0);
        $this->Ln(2);
        $this->SetFont('Arial', 'I', 7);
        // $this->datos_encabezado($lista_programa_modulo_paralelo_fila);
        $this->Ln(4);
        $this->SetTextColor(255, 255, 255, 255); //Color de texto
        $this->SetFillColor(14, 10, 87, 0.75); //Color de relleno    
        $this->SetDrawColor(235, 238, 245, 1); //Color de borde
        $this->Cell(10, 5, utf8_decode('Nro'), 'L R B', 0, 'L', 1);
        $this->Cell(20, 5, utf8_decode('C.I.'), 'L R B', 0, 'L', 1);
        $this->Cell(20, 5, utf8_decode('R.U.'), 'L R B', 0, 'L', 1);
        $this->Cell(30, 5, utf8_decode('PATERNO'), 'L R B', 0, 'L', 1);
        $this->Cell(30, 5, utf8_decode('MATERNO'), 'L R B', 0, 'L', 1);
        $this->Cell(30, 5, utf8_decode('NOMBRES'), 'L R B', 0, 'L', 1);
        $this->Cell(15, 5, utf8_decode('CEL'), 'L R B', 0, 'L', 1);
        $this->Cell(30, 5, utf8_decode('CORREO ELECTRÓNICO'), 'L R B', 1, 'L', 1);
    }
    public function imp()
    {
        $this->AddPage('P', 'letter');
        $this->encabezado_posgraduante();
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
        $this->Output();
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
