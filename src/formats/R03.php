<?php

session_start();
require('fpdf/fpdf.php');
include('funclib.php');

include('../config/dbconnect.php');
require_once "../config/funlib/login_functions.php";
error_reporting(0);


if( isset($_GET['id']) && (isLogin() != null) )
{
		$no = $_GET['id'];
		$no = base64_decode($no);
		if($_SESSION['sec_access_code'] != $no)
		{
			die("Illegal Access");
			
			
		}
		else
		{
			
			unset($_SESSION['sec_access_code']);
		$course = $_GET['course'];
		$department = $_GET['department'];
		$data_query = "SELECT  `academic_year`.`academic_year` ,  `course`.`course_code` ,  `course`.`course_name` ,  `course`.`credits` ,  `course_assign`.`sem` ,  `course_assign`.`branch` , `th_mks_scheme`.`isa` ,  `department`.`department_name` ,  `exam_session`.`session`,`year2sem_relation`.`year`
		FROM  `exam_session`,`year2sem_relation` ,  `ses_conf` ,  `academic_year` ,  `course` ,  `th_mks_scheme` ,  `course_assign` 
		LEFT JOIN  `department` ON  `course_assign`.`branch` =  `department`.`id` 
		WHERE  `course`.`id` =  '$course'
		AND  `course_assign`.`sub_id` =  `course`.`id` 
		AND  `th_mks_scheme`.`sub_id` =  `course`.`id` 
		AND  `department`.`id` = '$department'
		AND  `academic_year`.`ac_id` =  `course_assign`.`ac_yr` 
		AND  `ses_conf`.`current_acyr` =  `academic_year`.`ac_id` 
		AND  `exam_session`.`id` =  `ses_conf`.`current_session`
        AND `year2sem_relation`.`sem` = `course_assign`.`sem` ";
		
		$res_data =  mysqli_query($dbcon,$data_query) or die(mysqli_error($dbcon));
		
		$row2 = mysqli_fetch_assoc($res_data);
		$course_code = $row2['course_code'];
		$course_name = $row2['course_name'];
		$fileName = 'R03 ' . $row2['course_code'] . '.pdf';
		$department_name = $row2['department_name'];
		$sem = $row2['sem'];
		if($sem % 2 == 0)
			$sem = "EVEN";
		else
			$sem = "ODD";
		switch($row2['year'])
		{
			case 1:
				$year = "F Y B Tech";
				break;
			case 2:
				$year = "S Y B Tech";
				break;
			case 3:
				$year = "T Y B Tech";
				break;
			case 4:
				$year = "L Y B Tech";
				break;
		}
		$ac_yr = $row2['academic_year'];
		$credits = $row2['credits'];
		$max_marks = $row2['isa'];
		$exam_session_name = $row2['session'];
		preg_match_all('!\d+!', $ac_yr, $matches);
		if($exam_session_name == 'Winter')
			$exam_session = $exam_session_name." ".$matches[0][0];
		else 
			$exam_session = $exam_session_name." ".$matches[0][1];

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
	$pdf->Cell(190,7,"R03",0,0,'R');
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
$pdf->Cell(190,7,"Marks List for ".$exam_session,0,1,'C',true);



// Line break
	//$pdf->Ln(4);
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0);
	$pdf->SetFont('','B');
	$pdf->Cell(40,6,"Year and Programme : ",0,0,'L');
	$pdf->SetFont('','');
	//alert($cls);
	$pdf->Cell(40,6,$year,0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	//$pdf->Cell(7,6,"",0,0,'L');
	$pdf->Cell(28,6,"Academic Year : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(45,6,$ac_yr,0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(20,6,"Semester : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(10,6,$sem,0,1,'L');

	$pdf->SetFont('','B');
	$pdf->Cell(15,6,"Branch : ",0,0,'L');
	$pdf->SetFont('','');
	//alert($cls);
	$pdf->Cell(70,6,$department_name,0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	$pdf->Cell(7,6,"",0,0,'L');
	$pdf->Cell(24,6,"Examination : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(39,6,"ISA",0,0,'L');
	$pdf->SetFont('','B');
	$pdf->Cell(15,6,"Credits : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(10,6,$credits,0,1,'L');
	
	$pdf->SetFont('','B');
	$pdf->Cell(45,6,"Course Code and Name : ",0,0,'L');
	$pdf->SetFont('','');
	$pdf->Cell(110,6,$course_code." ".$course_name,0,0,'L');
	$pdf->SetFont('');
	$pdf->SetFont('','B');
	//LINE 4
	$pdf->SetFont('','B');
	$pdf->Cell(22,6,"Max. Marks : ",0,0,'L');
	$pdf->SetFont('','');
	
	$pdf->Cell(10,6,$max_marks,0,0,'L');
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
	$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_others`.`marks`,`marks_others`.`ne_flag`,`marks_others`.`ab_flag`,`course`.`course_code`,`course`.`course_name` FROM `student`,`course_assign`,`course`,`exam_registration`,`ses_conf`,`marks_others` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `ses_conf`.`id` = '1' AND `marks_others`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_others`.`stud_id` AND `marks_others`.`course_id` = '$course' AND `marks_others`.`exam_type` = '3' AND `exam_registration`.`conform_status` = '1' AND `course`.`id` = '$course' AND `student`.`department` = '$department'";
	$res= mysqli_query($dbcon,$query) or die(mysqli_error($dbcon));
	
	if(mysqli_num_rows($res) > 0)
	{
		$i=0;
		while ($row = mysqli_fetch_assoc($res)) {
			$prn = $row['prn'];
			$name = $row['name'];
			$marks = $row['marks'];
			$ne_flag =$row['ne_flag'];
			$ab_flag = $row['ab_flag'];
			if($ne_flag == 1)
			{
					$m="NE";
			}
			else if($ab_flag == 1)
			{
				$m= "AB";
			}
			else
			{
				$m= sprintf('%02d', $marks);
			}
			$pdf->Cell(33,6, $prn,1,0,'C');
			$pdf->Cell(90,6, $name,1,0,'L');	
			$pdf->Cell(33,6, $m,1,0,'C');
			$pdf->Cell(33,6,"",1,1,'C');
			$i=$i+1;
		}
	}
		
	

	$pdf->Ln(12);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(60,5,"Course Teacher",0,0,'C');
	$pdf->Cell(170,5,"Course Coordinator",0,0,'C');
	//$pdf->Output();
	$pdf->Output($fileName, 'I');
}
}
	?>