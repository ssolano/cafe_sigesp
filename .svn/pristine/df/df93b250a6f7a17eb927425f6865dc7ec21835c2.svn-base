<?php
session_start();
require('../comunes/php/fpdf.php');
require_once '../controlador/Conexion.php';


class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w){
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a){
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data){
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++){
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        $h=4*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++){
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h,'DF');
            //Print the text
            $this->MultiCell($w,4,$data[$i],0,$a,0);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger){
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w,$txt){
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0){
            $w=$this->w-$this->rMargin-$this->x;
        }
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n"){
            $nb--;
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' '){
                $sep=$i;
            }
            $l+=$cw[$c];
            if($l>$wmax){
                if($sep==-1){
                    if($i==$j){
                        $i++;
                    }
                }else{
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }else{
                $i++;
            }
        }
        return $nl;
    }
}
class PDF  extends PDF_MC_Table
{
	function Header()
	{
		//Logo
		$this->Image('../comunes/images/logocvc.jpg',12,10,30,15);
		//Select Arial bold 15
		$this->SetFont('Arial','B',12);
		//Move to the right
		$this->Cell(80);
		//Framed title
		$this->SetX(12);
		$this->Cell(265,15,'CAFICULTORES REGISTRADOS',0,0,'C');
		//Line break		
		$this->Ln(15);		
		$this->SetFont('Arial','B',10);
		$filtro=substr($_SESSION["filtro3_sac"],0,strlen($_SESSION["filtro3_sac"])-2);
		$this->MultiCell(250,5,utf8_decode($filtro),0,'J');
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->SetFillColor(21,99,54);
		$this->SetTextColor(255,255,255);
		$this->SetDrawColor(0);
		$this->SetLineWidth(.3);  
		$this->SetWidths(array(260));
		$this->SetAligns(array('C'));
		$this->Row(array('DATOS DEL CAFICULTOR'));
		
		$this->SetWidths(array(30,30,30,30,50,30,30,30,30));
        $this->SetAligns(array('C','C', 'C','C','C', 'C', 'C','C'));
		$this->Row(array('FECHA DEL REGISTRO','ESTADO','MUNICIPIO','PARROQUIA','NOMBRE Y APELLIDO','CEDULA / RIF','TELEFONO','TIPO CAFICULTOR'));


	}

	function Footer()
	{
		//Go to 1.5 cm from bottom
		$this->SetY(-15);		
		$this->SetFont('Arial','B',5);
		//Print centered page number
		$this->Cell(245,10,'Generado a través del Sistema de Atención Integral para la Gestión de Caficultores en Fecha '.date('d/m/Y').' por el Usuario '.utf8_decode($_SESSION["strnombresac"]).' '.utf8_decode($_SESSION["strapellidosac"]).'  |  Fuente: Gerencia de Tecnologia - '.date('Y').'  |  Licencia: GPL/GNU',0,0,'L');
		$this->Cell(20,10,utf8_decode('PÃ¡gina '.$this->PageNo().'/{nb}'),0,0,'R');
	}


}
ob_end_clean();
$pdf=new PDF("L","mm","letter");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetMargins(10,10,3);
$pdf->SetFont('Arial','',10);
$pdf->AddPage();		
$textout='';
						
		$sql="select b.strnombre || ' '|| b.strapellido as beneficiario, b.*, e.strdescripcion as estado, m.strdescripcion as municipio, p.strdescripcion as parroquia,
		case when b.\"id_ctaBanco_maestro\"!=0 then
		(select stritema from tblmaestros s where s.id_maestro=b.\"id_ctaBanco_maestro\" and s.bolborrado=0)
		else
		 'N/A'
		end as ctaBanco,
		u.strnombre || ' ' || u.strapellido as usuario, t.stritema as tipo, to_char(b.dtmfecha_nac,'DD/MM/YYYY') as fecha_nac,
		to_char(b.dtmfecha_registro,'DD/MM/YYYY') as fecha_registro, to_char(b.dtmfecha_modificado,'DD/MM/YYYY') as fecha_modificado
		from tblbeneficiario b, tblestado e, tblmunicipio m, tblparroquia p, tblusuario u, tblmaestros t
		where b.id_estado=e.id_estado and b.id_municipio=m.id_municipio and b.id_parroquia=p.id_parroquia
		and b.id_usuario=u.id_usuario and b.id_tipo_maestro=t.id_maestro
		and b.bolborrado=0 and e.bolborrado=0 and m.bolborrado=0 and p.bolborrado=0 and u.bolborrado=0 and t.bolborrado=0 ORDER BY id_beneficiario ASC";
		
        $conn= new Conexion();
        $conn->abrirConexion();
		$conn->sql=$sql;
        $data=$conn->ejecutarSentencia(2);
		$fila_tabla=1;
				
		if ($data){
			for ($i= 0; $i < count($data); $i++){
				$pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial','',5);
                $pdf->SetAligns(array('C', 'C','C', 'C', 'C', 'C','C', 'C', 'C', 'C', 'C', 'C', 'C', 'C','C','C','C','C'));
                $pdf->Row(array(utf8_decode(trim($data[$i]["dtmfecha_registro"])),utf8_decode(trim($data[$i]["estado"])), utf8_decode(trim($data[$i]["municipio"])), utf8_decode(trim($data[$i]["parroquia"])), $data[$i]["beneficiario"],utf8_decode(trim($data[$i]['strcedula'])),utf8_decode(trim($data[$i]["strtelefono"])),utf8_decode(trim($data[$i]['tipo']))));
			}
			$pdf->SetWidths(array(260));
			$pdf->SetAligns(array('R','R'));
			$pdf->SetFont('Arial','B',7);
			$pdf->Row(array('Total de Caficultores Registrados '.$i));
            $pdf->Output();
		}else{
            //echo "<script>alert('No existen registros para mostrar');window.close(this);</script>";
        }
        $conn->cerrarConexion();
		$pdf->Output();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
</body>
</html>
