<?php

namespace App\Controllers\Reportes;

use FPDF;

class AsistenciaReporte extends FPDF
{
    public $fecha;
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->fecha = new \DateTime();
    }

    public function imprimir($data, $curso, $fechaInicial, $fechaFinal, $fechas)
    {
        $this->AddPage('L', 'legal');
        $this->Image("img/images/logo_oficial.png", 50 ,14, 15 , 15,'PNG', '');
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 3, utf8_decode('CUADRO DE ASISTENCIA'), 0, 1, 'C', 0);
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
        $this->Cell(70,5,utf8_decode($curso[0] .' "'.$curso[1] . '" SECUNDARIA'),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30,5,'2020',0,0,'L',0);
        $this->Ln(7);
        $this->SetX(70);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'DE: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(35,5,$fechaInicial . ' a ' . $fechaFinal,0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(45,5,'IMPRESO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(70,5,$this->fecha->format('d-m-Y H:i'),0,0,'L',0);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(10);
        //Cabecera de la tabla//
        // imprimir fechas //
        $this->SetX(133);
        $valorx = 137;
        for ($i = 0; $i < count($fechas); $i++)
        {
            $this->SetFont('Arial', '', 10);
            $this->fecha = new \DateTime($fechas[$i]["fecha"]);
            $this->TextWithDirection($valorx, 54, $this->fecha ->format("d-m-Y"), 'U');
            $valorx = $valorx + 6.5;
        }

        $this->Tabla($data);

        $this->Output();
    }

    function Tabla($data)
    {
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(8,24,utf8_decode("Nº"),1, "", "C");
        $this->Cell(35,24,"AP. PATERNO",1, "", "C");
        $this->Cell(35,24,"AP. MATERNO",1, "", "C");
        $this->Cell(45,24,"NOMBRES",1, "", "C");
        for($i =0; $i <20; $i ++){
            $this->Cell(6.5,24,"",1);
        }
        $this->Cell(82,10,"TOTALES",1, "", "C");
        $this->Ln();
        $this->SetX(263);
        $this->SetFont('Arial', '', 8);
        $this->Cell(20.5,14,"ASISTENCIAS",1, "", "C");
        $this->Cell(20.5,14,"RETRASOS",1, "", "C");
        $this->Cell(20.5,14,"LICENCIAS",1, "", "C");
        $this->Cell(20.5,14,"FALTAS",1, "", "C");
        $this->Ln();

        //$this->Cell(20.5,15,"FALTAS",1);
        if(count($data) != 0){

            // LLenado de datos
//            var_dump($data[0][0]);
            $this->SetFont('Arial', '', 10);
            $tamanioCelda = array(8,35,35,45,6.5,20.5);
            for ($i = 0; $i < count($data); $i++):
                // se imprime el numero
                $this->Cell(8,7,($i+1),1, "", "C");
                // Se imprime: paterno, materno, $nombres
                for ($j = 0; $j < 3; $j++):
                    $this->Cell($tamanioCelda[$j+1],7,$data[$i][$j],1);
                endfor;
                // se llena las: A, F, L, R
                $tam = count($data[$i]) - 7;
                for ($j = 3; $j < (3 + $tam); $j++):
                    $this->Cell($tamanioCelda[4],7,$data[$i][$j],1, "", "C");
                endfor;

                // Llenamos los espacios vacios
                $tam_asistencias = 20 - (count($data[$i])-7);
                for ($j = 0; $j < $tam_asistencias; $j++):
                    $this->Cell($tamanioCelda[4],7," ",1, "", "C");
                endfor;

                // Llenamos las asistencia, retrasos, licencias y faltas totales
                for ($j = (count($data[$i])-4); $j < count($data[$i]); $j++):
                    $this->Cell($tamanioCelda[5],7,$data[$i][$j],1, "", "C");
                endfor;
                $this->Ln();
            endfor;
        }else{
            $this->SetFont('Arial', '', 12);
            $this->Cell(335,8,"No existen registros de asistencia",1, "", "C");

        }



    }

    function imprimirFechas($fechas)
    {

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

}
