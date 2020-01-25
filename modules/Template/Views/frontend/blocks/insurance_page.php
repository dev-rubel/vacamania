<?php /* Template Name: BlankLayout */ 

            $text = "";

		    global $fullname, $icno, $contactno, $email, $address, $travel_destination, $num_of_days, $travel_type, $family_member, $travel_plan, $travel_start, $travel_end, $agency_name, $additional, $price, $recipient;
            $text = "";
            
            global $itemID;
            
            if(isset($_GET["status_id"]) && isset($_GET["billcode"]))
            {
                $status_id = input($_GET["status_id"]);
                $billcode = input($_GET["billcode"]);
                
                if($status_id == "1" && checkBill($billcode) == "1")
                {
                        $text = "<i>Thank you, your payment has been made successfully. Our admin will be contact you soon.</i><br/><br/>";
                    
                        global $fullname, $icno, $contactno, $email, $address, $travel_destination, $num_of_days, $travel_type, $family_member, $travel_plan, $travel_start, $travel_end, $agency_name, $additional, $price, $recipient;
                    
                    	$servername = "localhost";
                    	$username = "u7424045_insurance"; 
                    	$password = "5f@awkvH~[Mr";
                    	$dbname = "u7424045_vacamania";
                    
                    	try 
                    	{
                    	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    		// set the PDO error mode to exception
                    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    		
                    		
                    		$stmtrecipient = $conn->prepare("SELECT * FROM wp_insurance_registration WHERE id=:itemid"); 
                    		$stmtrecipient->bindParam(':itemid', $itemID);
                    		
                    		$itemID = input($_GET["userID"]);
                    		
                            $stmtrecipient->execute(); 
                            $resultrecipient = $stmtrecipient->fetchAll();
                                    
                            foreach($resultrecipient as $row){
                                
                                global $fullname, $icno, $contactno, $email, $address, $travel_destination, $num_of_days, $travel_type, $family_member, $travel_plan, $travel_start, $travel_end, $agency_name, $additional, $price, $recipient;
                                
                                $fullname = $row['fullname'];
                                $icno = $row['icno'];
                                $contactno = $row['contactno'];
                                $email = $row['email'];
                                $address = $row['address'];
                                $travel_destination = $row['travel_destination'];
                                $num_of_days = $row['num_of_days'];
                                $travel_type = $row['travel_type'];
                                $family_member = $row['family_member'];
                                $travel_plan = $row['travel_plan'];
                                $travel_start = $row['travel_start'];
                                $travel_end = $row['travel_end'];
                                $additional = $row['additional'];
                                $price = $row['price'];
                                $agency_name = $row['agency_name'];
                                $recipient = $row['emailnotification'];
                                
                            }
                    			
                    	    sendEmailInsurance();
                    	    sendEmailRegisterer();
            
                    	}
                    	catch(Exception $e)
                    	{
                    		$errortext = $e->getMessage();
                        		
                        	echo "<script type='text/javascript'>alert('$errortext');</script>";
                    	}
                    	
                    	$conn = null;
                }
                else
                {
                    $text = "<i>Sorry your payment is not made successfully. Please contact our support or try again. </i><br/><br/>";
                }   
            }
            
            function formatDate($date)
        	{
        	    $date_split = explode("-",$date);
        	    
        	    return $date_split[2] . "/" . $date_split[1] . "/" . $date_split[0];
        	    
        	}
        	
            function input($data) {
        	  $data = trim($data);
        	  $data = stripslashes($data);
        	  $data = htmlspecialchars($data);
        	  return $data;
        	}
        	
            function checkBill($billCode)
            {
                          $some_data = array(
                            'billCode' => $billCode
                          );  
                        
                          $curl = curl_init();
                        
                          curl_setopt($curl, CURLOPT_POST, 1);
                          curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBillTransactions');  
                          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                          curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
                        
                          $result = curl_exec($curl);
                          $info = curl_getinfo($curl);  
                          curl_close($curl);
                          
                          $obj = json_decode($result, true);
                        
                          $billpaymentStatus = $obj[0]["billpaymentStatus"];
                          
                          return $billpaymentStatus;
            }
            
            function sendEmailInsurance()
            {
                        global $fullname, $icno, $contactno, $email, $address, $travel_destination, $num_of_days, $travel_type, $family_member, $travel_plan, $travel_start, $travel_end, $agency_name, $additional, $price, $recipient;
                        
                	    try
                	    {
                	        if($additional == "")
                	        {
                	            $additional = "-";
                	        }
                	        if($family_member == "")
                	        {
                	            $family_member = "-";
                	        }
                	        if($agency_name == "")
                	        {
                	            $agency_name = "-";
                	        }
                	        
                    	    $subject = "New Vacamania Insurance Application";
                            $body = "
                                <html>
                                <head>
                                <title>New Vacamania Insurance Application</title>
                                </head>
                                <body>
                                <p>Dear recipient, </p>
                                <p>You have one application from vacamania insurance as below</p>
                                <table>
                                    <tr>
                                        <td style='width:100px'>Fullname</td>
                                        <td style='width:5px'>:</td>
                                        <td>" . $fullname . "</td>
                                    </tr>
                                    <tr>
                                        <td>IC No</td>
                                        <td>:</td>
                                        <td>" . $icno . "</td>
                                    </tr>
                                    <tr>
                                        <td>Contact No</td>
                                        <td>:</td>
                                        <td>" . $contactno . "</td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td>:</td>
                                        <td>" . $email . "</td>
                                    </tr>
                                    <tr>
                                        <td>Home Address</td>
                                        <td>:</td>
                                        <td>" . $address . "</td>
                                    </tr>
                                    <tr>
                                        <td>Travel Destination</td>
                                        <td>:</td>
                                        <td>" . $travel_destination . "</td>
                                    </tr>
                                    <tr>
                                        <td>Travel Type</td>
                                        <td>:</td>
                                        <td>" . $travel_type . "</td>
                                    </tr>
                                    <tr>
                                        <td>Family Member</td>
                                        <td>:</td>
                                        <td>" . nl2br($family_member) . "</td>
                                    </tr>
                                    <tr>
                                        <td>Travel Plan</td>
                                        <td>:</td>
                                        <td>" . $travel_plan . "</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Days</td>
                                        <td>:</td>
                                        <td>" . $num_of_days . "</td>
                                    </tr>
                                    <tr>
                                        <td>Additional</td>
                                        <td>:</td>
                                        <td>" . $additional . "</td>
                                    </tr>
                                    <tr>
                                        <td>Travel Date</td>
                                        <td>:</td>
                                        <td>" . formatDate($travel_start) . " to " . formatDate($travel_end) . "</td>
                                    </tr>
                                    <tr>
                                        <td>Agency Name</td>
                                        <td>:</td>
                                        <td>" . $agency_name . "</td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>:</td>
                                        <td>RM " . $price . "</td>
                                    </tr>
                                </table>
                                </body>
                                </html>
                            ";
                            
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= 'From: <insuranvisa@gmail.com>' . "\r\n";
                            
                            mail($recipient, $subject, $body, $headers);
                            
                	    }
                	    catch(Exception $e)
                    	{
                    		$errortext = $e->getMessage();
                    		echo "<script type='text/javascript'>alert('$errortext');</script>";
                    	}
            }
            
            function sendEmailRegisterer()
            {
                        global $fullname, $icno, $contactno, $email, $address, $travel_destination, $num_of_days, $travel_type, $family_member, $travel_plan, $travel_start, $travel_end, $agency_name, $additional, $price, $recipient;

                	    try
                	    {
                	        
                	        if($additional == "")
                	        {
                	            $additional = "-";
                	        }
                	        if($family_member == "")
                	        {
                	            $family_member = "-";
                	        }
                	        if($agency_name == "")
                	        {
                	            $agency_name = "-";
                	        }
                	        
                    	    $subject = "Successful payment for Vacamania Insurance Application";
                    	    
                            $body = "<html>";
                            $body .= "<head>";
                            $body .= "<title>Successful payment for Vacamania Insurance Application</title>";
                            $body .= "</head>";
                            $body .= "<body>";
                            $body .= "<p>Dear recipient, </p>";
                            $body .= "<p>Your payment for vacamania insurance application has been made successfully. Your Insurance details as below</p>";
                            $body .= "<table>";
                            $body .= "<tr>";
                            $body .= "<td style='width:100px'>Fullname</td>";
                            $body .= "<td style='width:5px'>:</td>";
                            $body .= "<td>" . $fullname . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>IC No</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $icno . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Contact No</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $contactno . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Email Address</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $email . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Home Address</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $address . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Travel Destination</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $travel_destination . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Travel Type</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $travel_type . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Family Member</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . nl2br($family_member) . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Travel Plan</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $travel_plan . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Number of Days</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $num_of_days . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Additional</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $additional . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Travel Date</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . formatDate($travel_start) . " to " . formatDate($travel_end) . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Agency Name</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>" . $agency_name . "</td>";
                            $body .= "</tr>";
                            $body .= "<tr>";
                            $body .= "<td>Price</td>";
                            $body .= "<td>:</td>";
                            $body .= "<td>RM " . $price . "</td>";
                            $body .= "</tr>";
                            $body .= "</table>";
                            $body .= "</body>";
                            $body .= "</html>";
                        
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= 'From: <insuranvisa@gmail.com>' . "\r\n";

                            mail($email, $subject, $body, $headers);
                            
                	    }
                	    catch(Exception $e)
                    	{
                    		$errortext = $e->getMessage();
                    		echo "<script type='text/javascript'>alert('$errortext');</script>";
                    	}
            }
    
	?>
