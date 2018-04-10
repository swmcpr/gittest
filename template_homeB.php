<?php
	require_once('common/php/helpers.php');
	$conf_url=$base_url."/conf/config.ini";
	$config = parse_ini_file($conf_url, 1);
	$SunSoft_url=$config['SunSoft_URL']['URL'];
    $SSS_url=$config['SunSoft_Services']['SSSURL'];
	
	$externalApiKey=$config['SunSoft_Services']['externalApiKey'];
	$hash=hash('sha512', $externalApiKey);
	$userId="4CBJ";
	
/*
Template Name: HomePage Template
*/
		
		//$xml = file_get_contents("https://ruw.reversesoftonline.com/ReverseMortgage/GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017");
		//$xml = file_get_contents($SunSoft_url."/GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017-LRT018-LRT019");
		//$xml = file_get_contents("https://du.reversesoftonline.com/SunsoftServices/GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017-LRT018-LRT019?&externalApiKey=".urlencode($externalApiKey)."&hash=".urlencode($hash));
		//$xml = file_get_contents("https://du.reversesoftonline.com/SunsoftServices/GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017-LRT018-LRT019?&externalApiKey=g72rty45avn3334562ab&hash=8119d8c75cddcb0476a71dcac7171584ea17fef912e6853b718e0b8bf8fc033382242eeeedb2a5ecffc27a5dcbc603920526255cad834dfdad6648fffca60f4f");
		$xml = file_get_contents($SSS_url."GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017-LRT018-LRT019&hash=".$hash);
		
		$loanProgramArray= array();
		$loanProgram = simplexml_load_string($xml);
		//$loanProgram = simplexml_load_string($xml->loan_program);
		//print_r($loanProgramArray->loan_program);
		/* echo "<pre>";
		print_r($loanProgramArray->loan_program[0]->priceId); */
		foreach ($loanProgram->loan_program as $loan) {
		//print_r($loan);
			$priceId = (string) $loan->priceId;
			//echo $priceId;
			//date format is in yyyy-mm-dd 00:00:00, we need to convert it to dd/mm/yyyy
			$date = (string) $loan->date;
			$dateArray = explode(" ", $date);
			$dateArray = explode("-",$dateArray[0]);
			$date = $dateArray[1] ."/". $dateArray[2] ."/".$dateArray[0];
			
			//time is in 24 hour format, we must convert it to 12 hour
			$time = (string) $loan->time;
			$time = date("g:i a", strtotime($time));
			
			//$margin = (string) $loan-margin;
			$rate = (string) $loan->rate;
			$apr = (string) $loan->apr;
		
			array_push($loanProgramArray, array($priceId,$rate,$apr,$date,$time));
		}

		/* echo "<pre>";
		print_r($loanProgramArray);
		echo "</pre>"; */
		
get_header();
$post_date_style = $tec_options['post-single-date-style'];
if ( empty( $tec_options['post-meta-elements']['date'] ) ) {
	$post_date_style = 'inline';
}

$page_title = get_post_meta( get_the_ID(), 'tec_page_title', true );

if ( empty( $page_title ) ) {
	$show_on_front = get_option( 'show_on_front' );
	$page_for_posts = get_option( 'page_for_posts' );
	
	if ( $show_on_front == 'page' && $page_for_posts ) {
		$page_title = get_post_meta( $page_for_posts, 'tec_page_title', true );
		if ( empty( $page_title ) ) {
			$page_title = get_the_title( $page_for_posts );
		}
	} else {
		$page_title = __( 'Blog', 'tectonic' );
	}
}
$page_subtitle = get_post_meta( get_the_ID(), 'tec_page_subtitle', true );

//Added to display the EST time in Todays rate
date_default_timezone_set("US/Eastern"); 
require_once("scripts/helpers.php");

?>

