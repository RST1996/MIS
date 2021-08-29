<?php
error_reporting(0);
require('fpdf/fpdf.php');
		//alert($m_pemail);
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

// Page header
function Header()
{
	// Logo
	$this->Image('logo.png',8,6,195);
	// Arial bold 15
	/*$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(30);
	// Title
	$this->Cell(150,10,'Government College of Engineering, Jalgaon',1,0,'C');*/
	// Line break
	$this->Ln(25);
}
// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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



    $this->SetFont('','B');
	// Header
    //foreach($header as $col)
		$this->Cell(10,7,"SN",1,0,'C');
        $this->Cell(50,7,"Course Code",1,0,'C');
		$this->Cell(50,7,"Course Name",1,0,'C');
		$this->Cell(25,7,"Credits",1,0,'C');
		$this->Cell(50,7,"Sub Type",1,0,'C');
		//$this->Cell(25,7,"Category",1);
		//$this->Cell(25,7,"Remarks",1);
    $this->Ln();
    $this->SetFont('');
	$i=1;
	
	
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
$pdf->Image('photo.png',160,45,40,50);
// Arial 12
$pdf->SetFont('Arial','B',14);

$pdf->SetTextColor(255);
// Background color
$pdf->SetFillColor(0,0,0);
// Title
$pdf->Cell(190,7,"Registration Form",0,1,'C',true);
// Line break
$pdf->Ln(4);
//$pdf->SetFont('');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0);
//$i=1;
	//$pdf->Cell(15,10,'Name : '.$m_pname,0,0);
	$html = 'Name : <b>'.$m_pname.'</b><br>'
	.'Personal Contact Number : <b>'.$m_pc_no.'</b><br>'
	.'Parents Contact Number : <b>'.$m_psc_no.'</b><br>'
	.'Email : <b>'.$m_pemail.'</b><br>'
	.'Category : <b>'.$m_event.'</b>'
	.'      Gender : <b>'.$m_pgender.'</b><br>'
	.'Physically Handicapped : <b>'.$m_ph.'</b>'
	.'     Defence : <b>'.$m_def.'</b><br>'
	.'J & K / North Eastern Candidate : <b>'.$m_jk.'</b><br>'
	.'Current Year & Branch : <b>'.$m_pbranch.'</b><br>'
	.'Permanent Address : <b>'.$m_padd.'</b><br>'
	.'Local Address : <b>'.$m_ladd.'</b><br>'
	.'Latest Semester SGPA : <b>'.$m_pclgname.'</b><br>';
	$html3='To,<br><b>The Dean Academics,</b><br>Government College of Enginnering, Jalgaon - 425002<br><br><b>Respected Sir,</b><br>

        I request permission to register myself as a