<!doctype html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<title>Vacamania Insurance</title>	
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	
	    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	

<style>

    .bravo_topbar, .bravo_header, .bravo_footer
    {
    	display:none !important;
    }
	
	@font-face {
	  font-family: KievitOT-Regular;
	  src: url("https://vacamania.com/public/insurance/fonts/KievitOT-Regular.otf");
	}

	@font-face {
	  font-family: KievitOT-Bold;
	  src: url("https://vacamania.com/public/insurance/fonts/KievitOT-Bold.otf");
	}
		
	#insurance_background {
		background: url("https://vacamania.com/public/insurance/background.jpg");
		background-repeat: no-repeat;
		background-size:cover;
	}
	
	#registration-form
	{
		font-family: KievitOT-Regular !important;	
		padding-top:20px;
		padding-bottom:10px;
	}
	
	#registration-form label
	{
		font-size:14px;
	}
	
	#left-column
	{
		font-family: KievitOT-Regular !important;	
		text-shadow:1px 1px white;
	}
	
	#left-column h1
	{
		font-family: KievitOT-Bold !important;
	}
	
	.benefit-list .benefit-item
	{
		height:100px;
		background-color:rgba(255, 255, 255, 0.4);
		font-size:20px;	
		padding-top:30px;
		padding-left:25px;
	}
	
	footer
	{
		background-color: #3a4449;
		color:white;
		opacity: 0.8;
	}
	
	.fa
	{
		font-size:30px;
	}
	
	.container
	{
		width: 90% !important;
	}
	
	body
	{
		font-family: 'Poppins', sans-serif;
	}
	
	#buyNow
	{
		background-color: #093a60 !important;
	}
	
	.whatsapp
	{
	    float:right;
	    padding:15px;
	    line-height:20px;
	    height:50px;
	    font-size:18px;
	}
	
	
	
	.ribbon {
	  width: 48%;
	  position: relative;
	  float: left;
	  margin-bottom: 30px;
	  background-size: cover;
	  text-transform: uppercase;
	  color: white;
	}
	
	.ribbon1 {
	  position: absolute;
	  top: -26.1px;
	  right: -162px;
	}
	.ribbon1:after {
	  position: absolute;
	  content: "";
	  width: 0;
	  height: 0;
	  border-left: 50px solid transparent;
	  border-right: 40px solid transparent;
	  border-top: 10px solid #093a60;
	}
	.ribbon1 span {
	  position: relative;
	  display: block;
	  text-align: center;
	  background: #093a60;
	  font-size: 14px;
	  line-height: 1;
	  padding: 12px 8px 10px;
	  border-top-right-radius: 8px;
	  width: 90px;
	}
	.ribbon1 span:before, .ribbon1 span:after {
	  position: absolute;
	  content: "";
	}
	.ribbon1 span:before {
	 height: 6px;
	 width: 6px;
	 left: -6px;
	 top: 0;
	 background: #093a60;
	}
	.ribbon1 span:after {
	 height: 6px;
	 width: 8px;
	 left: -8px;
	 top: 0;
	 border-radius: 8px 8px 0 0;
	 background: #093a60;
	}
	
	.ribbon:nth-child(even) {
	  margin-right: 4%;
	}
	
	.total-price
	{
	    font-family:'Myriad Pro';
	    font-size:33px;
	    font-weight:bold;
	    text-align:center;
	}
	
	#advActivitiesviewmore
	{
	    cursor:pointer;
	}
	
	[type="checkbox"]:not(:checked), [type="checkbox"]:checked
	{
	    position:relative !important;
	    opacity:unset !important;
	    pointer-events: initial !important;
	}

	@media (max-width: 500px) {
	  .ribbon {
		width: 100%;
	  }
	  .ribbon:nth-child(even) {
		margin-right: 0%;
	  }
	}

	
	
