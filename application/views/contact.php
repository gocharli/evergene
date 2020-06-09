<?php $this->load->view('includes/head');   ?>
<body>
<div class="main-page-wrapper">

	<!--
    =============================================
        Theme Header
    ==============================================
    -->
	<?php $this->load->view('includes/menu');   ?>

	<!--
    =============================================
        Theme Inner Banner
    ==============================================
    -->
	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->



	<!--
    =============================================
        Shop Page
    ==============================================
    -->
	<div class="shop-page hub-page">
		<div class="row">
			<div class="container">

				<div class="title-head col-md-12 p-0 m-p-15 text-center">
					<h5 style="padding: 15px 0;">Contact Us</h5>
                    <p>Let's get in touch. Drop a message and we'll get back to you as soon as possible.</p>
				</div>

				<div class="clearfix"></div> <br />
                <div class="col-lg-6 col-md-6 col-xs-12 col-lg-offset-3">
					<div class="shop-product-wrapper service-version-one">

						<div class="row">

							<div class="col-lg-12 col-xs-12">
                                <form id="add_contact" method="post" action="<?php echo base_url(); ?>contact/add">
                                        
                                        <?php if($this->session->flashdata('error')){  ?>
														
                                                <div class="alert alert-danger">     
                                                    <p><?php echo $this->session->flashdata('error'); ?></p>
                                                </div>

                                        <?php } ?>

                                        <?php if($this->session->flashdata('success')){  ?>

                                                <div class="alert alert-success"> 		
                                                    <p><?php echo $this->session->flashdata('success'); ?></p>
                                                </div>

                                        <?php } ?>

                                        

                                        <div class="form-group">
                                            <label></label>
                                            <input type="text" class="form-control" id="cname" name="name"  placeholder="Name" >
                                        </div>
                                        <div class="form-group">
                                            <label></label>
                                            <input type="email" class="form-control" id="cemail" name="email"  placeholder="Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <label></label>
                                            <input type="tel" class="form-control" id="cphone" name="phone" placeholder="Phone Number" required>
                                        </div>
                                        <div class="form-group">
                                            <label></label>
                                            <textarea name="message" id="cmessage" class="form-control" placeholder="Your Enquiry" row="5" required></textarea>
                                        </div>
                                        <div class="recaptcha" name="g-recaptcha1" id="g-recaptcha1"></div>
                                        <div class="form-group">
                                            <button type="button" onclick="add_contact()" class="tran3s cart-button btn-pay block hvr-trim-two">Send Message</button>
                                        </div>
								</form>
								
							</div> <!-- /.col- -->

						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>

<script>
    setTimeout(function() {
  
  $('.recaptcha').each(function() {
    grecaptcha.render(this.id, {
      'sitekey': '6LdVkwkUAAAAACeeETRX--v9Js0vWyjQOTIZxxeB',
      "theme":"light"
    });
  });
  
}, 2000);
    
</script>


<script>


function add_contact(){

        var name = $("#cname").val();
        var email = $("#cemail").val();
        var phone = $("#cphone").val();
        var message = $("#cmessage").val();

        if(name == ''){
            show_alert("Please enter name","error");
            return false;
        }
        if(email == ''){
            show_alert("Please enter email address","error");
            return false;
        }

        if(!isEmail(email)){
            show_alert("Please enter a valid email","error");
            return false;
        }

        if(phone == ''){
            show_alert("Please enter phone","error");
            return false;
        }

        if(!$.isNumeric(phone)){
            show_alert("Please enter a numeric value in phone","error");
            return false;
        }

        if(message == ''){
            show_alert("Please enter your message","error");
            return false;
        }

        var rcres = grecaptcha.getResponse();
        if(rcres.length){
        grecaptcha.reset();
            $("#add_contact").submit();
        }else{
        show_alert("Please verify reCAPTCHA","error");
        }

}



function show_alert(msg){

    $.confirm({
		title: '',
		content: msg,
		type: 'red',
		typeAnimated: true,
		buttons: {
			close: function () {
			}
		}
	});

}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

</script>

</div> <!-- /.main-page-wrapper -->
</body>

