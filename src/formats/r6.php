<?php

require('fpdf/fpdf.php');
include('funclib.php');
include('dbcon.php');

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

// Page header
function Header()
{

	
	
}
// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-10);
	// Arial italic 8
	$this->SetFont('Arial','BI',8);
	// Page number
	$this->Cell(75,10,'Auto Generated By MIS Developed Software Development Cell',0,0,'L');
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
}

function WriteHTML($html)
{
    // HTML parser
$html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}


function BasicTable($header, $data)
{



	
}


function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}


}


// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(auto,6);
$pdf->SetTopMargin(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,7,"R06",0,0,'R');
	// Logo
	$pdf->Image('logo.png',8,16,195);
	// Arial bold 15
	/*$pdf->SetFont('Arial','B',15);
	// Move to the right
	$pdf->Cell(30);
	// Title
	$pdf->Cell(150,10,'Government College of Engineering, Jalgaon',1,0,'C');*/
	// Line break
	$pdf->Ln(34);
	$pdf->SetFont('Arial','B',14);

	$pdf->SetTextColor(255);
// Background color
$pdf->SetFillColor(0,0,0);
// Title
$pdf->Cell(190,7,"Marks List for Summer 2017",0,1,'C',true);



// Line break
	//$pdf->Ln(4);
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0);
	$pdf->SetFont('','B');
	$pdf->Cell(40,6,"Year and Programme : ",0,0,'L');
	$pdf->SetFont('','');
	//alert($cls);
	$pdf->Cell(40,6,"TY B.Tech",0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	$pdf->Cell(7,6,"",0,0,'L');
	$pdf->Cell(28,6,"Academic Year : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(40,6,"2016-17",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(20,6,"Semester : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(10,6,"EVEN",0,1,'L');

	$pdf->SetFont('','B');
	$pdf->Cell(15,6,"Branch : ",0,0,'L');
	$pdf->SetFont('','');
	//alert($cls);
	$pdf->Cell(70,6,"Electronics & Telecommunication Engineering",0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	$pdf->Cell(7,6,"",0,0,'L');
	$pdf->Cell(24,6,"Examination : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(39,6,"ESE - PR",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(15,6,"Credits : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(10,6,"3.0",0,1,'L');
	
	$pdf->SetFont('','B');
	$pdf->Cell(45,6,"Course Code and Name : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(110,6,"CO101 CFCP",0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	//LINE 4
	$pdf->SetFont('','B');
	$pdf->Cell(22,6,"Max. Marks : ",0,0,'L');
	$pdf->SetFont('','');
	
	$pdf->Cell(10,6,"50",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(32,6,"",0,1,'L');
	$pdf->SetFont('','B');
	$pdf->SetFont('');
	$pdf->SetFont('','B','9');
	$pdf->Cell(33,6,"PRN",1,0,'C');
	$pdf->Cell(90,6,"Name of Candidate",1,0,'C');
	$pdf->Cell(33,6,"Marks",1,0,'C');
	$pdf->Cell(33,6,"Sign",1,1,'C');
	
	/*******************HEADER******************************/
	$pdf->SetFont('Arial','',8);
	$pdf->SetFont('');
	//while start
	$i=0;
	while($i<78)
	{
		$pdf->Cell(33,6, "1441001",1,0,'C');
		$pdf->Cell(90,6, "ABHAY MISHRA",1,0,'L');	
		$pdf->Cell(33,6, "50",1,0,'C');
		$pdf->Cell(33,6,"",1,1,'C');
		$i=$i+1;
	}
	
		
	

	$pdf->Ln(12);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(60,5,"Course Teacher",0,0,'C');
	$pdf->Cell(170,5,"Course Coordinator",0,0,'C');
	$pdf->Output();
	
	?>