</style>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	
	 <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    
    
    
  
        

</head>
	
<body>
	
	

	<div id="insurance_background">
				
        <header>
       
        </header>
		
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						    
							<a class="navbar-brand" href="https://vacamania.com/"><img alt="Vacamania logo" class="logo animate fadeInDown one" src="https://vacamania.com/public/insurance/logo.png"></a>
						  						  						
					</div>
					
					<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
					    
					        <span class="whatsapp">Any inquiries please call 03-61779056 or <a href="http://www.wasap.my/601110557413" target="_blank">whatsapp</a> us</span>
					</div>
                </div>
				
                <div class="row">
                    <div class="col-lg-8 col-md-7 animate fadeInDown two" id="left-column">
                        <div class="row">
                            <div class="col-sm-12 mt-4">
                                <h1><strong>TRAVEL 360 TAKAFUL</strong></h1>
                                <h5><strong class="ng-binding">Travel is coming home with memories, not worries</strong></h5><br/>
                                <span><a href="https://vacamania.com/public/insurance/INSURANCE PLANS & BENEFITS.pdf" target="_blank">Click here</a> to view all insurance plans and benefits</span>
                            </div>
                        </div>
						
						<!-- Key Benefits -->
                        <div class="row">
                            <div class="col-sm-12 benefit-list">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-headphones" aria-hidden="true"></i>
                                        <span class="ng-binding">24-hour Travel and Medical Assistance</span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        <span class="ng-binding">Family Coverage</span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-ambulance" aria-hidden="true"></i>
                                        <span class="ng-binding">Medical Coverage</span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-suitcase" aria-hidden="true"></i>
                                        <span class="ng-binding">Travel Inconveniences</span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-umbrella" aria-hidden="true"></i>
                                        <span class="ng-binding">Takaful Coverage</span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-6 benefit-item">
                                        <i class="fa fa-bomb" aria-hidden="true"></i>
                                        <span class="ng-binding">Terrorism Coverage</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-lg-4 col-md-5 animate fadeInRight two">
                        <div class="col-sm-12 col-md-12" style="text-align: right; padding-right: 0px;">
                            <strong>
                                
                            </strong>
                        </div>
						
                        <div id="accordion" role="tablist">
                            							
                            <div class="card" id="registration-form">
                                
								<div class="ribbon">
									<span class="ribbon1">
									  <span>Apply Now</span>
									</span>
								  </div>
								
                                <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" style="border-radius: 50px">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-12">
												<div style="margin-bottom: 10px;">
													
													<div id="message"><?php echo $text; ?></div>
													
													<form action="https://vacamania.com/public/insurance/process.php" method="POST">
														
														<label id="destLabel">
														&nbsp;Fullname </label>

														<input type="text" id="fullname" name="fullname" class="form-control" required/>

														<label id="icnoLabel">
															IC Number
														</label>

														<input type="text" id="icno" name="icno" class="form-control" required/>

														<label id="contactnoLabel">
															Contact No
														</label>

														<input type="text" id="contactno" name="contactno" class="form-control" required/>

														<label id="emailLabel">
															Email Address
														</label>

														<input type="email" id="email" name="email" class="form-control" required/>

														<label id="addressLabel">
															Home Address
														</label>

														<textarea id="address" name="address" class="form-control" required></textarea>

														<label id="travel_destinationLabel">
															Travel Destination
														</label>

														<select class="form-control" name="travel_destination" id="travel_destination" required>									
															<option value="">
																Select</option>
															<option value="4">
																Worldwide including Nepal, USA &amp; Canada</option>
															<option value="3">
																Worldwide excluding Nepal, USA &amp; Canada</option>
															<option value="2">
																Selected Asian countries*</option>
															<option value="1">
																Within Malaysia</option>
														</select>
														
														<label style="font-size:10px;"><i>
														    *For Umrah please choose 'Worldwide excluding Nepal, USA & Canada'
														</i></label>
														
														<input type="hidden" name="travel_destination_text" id="travel_destination_text">



														<label id="coverTypeLabel">
															Travel Type
														</label>

														<select class="form-control" name="travel_type" id="travel_type" required>									
															<option value="">
																Select</option>
															<option value="Individual (Adult)">
																Individu (Adult 18-70 years)</option>
															<option value="Individual (Senior Citizen)">
																Individu (Adult 71-80 years)</option>
															<option value="Spouse">
																Spouse</option>
															<option value="Family">
																Family</option>
														</select>
														
														<label id="lblfamilymember">
															Family Member (Name and IC No)
														</label>

														<textarea id="familymember" name="familymember" class="form-control"></textarea>
														
														<label style="font-size:10px;"><i>
														    *Spouse <br/>
														    *Unlimited biological children
														</i></label><br/>

														<label id="packageTypeLabel">Travel Plan
														</label>

														<select class="form-control" name="travel_plan" id="travel_plan" required>									
															<option value="">
																Select</option>
															<option value="Domestic">
																Domestic</option>
															<option value="Silver">
																Silver</option>
															<option value="Gold">
																Gold</option>
															<option value="Platinum">
																Platinum</option>
														</select>
														
														<label id="coverTypeLabel">
															Number of Days
														</label>

														<select class="form-control" name="num_of_days" id="num_of_days" required>									
															<option value="">
																Select</option>
															<option value="1-5">
																1-5 days</option>
															<option value="6-10">
																6-10 days</option>
															<option value="11-18">
																11-18 days</option>
															<option value="19-30">
																19-30 days</option>
															<option value="19-30">
																More than 1 month and less than 1 year</option>
															<option value="Annual">
																Annual</option>
														</select>
														
														<label id="coverTypeLabel">
															Additional
														</label>
														
														<div class="row" style="margin-bottom: 0px !important;">
    														<input type="checkbox" name="addWeek" id="addWeek" value="Each add. week" disabled/><label>Each add. week</label>
    														
    														<label>, for</label> <input type="text" id="addWeek_no" name="addWeek_no" style="height:20px !important; width:50px; text-align:center;" disabled/> <label>week</label>
    														
    													</div>
    													
    													<div class="row">
                                                            <input type="checkbox" name="advActivities" id="advActivities" value="Adventurous Activities"/><label>Adventurous Activities</label>
                                                            
                                                            <label id="advActivitiesviewmore">(View More)</label>
                                                            <br>
                                                            
                                                            
                                                            <div id="advActivitiesdialog" title="About Adventurous Activities">
                                                                <p>Additional Cover for Adventurous Activities</p>
                                                                <p>For an additional contribution, you can be covered for the following are activities in the event of death, permanent disability, medical and other expenses:</p>
                                                                <p>
                                                                    a) Abseiling<br/>
                                                                    b) Bungee jumping<br/>
                                                                    c) Sky diving<br/>
                                                                    d) Hang-gliding<br/>
                                                                    e) Helicopter rides for sightseeing<br/>
                                                                    f) Hot air ballooning<br/>
                                                                    g) Ultra-marathons<br/>
                                                                    h) Water sports - Jet skiing, rowing, yachting, parasailing, surfing, windsurfing (boardsailing)<br/>
                                                                    i) Mountaineering on mountains below the height of 3,000 metres above sea level necessitating the use of ropes and other climbing equipment<br/>
                                                                    j) Rockclimbing necessitating the use ofropes and other climbingequipment<br/>
                                                                    k) Skiing or snowboarding all within official approved areas of a ski resort<br/>
                                                                    l) Canoeing or white water rafting with a qualified guide and up to Grade 3 (of International Scale of River Difficulty)<br/>
                                                                    m) Underwater activities involving artificial breathing apparatus for diving up to a maximum depth of 30 metres with a qualified diving instructor and with recognised diving certification
                                                                </p>    
                                                                <p>Note: Provided always that the above activities are done on an amateur basis and for leisure purpose with a licensed operator during the journey</p>
                                                                
                                                            </div>
                                                        </div>

														<label id="travelPeriodLabel">
															Travel Date
														</label>

														<div class="row">

															<div class="col-md-5 col-lg-5">
																<input type="text" id="travel_start" name="travel_start" class="form-control" required/>
															</div>

															<div class="col-md-2 col-lg-2" style="padding-top:20px">
																<span>to</span>
															</div>

															<div class="col-md-5 col-lg-5">			
																<input type="text" id="travel_end" name="travel_end" class="form-control" required/>
															</div>

														</div>
														
														<label id="agencyLabel">
															Travel Agency Name & Phone No (for travel agency) 
														</label>

														<input type="text" id="agencyname" name="agencyname" class="form-control"/>

                                                        <div class="total-price">
                                                           <span id="price"></span>
                                                           <input type="hidden" id="price-hidden" name="price-hidden"/>
                                                        </div>
                                                        
														<input type="submit" name="submit" id="buyNow" class="btn btn-primary btn-center col-md-12" value="Buy Now"/>
														
														<br/><br/>
														
														<label style="font-size:10px;"><i>
														    *Selected Asian Countries : Bangladesh, Bhutan, Brunei, Cambodia, China, Hong Kong, India, Indonesia, Japan, Laos, Macau, Maldives, Myanmar, Pakistan, Philippines, Sikkim, Singapore, South Korea, Sri Lanka, Taiwan, Thailand, Timor Leste and Vietnam
														    <br/>
														    *Excluded Countries : War, riots, or countries or regions with mass conflicts, or quarantine for contagious disease, including Afghanistan, Iraq, Iran, North Korea, Palestine, Syria, Ukraine or Africa (All Africa country EXCEPT Botswana, Kenya, Lesotho, Madagascar, Malawi, Mauritius, Mozambique, Namibia, Seychelles, South Africa, Swaziland, Tanzania, Zambia and Zimbabwe).
														</i></label>
														
													
													</form>
												
													
												</div>
                                            </div>
                                            
											
                                            
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
        <footer style="text-align: center">
            Insurance by
            <img src="https://vacamania.com/public/insurance/etiqa.png" width="50px" alt="Etiqa logo" class="bench animate fadeInUp one">
        </footer>
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
  
        <script>
            var j = jQuery.noConflict();
            
            j(document).ready(function(){
                
                 j("#travel_destination").change(function(){
                        var text = j("#travel_destination").find(":selected").text();

                        j("#travel_destination_text").val(text.trim());
                });
                
                j("#addWeek_no").keyup(function(){
                    $text = j("#addWeek_no").val();
                    if($text != "")
                    {
                        if($text % 1 != 0)
                        {
                            j("#addWeek_no").val('');
                        }
                    }
                });
                
                j("#num_of_days").change(function(){
                        var text = j("#num_of_days").find(":selected").text();

                        if(text.trim() == "More than 1 month and less than 1 year")
                        {
                            j("#addWeek_no").removeAttr('disabled');
                            
                            j("#addWeek").prop('checked', true);
                            j("#addWeek_no").attr('required','true');
                        }
                        else
                        {
                            j("#addWeek_no").attr('disabled','disabled');
                            
                            j("#addWeek").removeAttr('checked');
                            j("#addWeek_no").removeAttr('required');
                        }
                        
                });
                
                j( "#advActivitiesdialog" ).dialog({
                  autoOpen: false,
                  show: {
                    effect: "blind",
                    duration: 1000
                  },
                  hide: {
                    effect: "blind",
                    duration: 1000
                  },
                  width: "90%",
                  maxWidth: "768px"
                });
                
                j('#advActivitiesviewmore').click(function(){
     
                    j( "#advActivitiesdialog" ).dialog( "open" );
                    
                });
                
                j('#travel_start').datepicker({dateFormat: 'dd/mm/yy'});
                j('#travel_end').datepicker({dateFormat: 'dd/mm/yy'});
                
                j('#travel_destination, #travel_type, #travel_plan, #num_of_days, #addWeek_no, #advActivities').change(function(){
     
                    getPrice();
                    
                });
                
            });
            
            function getPrice()
            {
                
                    var travel_destination = j('#travel_destination').val();
                    var travel_type = j('#travel_type').val();
                    var travel_plan = j('#travel_plan').val();
                    var travel_start = j('#travel_start').val();
                    var travel_end = j('#travel_end').val();
                    var num_of_days = j('#num_of_days').val();
                    
                    var add_Week = j("#addWeek").prop("checked");
                    var add_WeekNo = j("#addWeek_no").val();
                    
                    var adv_Activities = j('#advActivities').prop("checked");
                    
                    if(travel_destination != "" && travel_type != "" && travel_plan != "" && num_of_days != "")
                    {
                        j.ajax({
                            type: "POST",
                            url: 'https://vacamania.com/public/insurance/getprice.php',
                            data: {traveldestination: travel_destination, traveltype: travel_type, travelplan: travel_plan, numofdays: num_of_days, addWeek:add_Week, addWeekNo:add_WeekNo, advActivities:adv_Activities, travelstart: travel_start, travelend: travel_end },
                            dataType: "json",
                            success: function(data){
                                var len = data.length;
                                var price = "0";
                                for(var i=0; i<len; i++){
                                    price = data[i].price;
                                }
                            
                                if(price == "0")
                                {
                                    price = "Sorry, your travel is not eligible to apply for insurance";
                                    j('.total-price').css("font-size", "18px");
                                    
                                    j('#price').text(price);
                                    j('#price-hidden').val("0");
                                    
                                    j('#buyNow').attr("disabled", true);
                                }
                                else
                                {
                                    j('.total-price').css("font-size", "33px");
                                    
                                    var totalprice = parseFloat(price) + 10;
                                    
                                    j('#price').text("RM " + totalprice.toFixed(2));
                                    j('#price-hidden').val(totalprice.toFixed(2));
                                    
                                    j('#buyNow').attr("disabled", false);
                                }
                                
                                
                                
                                
                            },
                            error: function(xhr, status, error){
                                 var errorMessage = xhr.status + ': ' + xhr.statusText
                                 alert('Error - ' + errorMessage);
                             }
                        });
                    }
            }
                
        </script>
		
		
		
		
		
		
		
    </div>
	


</body>
</html>