<script type="text/javascript" src="https://d5td2kjjbz0b7.cloudfront.net/js/html5placeholder.jquery.js"></script> 
<script src="https://d5td2kjjbz0b7.cloudfront.net/js/common.js" type="text/javascript"></script>
<script src="https://d5td2kjjbz0b7.cloudfront.net/js/ratequote.js" type="text/javascript"></script>
<script src="https://d5td2kjjbz0b7.cloudfront.net/js/subscribe.js" type="text/javascript"></script>
<script src="https://d5td2kjjbz0b7.cloudfront.net/js/jquery.tooltipster.js" type="text/javascript"></script>
<link href="https://d5td2kjjbz0b7.cloudfront.net/css/tooltipster.css" type="text/css" rel="stylesheet">
<style>
	#tooltip1,
	#tooltip2,
	#tooltip3,
	#tooltip4,
	#tooltip5,
	#tooltip6,
	#tooltip7,
	#tooltip8,
	#tooltip9,
	#tooltip10,
	#tooltip11,
	#tooltip12{
		color:#f5911e;
	}
	
	@media only screen and (max-width: 769px) {
		#iBoard{
		border: none;
	}
	.responsive #info-board {
		margin-top:16px;
	}
	}
	
	.uppercase{
		text-transform:capitalize !important;
		text-decoration:none !important;
		color:#444 !important;
		font-weight:bold;
	}
	
	a.link-sm span, a.link-sm{
		background:none !important;		
	}
	

	h5{
		color:#444 !important;
	}
	
	hr{
	  border: solid #AFAFAF;
	  border-width: 2px 0 0;
	}
	
	#page-content {
	  padding: 55px 36px 0px 60px;
	  min-height: 956px !important;
	}
	
	.ratelink{
		color:#000000;
	}
	
	.ratelink:hover{
		text-decoration:underline;
		color:#000000;
	}
</style>
	<!-- Page Title -->
	<div class="sixteen columns">
		<div class="page-title">
			<?php
				if ( $page_subtitle ) {
					echo '<h3>' . $page_subtitle . '</h3>' . "\n";
				}
				echo '<h1>' . $page_title . '</h1>' . "\n";
			?>
		</div>
	</div>

