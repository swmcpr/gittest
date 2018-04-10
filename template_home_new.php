<?php

/*
Template Name: HomePage Template New
*/
		
		$xml = file_get_contents("https://ruw.reversesoftonline.com/ReverseMortgage/GetLoanRate?priceId=LRT001-LRT002-LRT003-LRT004-LRT005-LRT006-LRT007-LRT008-LRT009-LRT010-LRT011-LRT012-LRT013-LRT014-LRT015-LRT016-LRT017");
		$loanProgramArray= array();
		$xml = simplexml_load_string($xml);
		foreach ($xml->loan_program as $loan) {
			$priceId = (string) $loan->priceId;
			
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
<style>
#info-board{
	display:block;
}
	a.tooltip {outline:none; }
	a.tooltip strong {line-height:30px;}
	a.tooltip:hover {text-decoration:none;} 
	a.tooltip span {
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 158px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip2 span {
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 180px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip3 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 202px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip4 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 257px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip5 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 280px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip6 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 302px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip7 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 356px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip8 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 380px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
		a.tooltip9 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 403px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip10 span{
	  z-index: 10;
	  display: none;
	  padding: 14px 20px;
	  margin-top: -30px;
	  /* margin-left: 28px; */
	  width: 370px;
	  line-height: 16px;
	  position: absolute;
	  left: 0px;
	  top: 457px;
	  position: relative;
	  text-align:justify;
	  font-style:normal;
	}
	a.tooltip:hover span,
	a.tooltip2:hover span,
	a.tooltip3:hover span,
	a.tooltip4:hover span,
	a.tooltip5:hover span,
	a.tooltip6:hover span,
	a.tooltip7:hover span,
	a.tooltip8:hover span,
	a.tooltip9:hover span,
	a.tooltip10:hover span{
		display:inline; 
		position:absolute; 
		color:#111;
		border:1px solid #DCA;
		background:#fffAF0;
	}
 	.callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
		
	/*CSS3 extras*/
	a.tooltip span,a.tooltip2 span,a.tooltip3 span,a.tooltip4 span,a.tooltip5 span,a.tooltip6 span
	{
		border-radius:4px;
		box-shadow: 5px 5px 8px #CCC;
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
					
	<?php include('sub_links.php'); ?>
		<a href="application/" title="Apply Now" class="orange_btn" style="font-weight:normal;cursor:pointer;color:#ffffff;">Apply Now</a>
<div style="clear: both;"></div>
<div style="position: relative;">
 <p style="color: #0050BE;font-size: 26px;line-height: 25px;">Low mortgage rates with amazing,<br>fast service at every step of the loan. <br>That's how we roll.
</p>
<div class="twelve columns" style="margin-left:0px;">				
<!--<div class="six columns middle-font-size home_para">Rate effective as of 05/20/2015 8:50 am. The interest rate shown is with no points for a 10 year fixed, "no cash-out" refinance loan and assumes a minimum FICO score of 740 with a maximum loan-to-value ratio of 80% on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information,
your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are
charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.</div>-->
<div class="six columns home_para">
    <p>Getting a mortgage is an important decision and a big investment. With the myriad of information out there, trying to choose the right mortgage can become a complicated process.  This is why it's important to first choose a right lender.  At LowRates.com, it is our mission to make mortgage shopping easy so you can enjoy your home more.</p>
    <p>We are a direct lender, which means there are no broker fees.  We also handle everything in house; from giving you valuable advice to the processing, underwriting, and funding of your loan, we do everything ourselves to ensure that your loan closes on time.  By choosing LowRates.com, you can save both time and money.</p>
    <p>LowRates.com is your one stop shop for your home purchase or refinance.  We offer a complete line of loan products, including Conventional, FHA, VA, USDA, and Jumbo loans with both Fixed and Adjustable rate options.  Get started today by filling out the Instant Rate Quote form or by calling directly at 1-844-907-RATE and see the LowRates difference!.</p>     
    
</div>
<div class="six columns tbl_todays_rate">
<div class="div_todays_rate">
<div class="rates_title">Today's Rates
<span style="float:right;font-size:15px;font-style:italic;margin-top:-9px;margin-right:12px;"><?php echo date('D, F d, Y'); ?><br><span style="font-size:12px;"><?php echo date("H:i")." EST";?></span></span>
</div>
<table class="todays_rate_tbl u-full-width" cellspacing="0" cellpadding="5" >
<tbody>
<tr>
<th>Program</th>
<th>Rate</th>
<th>APR</th>
<th>Points</th>
<th>Assumptions</th>
</tr>
<tr>
<td style="color: #f5911e;font-weight:bold;" colspan="4">Conventional</td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">10 Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[7][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[7][2],3)."%";?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip">View

<span>
	<h6 align="center">Conventional 10 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
The interest rate shown is with no points for a 10 year fixed, <b>"no cash-out"</b> refinance loan and assumes a minimum FICO score of 740 with a maximum <b>loan-to-value ratio of 80%</b> on a primary residence.
The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. 
Some state and county maximum loan amount restrictions may apply.
</span>
</a></td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">15-Year Fixed

</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[6][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[6][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip2">View
<span>
	<h6 align="center">Conventional 15 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
The interest rate shown is with no points for a 15 year fixed, <b>"no cash-out"</b> refinance loan and assumes a minimum FICO score of 740 with a maximum <b>loan-to-value ratio of 80% </b>on a primary residence. 
The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.	
</span></a>
</td>
</tr>
<tr>
<td>30-Year Fixed</td>
<td style="color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[5][1],3)."%"; ?></td>
<td><?php echo number_format($loanProgramArray[5][2],3)."%"; ?></td>
<td>0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip3">View
<span>
	<h6 align="center">Conventional 30 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 30 year fixed, <b>"no cash-out"</b> refinance loan and assumes a minimum FICO score of 740 with a maximum <b>loan-to-value ratio of 75%</b> on a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. 
	Payment does not include taxes and insurance premiums. The actual payment amount will be greater.
	Some state and county maximum loan amount restrictions may apply.

</span></a>


</a></td>
</tr>
<tr>
<td height="10"></td>
</tr>
<tr>
<td style="color: #f5911e;font-weight:bold;" colspan="4">FHA</td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">15-Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[8][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[8][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip4">View
<span>
	<h6 align="center">FHA 15 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
The interest rate shown is with no points for a 15 year fixed and assumes a minimum FICO score of 680 with a maximum <b>loan-to-value ratio of 96.5%</b> on a purchase of an owner occupied single family residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. 
The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.	
</span>

</a></td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">30-Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[0][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[0][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip5">View
<span>
	<h6 align="center">FHA 30 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum <b>loan-to-value ratio of 96.5%</b> on a purchase of primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. 
	The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.
</span>
</a></td>
</tr>
<tr>
<td>5/1 Adjustable</td>
<td style="color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[11][1],3)."%"; ?></td>
<td><?php echo number_format($loanProgramArray[11][2],3)."%"; ?></td>
<td>0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip6">View
<span>
	<h6	align="center">FHA 5/1 Adjustable</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 5-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum <b>loan-to-value ratio of 96.5%</b> on a purchase of an owner occupied single family residence. After the initial 5 years, interest rate can change once every year for the remaining life of the loan. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.
</span>
</a></td>
</tr>
<tr>
<td height="10"></td>
</tr>
<tr>
<td style="color: #f5911e;font-weight:bold;" colspan="4">VA</td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">15-Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[10][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[10][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip7">View
<span>
	<h6	align="center">VA 15 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 15 year fixed and assumes a minimum FICO score of 680 with a maximum <b>loan-to-value ratio of 100%</b> on a purchase of an owner occupied single family residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs.	
</span>
</a></td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">30-Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[1][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[1][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip8">View
<span>
	<h6 align="center">VA 30 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum loan-to-value ratio of 100% on a purchase of primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice.The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.
</span>
</a></td>
</tr>
<tr>
<td>5/1 Adjustable</td>
<td style="color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[12][1],3)."%"; ?></td>
<td><?php echo number_format($loanProgramArray[12][2],3)."%"; ?></td>
<td>0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip9">View
<span>
	<h6 align="center">VA 5/1 Adjustable</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 5-year adjustable rate loan and assumes a minimum FICO score of 680 with a maximum loan-to-value ratio of 100% on a purchase of an owner occupied single family residence. After the initial 5 years, interest rate can change once every year for the remaining life of the loan. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. without notice.	
</span>
</a></td>
</tr>
<tr>
<td height="10"></td>
</tr>
<tr>
<td style="color: #f5911e;font-weight:bold;" colspan="4">USDA</td>
</tr>
<tr>
<td style="border-bottom:1px solid #eeeeee;">30 Year Fixed</td>
<td style="border-bottom:1px solid #eeeeee;color: #f5911e;font-weight:bold;"><?php echo number_format($loanProgramArray[4][1],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;"><?php echo number_format($loanProgramArray[4][2],3)."%"; ?></td>
<td style="border-bottom:1px solid #eeeeee;">0.0000</td>
<td style="border-bottom:1px solid #eeeeee;" align="center"><a href="#" class="tooltip10">View
<span>
	<h6 align="center">USDA 30 Year Fixed</h6>
	<h6 align="center">Important disclosures, assumptions, and information</h6>
	The interest rate shown is with no points for a 30 year fixed and assumes a minimum FICO score of 680 with a maximum loan-to-value ratio of 100% on purchase of a primary residence. The actual interest rate, APR, and payment may vary based on the specific terms of the loan selected, verification of information, your credit history, the location and type of property, and other factors as determined by Sun West Mortgage Company, Inc. Not available in all states. Rates are subject to change daily without notice. The borrower may choose to apply for a loan with (1) other fee options in which points and/or fees are charged to obtain a lower interest rate, or (2) higher rate to obtain a credit towards certain eligible closing costs. Payment does not include taxes and insurance premiums. The actual payment amount will be greater. 
	Some state and county maximum loan amount restrictions may apply.
</span>
</a></td>
</tr>
<tr>
<td height="10"></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
				
</div>
<div style="padding-top: 100px;">
<hr />
</div>
<div class="ten columns" style="margin-bottom:30px;">
<div class="three columns">
<img alt="" src="wp-content/uploads/2015/05/calculator_200.png" class="col_sect_img"/>
<div><b>Loan Calculators</b></div>
<p>Use one of our many calculators to help you with your loan.</p>
<div class="col_sect_links"><a href="<?php echo site_url()."/loan-calculators"; ?>" style="font-weight:bold;">Calculate > </a></div>
</div>
<div class="three columns">
<img alt="" src="wp-content/uploads/2015/05/location_200.png" class="col_sect_img"/>
<div><b>Feedback</b></div>
<p>Tell us what you think</p><br>
<div class="col_sect_links"><a href="#" style="font-weight:bold;">Submit > </a></div>
</div>
<div class="three columns">
<img alt="" src="wp-content/uploads/2015/05/contact_us_200.png" class="col_sect_img"/>
<div><b>Contact Us</b></div>
<p>Have a question ? Need further assistance ?.</p>
<div class="col_sect_links"><a href="<?php echo site_url()."/contact"; ?>" style="font-weight:bold;">Contact > </a></div>
</div>
</div>
<div>
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

<?php get_footer();