<br>
<b>regular</b> student in the even semester of B.TECH.
<br>
during the academic year Summer 2017 and pay
<br>
herewith the prescribed fees Rs _________________<br><br><br>
<b>Date : 11/01/2017                          Signature of Candidate</b><br>';

	$html2='           I have read all the rules of hostel admission and after understanding these rules thoroughly, I have filled in the application form for admission of current year. The information given by me in my application is true to the best of my knowledge and belief. I understand that if any of the statements made by me in the application form or any information/documents supplied by me in connection with my admission is found to be false or incorrect at any stage, my admission will be cancelled. I hereby agree that I will be bound to all Rules, Acts and Laws set by State Government. I hereby undertake that, I will follow all the rules and regulation of the hostel, failing which will be liable for disciplinary action.';

	$pdf->WriteHTML($html3);
	$pdf->Cell(0,1," ",'B',1);
	//$pdf->WriteHTML($html);
	/*$pdf->Cell(0,10,'Email : '.$m_pemail,0,1);
	$pdf->Cell(0,10,'Contact Number : '.$m_pc_no,0,1);
	$pdf->Cell(0,10,'Category : '.$m_event,0,1);
	$pdf->Cell(0,10,'Gender : '.$m_pgender,0,1);
	$pdf->Cell(0,10,'CGPA : '.$m_pclgname,0,1);
	$pdf->Cell(0,10,'Current Year & Branch : '.$m_pbranch,0,1);
	*/
	$pdf->Cell(20,7,"Name : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(100,7,$m_pname,'B',1,'L');
	$pdf->SetFont('');
	$pdf->Cell(20,7,"Email : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(100,7,$m_pemail,'B',1,'L');
	$pdf->SetFont('');
	//$pdf->Ln();
	$pdf->Cell(15,7,"PRN : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(30,7,$m_psc_no,'B',1,'C');
	$pdf->SetFont('');
	$pdf->Cell(55,7,"Candidate Contact Number : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(30,7,$m_pc_no,'B',1,'C');
	
	$pdf->SetFont('');
	$pdf->Cell(25,7,"Category : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(15,7,$m_event,'B',0,'C');
	$pdf->SetFont('');
	$pdf->Cell(10,7,"",0,0,'L');
	$pdf->Cell(20,7,"Gender : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(18,7,$m_pgender,'B',1,'C');
	/*
	$pdf->SetFont('');
	$pdf->Cell(50,7,"Physically Handicapped : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(12,7,$m_ph,'B',0,'C');
	$pdf->SetFont('');
	$pdf->Cell(10,7,"",0,0,'L');
	$pdf->Cell(20,7,"Defence : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(12,7,$m_def,'B',1,'C');
	$pdf->SetFont('');
	//$pdf->Cell(7,7,"",0,0,'L');
	$pdf->Cell(65,7,"J & K / North Eastern Candidate : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(12,7,$m_jk,'B',1,'C');*/
	$pdf->SetFont('');
	$pdf->Cell(48,7,"Current Year & Branch :",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(72,7,$m_pbranch,'B',1,'C');
	$pdf->SetFont('');
	$pdf->Cell(42,8,"Permanent Address :",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(150,8,$m_padd,'B',1,'L');
	/*$pdf->SetFont('');
	$pdf->Cell(42,8,"Local Address :",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(150,8,$m_ladd,'B',1,'L');
	$pdf->SetFont('');
	$pdf->Cell(60,7,"Latest Semester Percentage : ",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(20,7,$m_pclgname."%",'B',0,'C');*/
	$pdf->Ln();
	$pdf->Cell(0,6,"Regular Courses",0,1,'L');
	$pdf->BasicTable($header,$data);
	$pdf->Ln();
	//$pdf->WriteHTML($html2);
	$pdf->Ln(10);
	$pdf->Cell(30,6,"Date & Time : ",0,0,'L');
	$pdf->Cell(0,6,$pdate,0,1,'L');
	$pdf->Cell(0,6,"Place : Jalgaon",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(0,6,"Signature of Candidate",0,1,'R');
	$pdf->SetFont('');
	$pdf->Cell(0,1," ",'B',1);
	$pdf->Cell(0,7,"For Office Use : ",0,1,'L');
	$pdf->Cell(120,6,"Receipt Amount : ",0,0,'L');
	$pdf->Cell(27,6,"Receipt No.",0,0,'L');
	$pdf->Cell(40,6,"",'B',1,'L');
	//$pdf->Cell(0,6,"Room Alloted : Room No.",0,1,'L');*/
	$pdf->Ln(10);
	$pdf->SetFont('','B');
	$pdf->Cell(120,6,"Signature of Class Teacher",0,0,'L');
	$pdf->Cell(0,6,"Signature of Admission Clerk",0,1,'R');
	$pdf->SetFont('');
	$pdf->Output();
	//$pdf->Output("Hostel_From_".$m_pname.".pdf", 'D');
	//header('Content-Type: application/octet-stream');
	//header('Content-Length: ' . FILESIZE_HERE);
	//header('Content-Disposition: attachment; filename=' . "Hostel_From_".$m_pname.".pdf");

	header("Location : index.php");
	?>