<?php if ( $tec_page_layout == 'left-sidebar' ) {
	
	// Include the Info Board template
	get_template_part( 'info-board' );
		
	?>
	
	<!-- Page Content -->
	<div class="twelve columns" id="pContent">
	
		<div id="page-content" class="sidebar-layout clearfix"> <!-- inner grid 720 pixels wide -->
			
			<div class="full-width columns">
					
<?php 
include('sub_links.php'); 
//echo $_SERVER['HTTP_HOST'];
?>
<div style="clear: both;"></div>
<div style="position: relative;">
 <!--<p class="homepage_title" style="color: #0050BE;font-size: 26px;line-height: 25px;">Low mortgage rates with amazing,<br>fast service at every step of the loan. <br>That's how we roll.
</p>-->
<div class="twelve columns home_main_content" style="margin-left:0px;">				
<!--<div class="six columns middle-font-size home_para">Rate effective as of 05/20/2015 8:50 am. The interest rate shown is with no points for a 10 year fixed, "no cash-out" refinance loan and assumes a minimum FICO score of 740 with a maximum loan-to-value ratio of 80% on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information,
your credit history, the location and type of property, and other factors as determined by LowRates.com. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are
charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</div>-->
<div class="six columns home_para">
    <p class="homepage_title" style="color: #0050BE;font-size: 24px;line-height: 25px;">Attractive mortgage rates without compromise in service. Complete customer satisfaction is our No. 1 goal!</p>
    <p>Getting a mortgage is an important decision and a big investment. With the myriad of information out there, trying to choose the right mortgage can become a complicated process.  This is why it's important to first choose a right lender.  At LowRates.com, it is our mission to make mortgage shopping easy so you can enjoy your home more.</p>
    <p>We are a direct lender, which means there are no broker fees.  We also handle everything in-house; from giving you valuable advice to the processing, underwriting, and funding of your loan, we do everything ourselves to ensure that your loan closes on time.  By choosing LowRates.com, you can save both time and money.</p>
    <p>LowRates.com is your one stop shop for your home purchase or refinance.  We offer a complete line of loan products, including Conventional, FHA, VA, USDA, and Jumbo loans with both Fixed and Adjustable rate options.  Get started today by filling out the Instant Rate Quote form or by calling directly at <strong><?php echo show_contact_no();?></strong> / <?php echo show_contact_no_numeric();?> and see the LowRates difference!</p>     
</div>
<div class="six columns tbl_todays_rate">
<div class="div_todays_rate">
<table class="todays_rate_tbl u-full-width" cellspacing="0" cellpadding="5">
<tbody>
<tr>
<td colspan="5" style="padding:0px !important;">
<div class="rates_title">
	<div class="todaystitle">Today's Rates</div>
	<span class="todaysdatetime"><?php echo date('D, F d, Y'); ?><br><span style="font-size: 14px;display: block;text-align: right;"><?php echo date("g:i A")." EST";?></span></span>
</div>
</td>
</tr>
	<tr>
	<td colspan="3" style="padding: 0px 0px 0px 0px !important;">
 	<table class="rates_heading">
	  <tbody>
		  <tr>
			<th class="rates_headingth1">Program</th>
			<th class="rates_headingth2">Rate</th>
			<th class="rates_headingth3">APR</th>
			<th class="rates_headingth4">Points</th>
			<th class="rates_headingth5">Assumptions</th>
			</tr>
		</tbody>
	</table>
	</td>
</tr>
<tr >
    <!--<td class="cell1"></td>-->
    <td class="todaysupdatetbl" >
<table style="margin-top: 11px;">
<!--<tr>
<th>Program</th>
<th>Rate</th>
<th>APR</th>
<th>Points</th>
<th style="text-align: center;">Assumptions</th>
</tr>-->
<tr>
<td height="5"></td>
</tr>
<tr style="border:none;">
<td class="todaysratecell_heading" style="" colspan="5">Conventional</td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=conv&term=10yr&type=fixed" class="ratelink">10-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[7][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[7][2],3)."%";?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip1">View</span></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=conv&term=15yr&type=fixed" class="ratelink">15-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[6][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[6][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip2">View</span></td>
</tr>
<tr style="border:none;">
<td class="td1"><a href="todaysrate?product=conv&term=30yr&type=fixed" class="ratelink">30-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[5][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[5][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip3">View</span></td>
</tr>
<tr style="border:none;">
<td height="10" colspan="5"></td>
</tr>
<tr style="border:none;">
<td class="todaysratecell_heading" colspan="5">FHA</td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=fha&term=15yr&type=fixed" class="ratelink">15-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[8][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[8][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip4">View</span></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=fha&term=30yr&type=fixed" class="ratelink">30-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[0][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[0][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td align="center" style="text-align:center;font-weight:bold;"><span id="tooltip5">View</span></td>
</tr>
<tr style="border:none;">
<td class="td1"><a href="todaysrate?product=fha&term=30yr&type=arm&subterm=3_1yr" class="ratelink">3/1 ARM</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[17][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[17][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td align="center" style="text-align:center;font-weight:bold;"><span id="tooltip11">View</span></td>
</tr>
<tr style="border:none;">
<td class="td1"><a href="todaysrate?product=fha&term=30yr&type=arm&subterm=5_1yr" class="ratelink">5/1 ARM</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[11][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[11][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td align="center" style="text-align:center;font-weight:bold;"><span id="tooltip6">View</span></td>
</tr>
<tr style="border:none;">
<td height="10" colspan="5"></td>
</tr>
<tr style="border:none;">
<td class="todaysratecell_heading" colspan="5">VA</td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=va&term=15yr&type=fixed" class="ratelink">15-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[9][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[9][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip7">View</span></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=va&term=30yr&type=fixed" class="ratelink">30-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[1][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[1][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip8">View</span></td>
</tr>
<tr style="border:none;">
<td class="td1"><a href="todaysrate?product=va&term=30yr&type=arm&subterm=3_1yr" class="ratelink">3/1 ARM</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[18][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[18][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip12">View</span></td>
</tr>
<tr style="border:none;">
<td class="td1"><a href="todaysrate?product=va&term=30yr&type=arm&subterm=5_1yr" class="ratelink">5/1 ARM</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[12][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[12][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip9">View</span></td>
</tr>
<tr style="border:none;">
<td height="10" colspan="5"></td>
</tr>
<tr style="border:none;">
<td class="todaysratecell_heading" colspan="5">USDA</td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr>
<td class="td1"><a href="todaysrate?product=usda&term=30yr&type=fixed" class="ratelink">30-Year Fixed</a></td>
<td class="td2"><?php echo number_format($loanProgramArray[4][1],3)."%"; ?></td>
<td class="td3"><?php echo number_format($loanProgramArray[4][2],3)."%"; ?></td>
<td class="td4">0.0000</td>
<td class="td5"><span id="tooltip10">View</span></td>
</tr>
</table>
    </td>
    <!--<td class="cell2"></td>-->
</tr>

</tbody>
</table>
</div>
</div>
</div>
				
</div>
<div style="padding-top: 100px;" class="hr_remove">
<hr/>
</div>
<?php 
/*
$args = array(
				'type'            => 'picture',
				'columns_num'     => 3,
				'image_size'      => 'portfolio-preview-medium',
				'read_link_style' => 'small-arrow-uppercase',
				'clickable_title' => 'no',
				'number'          => 3,
				'image_id'        => array( '2317', '2321', '2319' ),
				'heading'         => array( 'Loan Calculators', 'Feedback', 'Contact Us' ),
				'text'            => array( '<p style="text-align:left !important">Use one of our many calculators to help you with your loan.</p>', 'Tell us what you think.<br/><br/>', '<p style="text-align:left !important">Have a question ? Need further assistance ?</p>' ),
				'link_url'        => array( site_url().'/mortgage-calculators/', '#', site_url().'/contact' ),
				'link_target'     => array( '', '', '' ),
				'link_label'      => array( 'Calculate >', 'Submit >', 'Contact >' ),
			);*/
			
$args = array(
				'type'            => 'picture',
				'columns_num'     => 3,
				'image_size'      => 'portfolio-preview-medium',
				'read_link_style' => 'small-arrow-uppercase',
				'clickable_title' => 'no',
				'number'          => 3,
				'image_id'        => array( '2317', '2321', '2319' ),
				'heading'         => array( 'Loan Calculators', 'FAQ', 'Contact Us' ),
				'text'            => array( '<p style="text-align:left !important">Use one of our many calculators to help you with your loan.</p>', 'Answers to common questions.<br/><br/>', '<p style="text-align:left !important">Have a question ? Need further assistance ?</p>' ),
				'link_url'        => array( site_url().'/mortgage-calculators/', site_url().'/faq/', site_url().'/contact' ),
				'link_target'     => array( '', '', '' ),
				'link_label'      => array( 'Calculate >', 'Read >', 'Contact >' ),
			);			

the_widget('Tectonic_Feature_Boxes_Widget',$args); ?>
<!--<div>
<hr />
</div>
 

<!--
<div class="advertisement_col" style="position:relative;">
<span style="color:#ffffff;font-size:50px;padding-top:85px;position:absolute;margin-left:-250px;">Rotating Advertisements</span>
</div>-->
				
			</div> <!-- end full-width columns -->
			
		</div> <!-- end inner grid -->
	
	</div>
	<!-- end Page Content -->
	
	<?php get_sidebar(); ?>
	
<?php } else { ?>
	
	<!-- Page Content -->
	<div class="sixteen columns" id="pContent">
	
		<div id="page-content" class="fullwidth-layout clearfix"> <!-- inner grid 1080 pixels wide (full-width page) -->
		
			<div class="full-width columns">
				
				
			</div> <!-- end full-width columns -->
		
		</div> <!-- end inner grid -->
	
	</div>
	<!-- end Page Content -->
	
<?php } ?>

	<div class="clear"></div>
<script>

	/*	Tooltip */
	
	//Tooltip1
	$('#tooltip1').tooltipster({
		content: $('<div><center><strong>Conventional 10 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 10 year fixed, <strong>"no cash-out"</strong> refinance loan and assumes a minimum FICO score of 740 with a maximum <strong>loan-to-value ratio of 80%</strong> on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip2
	$('#tooltip2').tooltipster({
		content: $('<div><center><strong>Conventional 15 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 15 year fixed, <strong>"no cash-out"</strong> refinance loan and assumes a minimum FICO score of 740 with a maximum <strong>loan-to-value ratio of 80%</strong> on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip3
	$('#tooltip3').tooltipster({
		content: $('<div><center><strong>Conventional 30 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 30 year fixed, <strong>"no cash-out"</strong> refinance loan and assumes a minimum FICO score of 740 with a maximum <strong>loan-to-value ratio of 75%</strong> on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip4
	$('#tooltip4').tooltipster({
		content: $('<div><center><strong>FHA 15 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 15 year fixed and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 96.5%</strong> on a purchase of an owner occupied single family residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip5
	$('#tooltip5').tooltipster({
		content: $('<div><center><strong>FHA 30 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 96.5%</strong> on a purchase of primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip6
	$('#tooltip6').tooltipster({
		content: $('<div><center><strong>FHA 5/1 Adjustable</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 5-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 96.5%</strong> on a purchase of an owner occupied single family residence. After the initial 5 years, interest rate can change once every year for the remaining life of the loan. Your payment will change after the initial 5 years and it can go up. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip7
	$('#tooltip7').tooltipster({
		content: $('<div><center><strong>VA 15 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 15 year fixed and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 100%</strong> on a purchase of an owner occupied single family residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip8
	$('#tooltip8').tooltipster({
		content: $('<div><center><strong>VA 30 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 100%</strong> on a purchase of primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	
	//Tooltip9
	$('#tooltip9').tooltipster({
		content: $('<div><center><strong>VA 5/1 Adjustable</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 5-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 100%</strong> on a purchase of an owner occupied single family residence. After the initial 5 years, interest rate can change once every year for the remaining life of the loan. Your payment will change after the initial 5 years and it can go up. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip10
	$('#tooltip10').tooltipster({
		content: $('<div><center><strong>USDA 30 Year Fixed</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 100%</strong> on purchase of a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip11 added for FHA 3/1 ARM
	$('#tooltip11').tooltipster({
		content: $('<div><center><strong>FHA 3/1 Adjustable</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 3-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 96.5%</strong> on a purchase of an owner occupied single family residence. After the initial 3 years, interest rate can change once every year for the remaining life of the loan. Your payment will change after the initial 3 years and it can go up. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
	//Tooltip12 added for VA 3/1 ARM
	$('#tooltip12').tooltipster({
		content: $('<div><center><strong>VA 3/1 Adjustable</strong><br><br><strong align="center">Important disclosures, assumptions, and information</strong><br><br></center>The interest rate shown is with no points for a 3-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum <strong>loan-to-value ratio of 100%</strong> on a purchase of an owner occupied single family residence. After the initial 3 years, interest rate can change once every year for the remaining life of the loan. Your payment will change after the initial 3 years and it can go up. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by LowRates.com. Rates shown is based on a 45-day lock-in period. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.</span></div>'),
		// setting a same value to minWidth and maxWidth will result in a fixed width
		minWidth: 300,
		maxWidth: 410,
		position: 'bottom'
	});
	
</script>
<?php get_footer();