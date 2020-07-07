<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns:v="urn:schemas-microsoft-com:vml">
	<head>
		<!-- Define Charset -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
		<!-- Responsive Meta Tag -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
		<link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
		
	    <title>Evergene</title><!-- Responsive Styles and Valid Styles -->

	    <style type="text/css">
		    body{
	            width: 100%; 
	            background-color: #ffffff; 
	            margin:0; 
	            padding:0; 
	            -webkit-font-smoothing: antialiased;
	            mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px;
	        }
	        
	        p,h1,h2,h3,h4{
		        margin-top:0;
				margin-bottom:0;
				padding-top:0;
				padding-bottom:0;
	        }
	        
	        span.preheader{display: none; font-size: 1px;}
	        
	        html{
	            width: 100%; 
	        }
	        
	        table{
	            font-size: 14px;
	            border: 0;
	        }
			
			 /* ----------- responsivity ----------- */
	        @media only screen and (max-width: 640px){
				/*------ top header ------ */	
	            body[yahoo] .show{display: block !important;}
	            body[yahoo] .hide{display: none !important;}
	            
	            /*----- main image -------*/
				body[yahoo] .main-image img{width: 440px !important; height: auto !important;}
				 
				/* ====== divider ====== */
				body[yahoo] .divider img{width: 440px !important;}
				
				/*--------- banner ----------*/
				body[yahoo] .banner img{width: 440px !important; height: auto !important;}
				/*-------- container --------*/			
				body[yahoo] .container590{width: 440px !important;}
				body[yahoo] .container580{width: 400px !important;}
				body[yahoo] .container1{width: 420px !important;}
				body[yahoo] .container2{width: 400px !important;}
				body[yahoo] .container3{width: 380px !important;}
	           
				/*-------- secions ----------*/
				body[yahoo] .section-item{width: 440px !important;}
	            body[yahoo] .section-img img{width: 220px !important; height: auto !important;}        
	        }

			@media only screen and (max-width: 479px){
				/*------ top header ------ */
				body[yahoo] .main-header{font-size: 24px !important;}
	            body[yahoo] .resize-text{font-size: 13px !important;}
	            
	            /*----- main image -------*/
				body[yahoo] .main-image img{width: 280px !important; height: auto !important;}
				 
				/* ====== divider ====== */
				body[yahoo] .divider img{width: 280px !important;}
				body[yahoo] .align-center{text-align: center !important;}
				
				
				/*-------- container --------*/			
				body[yahoo] .container590{width: 280px !important;}
				body[yahoo] .container580{width: 250px !important;}
				
				body[yahoo] .section-img img{width: 210px !important; height: auto !important;}        
				
	            /*------- CTA -------------*/
				body[yahoo] .cta-button{width: 220px !important;}
				body[yahoo] .cta-text{font-size: 15px !important;}
			}			
		</style>
	</head>
	<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">		
			<tr>
				<td height="90" style="font-size: 90px; line-height: 90px;">&nbsp;</td>
			</tr>		
			<tr>
				<td>
					<table border="0" align="center" width="510" cellpadding="0" cellspacing="0" bgcolor="86c44c" class="container590 bodybg_color" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">					
						<tr>
							<td height="7" style="font-size: 7px; line-height: 7px;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>		
			<tr>
				<td>
					<table border="0" align="center" width="510" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="container590 bodybg_color">					
						<tr>
							<td align="center" class="section-img">
								<a href="" style="display: block; border-style: none !important; border: 0 !important;">
									<img width="510" border="0" style="display: block; margin: 60px 0px 20px 0px; width: 130px;" src="https://appvelo.com/evergene/assets/front/images/logo/logo.png" alt="Evergene" />
								</a>
							</td>			
						</tr>					
						<tr>
							<td height="35" style="font-size: 35px; line-height: 35px;">&nbsp;</td>
						</tr>					
						<tr>
							<td align="center" style="color: #1c2029; font-size: 24px; font-family: 'Times New Roman', Times, serif; mso-line-height-rule: exactly; line-height: 30px;" class="title_color main-header">							
								<div style="line-height: 30px;">	        					
		        					<?=$title?>	        					
								</div>
	        				</td>
						</tr>					
						<tr>
							<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
						</tr>					
						<tr>
							<td>
								<table border="0" width="440" align="center" cellpadding="0" cellspacing="0" class="container580">		
									<tr>
										<td align="center" style="color: #737b8c; font-size: 16px; font-family: 'Times New Roman', Times, serif; mso-line-height-rule: exactly; line-height: 24px;" class="resize-text text_color">
											<div style="line-height: 24px">
												<?=$body?>
											</div>
				        				</td>	
									</tr>
								</table>
							</td>
						</tr>					
						<tr>
							<td height="35" style="font-size: 35px; line-height: 35px;">&nbsp;</td>
						</tr>
						<?php
							if($link!='') {
						?>
						
								<tr>
									<td align="center">									
										<table border="0" align="center" width="220" cellpadding="0" cellspacing="0" bgcolor="86c44c" style="margin: 5px 0px 15px 0px; box-shadow: 0 1px 2px rgba(0,0,0,.3);" class="cta-button main_color">										
											<tr>
												<td height="13" style="font-size: 13px; line-height: 13px;">&nbsp;</td>
											</tr>										
											<tr>											
				                				<td align="center" style="color: #ffffff; font-size: 14px; font-family: 'Times New Roman', Times, serif" class="cta-text">
					                    			<div style=" line-height: 24px;">
						                    			<a href="<?=$link?>" target="_blank" style="font-size: 17px; color: #ffffff; text-decoration: none;"><?=$link_name?></a> 
					                    			</div>		                            
					                    		</td>				                    		
				                			</tr>										
											<tr><td height="13" style="font-size: 13px; line-height: 13px;">&nbsp;</td></tr>		
										</table>
									</td>
								</tr>
						<?php
							}
						?>
						<tr>
							<td height="30" style="font-size: 30px; line-height: 30px;">&nbsp;</td>
						</tr>								
					</table>
				</td>
			</tr>		
			<tr>
				<td>
					<table border="0" width="510" align="center" cellpadding="0" cellspacing="0" bgcolor="f2f4f6" class="container590">		<tr>
							<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
						</tr>					
						<tr>						
							<td align="center" style="color: #b0b7c7; font-size: 14px; font-family: 'Questrial', sans-serif; mso-line-height-rule: exactly; line-height: 30px;" class="text_color">
								<div style="line-height: 30px">								
		        					© <?=date('Y')?> evergene.me &nbsp; All Rights Reserved.	        					
								</div>
	        				</td>	
						</tr>					
						<tr>
							<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
						</tr>					
					</table>
				</td>
			</tr>		
			<tr>
				<td height="90" style="font-size: 90px; line-height: 90px;">&nbsp;</td>
			</tr>		
		</table>
	</body>
</html>