<?php

namespace App\Controllers\Reportes;
use FPDF;

class SeguimientoReporte extends FPDF
{
    public $fecha;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->fecha = new \DateTime();
    }

    public function imprimir($data, $fechaInicial, $fechaFinal, $faltas, $nombre_completo, $curso_paralelo, $fechas)
    {
        $this->AddPage('P', 'letter');
        $this->Image("img/images/logo_oficial.png", 10 ,10, 17 , 18,'PNG', '');
        $this->SetFont('Arial', 'BU', 12);
        $this->Cell(0, 3, utf8_decode('SEGUIMIENTO ACADÉMICO'), 0, 1, 'C', 0);
        $this->Ln();
        $this->SetX(28);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(43,5,'UNIDAD EDUCATIVA: ',0,0,'R',0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(28,5,'LAS ROSAS',0,0,'L',0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(24,5,'CURSO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(52,5,$curso_paralelo,0,0,'L',0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(17,5,utf8_decode('GESTIÓN: '),0,0,'R',0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(17,5,'2020',0,0,'L',0);
        $this->Ln(7);
        $this->SetX(28);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(24,5,'ESTUDIANTE: ',0,0,'R',0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(62,5,utf8_decode($nombre_completo),0,0,'L',0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10,5,'DE: ',0,0,'R',0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(37,5,$fechaInicial . ' a ' . $fechaFinal,0,0,'L',0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(17,5,'IMPRESO: ',0,0,'R',0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(24,5,$this->fecha->format('d-m-Y H:i'),0,0,'L',0);
        $this->Ln(10);
        $this->tabla($data, $fechas);
        $this->imprimirFaltas($faltas);
        $this->Output();
    }

    public function tabla($data, $fechas)
    {
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(5,55,utf8_decode("Nº"),1, "", "C");
        $this->Cell(15,55,"FECHA",1, "", "C");
        $this->Cell(60,55,utf8_decode("ÁREA"),1, "", "C");

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(65,5,utf8_decode("ASPECTO DISCIPLINARIO"),1, "", "C");
        $this->Cell(52,5,utf8_decode("ASPECTO PEDAGÓGICO"),1, "", "C");
        $this->Ln();
        $this->SetX(90);
        for($i =0; $i <18; $i ++){
            $this->Cell(6.5,50,"",1);
        }
        $this->Ln();
        if (count($fechas)== 0){
            $this->SetFont('Arial', '', 9);
            $this->Cell(196.2,7,utf8_decode("NO EXISTEN DATOS EN LA CONSULTA SOLICITADA"),1, "", "C");
        }else{
            // llenado de datos
            $anchoColumnas = array(5,15,60,6.5);
            for ($z = 0; $z < count($data); $z++)
            {
                $this->SetFont('Arial', '', 7);
                $this->Cell($anchoColumnas[0],7,utf8_decode($z+1),1, "", "C");
                for ($j = 0; $j<= 1; $j++)
                {
                    $this->Cell($anchoColumnas[$j+1],7,utf8_decode($data[$z][$j]),1, "", "C");
                }

                for($i =2; $i < 20; $i ++){
                    if ($data[$z][$i] == "0")
                    {
                        $llenar = "";
                        $fill = false;
                    }else{
                        $llenar = "x";
                        $fill = true;
                    }
                    $this->Cell($anchoColumnas[3],7,$llenar,1, "", "C", $fill);
                    $fill = false;
                }
                $this->Ln();
            }

        }



    }

    function imprimirFaltas($faltas)
    {
        $valorx = 94;
        for ($i = 0; $i < count($faltas); $i++)
        {
            $this->SetFont('Arial', '', 5.5);
            $this->TextWithDirection($valorx, 86, utf8_decode($faltas[$i]["descripcion"]), 'U');
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

    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)

    {

        //Get string width

        $str_width=$this->GetStringWidth($txt);


        //Calculate ratio to fit cell

        if($w==0)

            $w = $this->w-$this->rMargin-$this->x;

        $ratio = ($w-$this->cMargin*2)/$str_width;


        $fit = ($ratio < 1 || ($ratio > 1 && $force));

        if ($fit)

        {

            if ($scale)

            {

                //Calculate horizontal scaling

                $horiz_scale=$ratio*100.0;

                //Set horizontal scaling

                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));

            }

            else

            {

                //Calculate character spacing in points

                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;

                //Set character spacing

                $this->_out(sprintf('BT %.2F Tc ET',$char_space));

            }

            //Override user alignment (since text will fill up cell)

            $align='';

        }


        //Pass on to Cell method

        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);


        //Reset character spacing/horizontal scaling

        if ($fit)

            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');

    }


    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')

    {

        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);

    }


    //Patch to also work with CJK double-byte text

    function MBGetStringLength($s)

    {

        if($this->CurrentFont['type']=='Type0')

        {

            $len = 0;

            $nbbytes = strlen($s);

            for ($i = 0; $i < $nbbytes; $i++)

            {

                if (ord($s[$i])<128)

                    $len++;

                else

                {

                    $len++;

                    $i++;

                }

            }

            return $len;

        }

        else

            return strlen($s);

    }

//************** Fin del código para ajustar texto *****************

//******************************************************************


}// class
