<?php

class certificate extends FPDF {

	private $topoffset = 126.5;
	private $max_offset = 151.2;
	private $lineheight = 4;
	private $fontsize = 6;
	private $fontfamily = 'Courier';
	private $width_left_margin = 1.8;
	private $width_token = 18.5;
	private $width_description = 33.6;
	private $width_quantity = 9.4;
	private $width_unit_price = 10.6;
	private $width_discount_price = 18.5;
	private $width_total_price = 14;
	private $subtotal = 0;
	private $pagedata = array();
	private $currentpage = 0;
	private $headerToken = '';

	public function __construct($orientation='P', $unit='mm', $format='certificate') {
		parent::FPDF($orientation, $unit, $format);
	}

	//Basic Format
	function generate($data) {
		$this->AddPage();
		// http://www.languagenut.com/fpdf16/doc/image.htm
		if (isset($_GET['demo'])) {
			$this->Image(config::get('pdf_images') . '/certificate/certificateLayout.png', 0, 0);
			$this->Cell(1, 55, '', 0, 1, 'L');
		} else {

//			Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
			$this->Image(config::get('pdf_images') . 'certificate/' . $data['background'], 15, 15);
			$this->Image(config::get('pdf_images') . 'certificate/' . $data['logo_url'], 326, 50.5, '', '', '', $data['url']);
			$this->SetY(115);
			if (!is_numeric($data['font_size'])) {
				$data['font_size'] = 190;
			}
			$this->SetFont('Arial', '', $data['font_size']); // default it was 190
			$this->Cell(165, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(520, 22, strtoupper($data['medal']), 0, 1, 'C');
			// To Leave a space between line
			$this->Cell(1, 55, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 99);
			$this->Cell(65, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(245, $this->lineheight, $data['unit.caption'] . ' ' . $data['unit_number'], 0, 0, 'L');
			// IF IT'S AN UNIT TEST THEN WE DON'T SHOW SECTION DETAILS ON THE PDF
			if ($data['is_unit_test'] == 1) {
				$this->Cell(345, $this->lineheight, '', 0, 1, 'L');
			} else {
				$this->Cell(345, $this->lineheight, $data['section.caption'] . '' . $data['section_number'], 0, 1, 'L');
			}
			// To Leave a space between line
			$this->Cell(1, 30, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 50);
			$this->Cell(65, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(245, $this->lineheight, iconv("UTF-8", "cp1252", $data['Unit']), 0, 0, 'L');
			// IF IT'S AN UNIT TEST THEN WE DON'T SHOW SECTION DETAILS ON THE PDF
			if ($data['is_unit_test'] == 1) {
				$this->Cell(290, $this->lineheight, '', 0, 0, 'L');
			} else {
				$this->Cell(290, $this->lineheight, iconv("UTF-8", "cp1252", $data['Section']), 0, 0, 'L');
			}
			$this->Cell(180, $this->lineheight, iconv("UTF-8", "cp1252", $data['GameName']), 0, 1, 'L');
			// To Leave a space between line
			$this->Cell(1, 44, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 69);
			$this->Cell(800, $this->lineheight, iconv("UTF-8", "cp1252", $data['cong.msg']), 0, 1, 'C');
			// To Leave a space between line
			$this->Cell(1, 45, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 58);
			$this->Cell(58, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(390, $this->lineheight, iconv("UTF-8", "cp1252", $data['awarded.to']) . ':', 0, 0, 'L');
			$this->Cell(320, $this->lineheight, iconv("UTF-8", "cp1252", $data['class']) . ':', 0, 1, 'L');
			// spacer
			$this->Cell(1, 31, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 45);
			$this->Cell(58, 0.5, '', 0, 0, 'L');
			$this->Cell(340, 0.5, iconv("UTF-8", "cp1252", ucwords($data['StudentName'])), 0, 0, 'L');
			$this->Cell(52, 0.5, '', 0, 0, 'L');
			$this->Cell(295, 0.5, iconv("UTF-8", "cp1252", $data['class_name']), 0, 1, 'L');
			$this->Cell(1, 8, '', 0, 1, 'L');
			$this->Cell(58, 0.5, '', 0, 0, 'L');
			$this->Cell(340, 0.5, '', 'B', 0, 'L');
			$this->Cell(52, 0.5, '', 0, 0, 'L');
			$this->Cell(295, 0.5, '', 'B', 1, 'L');
			// To Leave a space between line
			$this->Cell(1, 30, '', 0, 1, 'L');

			$this->SetFont('Arial', '', 58);
			$this->Cell(113, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(390, $this->lineheight, iconv("UTF-8", "cp1252", $data['perfect.words']) . ':', 0, 0, 'L');
			$this->SetFont('Arial', '', 45);
			// spacer
			$this->Cell(1, 30, '', 0, 1, 'L');
			$this->Cell(113, 0.5, '', 0, 0, 'L');
			//$this->Cell(633,$this->lineheight,iconv("UTF-8", "cp1252", $data['right_words']),'',1,'L');
			$this->Cell(633, $this->lineheight, $data['right_words'], '', 1, 'L');
			$this->Cell(1, 6, '', 0, 1, 'L');
			$this->Cell(113, 0.5, '', 0, 0, 'L');
			$this->Cell(633, 0.5, '', 'B', 1, 'L');
			// To Leave a space between line
			$this->Cell(1, 30, '', 0, 1, 'L');
			$this->SetFont('Arial', '', 58);
			$this->Cell(113, $this->lineheight, '', 0, 0, 'L');
			$this->Cell(390, $this->lineheight, iconv("UTF-8", "cp1252", $data['wrong.words']) . ':', 0, 0, 'L');
			$this->SetFont('Arial', '', 45);
			// spacer
			$this->Cell(1, 30, '', 0, 1, 'L');
			$this->Cell(113, 0.5, '', 0, 0, 'L');
			//$this->Cell(633,$this->lineheight,iconv("UTF-8", "cp1252", $data['wrong_words']),'',1,'L');
			$this->Cell(633, $this->lineheight, $data['wrong_words'], '', 1, 'L');
			$this->Cell(1, 6, '', 0, 1, 'L');
			$this->Cell(113, 0.5, '', 0, 0, 'L');
			$this->Cell(633, 0.5, '', 'B', 1, 'L');
		}
		$this->Output();
	}

}

?>