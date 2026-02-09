<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>MeweMarket</title>


	<?php $this->load->view('partial/head')?>

</head>
<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
	<div class="container" data-layout="container">
		<?php $this->load->view('partial/sidebar')?>
		<div class="content">
			<?php $this->load->view('partial/header')?>
			<div class="row">
				<div class="space  mb-0 w-100"></div>
				<div class="card col-lg-12 px-0 theme-wizard mb-5" data-wizard data-controller="#wizard-controller" data-error-modal="#error-modal">
					<div class="card-header bg-light pt-3 pb-2">
						<ul class="nav justify-content-between nav-wizard">
							<li class="nav-item">
								<a class="nav-link <?php if(isset($_GET['payment_completed'])){ echo 'done disabled'; }else{ echo 'active';}?>  font-weight-semi-bold" href="#bootstrap-wizard-tab1" data-toggle="tab">
									<h5 class="mb-0 text-left" id="followers">Create An Account <span class="d-none d-sm-inline-block"></span></h5>
								</a>
								<div class="col-auto fs--1 text-600 mt-2"><span class="mb-0 undefined">Have an account?</span> <span><a id="loginAs" href="javascript:;">Login</a></span></div>
							</li>
							<!-- <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab2" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Personal</span></a></li>
                  <li class="nav-item"><a class="nav-link font-weight-semi-bold <?php if(isset($_GET['payment_completed'])){ echo 'done'; }?> disabled" href="#bootstrap-wizard-tab3" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-dollar-sign"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Billing</span></a></li>
                  <li class="nav-item"><a class="nav-link font-weight-semi-bold <?php if(isset($_GET['payment_completed'])){ echo 'done active'; }else{ echo 'disabled';}?> disabled" href="#bootstrap-wizard-tab4" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-thumbs-up"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Done</span></a></li>
-->
						</ul>
					</div>
					<div class="card-body py-4">
						<div class="tab-content">
							<div class="tab-pane <?php if(!isset($_GET['payment_completed'])){ echo "active"; }?>" id="bootstrap-wizard-tab1">
								<form class="form-validation" data-options='{"rules":{"confirmPassword":{"equalTo":"#wizard-password"}},"messages":{"confirmPassword":{"equalTo":"Passwords didn&#39;t match"},"terms":{"required":"You must accept terms and privacy policy"}}}' method="post" action="<?php echo base_url('users/CreateUser');?>">
									<div class="form-row">

										<div class="col-12">
											<div class="form-gorup">
												<label for="wizard-company_name">Company Name *</label>
												<input class="form-control mb-3" type="text" name="company_name" placeholder="Company Name" id="wizard-company_name" required />
											</div>
										</div>
									</div>

									<div class="form-row">
										<div class="col-6">
											<div class="form-gorup">
												<label for="wizard-name">First Name *</label>
												<input class="form-control" type="text" name="first_name" placeholder="joe" id="wizard-name" required/>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-last_name">Surname *</label>
												<input class="form-control" type="text" name="last_name" placeholder="blogg" id="wizard-last_name" required/>
											</div>
										</div>
									</div>

									<div class="form-row">
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-email">Email *</label>
												<input class="form-control" type="email" name="user_email" placeholder="joe.blogg@email.com" required="required" id="wizard-email" />
												<span id="error"></span>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-date">DOB *</label>
												<?php
												$date = strtotime(date('Y-m-d').' - 18 year');
												 // echoes '2009-01-01'?>
												<input class="form-control datetimepicker flatpickr-input active" type="date" name="date_of_birth"  max="<?php echo date('d/m/y', $date);?>" required="required" id="wizard-date" />
											</div>
										</div>
									</div>

									<div class="form-row">
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-number">Contact Number *</label>
												<input class="form-control" type="text" name="contact_number" placeholder="+447565656" maxlength="15" required="required" id="wizard-number" />
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-country">Country *</label>
												<select class="custom-select selectpicker" required id="wizard-country" name="country">
													<option value="">Select your country ...</option>
													<?php foreach($countries as $country){ ?>
														<option value="<?php echo $country->country_id;?>"><?php echo $country->country_name;?></option>
													<?php }?>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="wizard-street">Street *</label>
										<input class="form-control" type="text" name="street" placeholder="123 High Street" id="wizard-street" />
									</div>

									<div class="form-group">
										<label for="wizard-city">State *</label>
										<input class="form-control" type="text" name="state" placeholder="London" id="wizard-city" />
									</div>

									<div class="form-group">
										<label for="wizard-zipcode">Zipcode *</label>
										<input class="form-control" type="text" name="zip_code" placeholder="AB4 6XY" id="wizard-zipcode" />
									</div>

									<hr class="border-dashed d-block d-md-none d-xl-block d-xxl-none my-4">

									<!--<div class="custom-control custom-checkbox">
									  <input class="custom-control-input" id="wizard-checkbox" type="checkbox" name="terms" required="required"  />
									  <label class="custom-control-label" for="wizard-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
									</div>-->

									<div class="form-group">
										<label for="wizard-username">Username *</label>
										<input class="form-control" type="text" name="user_name" placeholder="joeblog" id="wizard-username" maxlength="30"/>
									</div>
									<div class="form-row">
										<div class="col-6">
											<div class="form-gorup">
												<label for="wizard-password">Password *</label>
												<input class="form-control" type="password" name="user_password" placeholder="Password" required="required" id="wizard-password" />
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-confirm-password">Confirm Password *</label>
												<input class="form-control" type="password" name="confirmPassword" placeholder="Confirm Password" id="wizard-confirm-password" />
											</div>
										</div>
									</div>

									<!--
						<hr class="border-dashed d-block d-md-none d-xl-block d-xxl-none my-4">
						<div class="row">
							<?php
									/*							foreach($packages as $package){
																	if($package->visibility == 1){ */?>

									<div class="col-md-6 mb-3 mb-md-0">
										<div class="custom-control custom-radio radio-select">
											<input class="custom-control-input" id="address-<?php /*echo $package->package_id*/?>" type="radio" value="<?php /*echo $package->package_id*/?>" name="package_id" checked required >
											<label class="custom-control-label font-weight-bold d-block" for="address-<?php /*echo $package->package_id*/?>"><?php /*echo $package->package_name.' - $'.$package->package_amount;*/?>
												<span class="radio-select-content">
													<span><?php /*$features = explode(PHP_EOL,$package->package_description);
														foreach($features as $feature){
															echo $feature.'<br />';
														}*/?> </span>
												</span>
											</label>
										</div>
									</div>

								<?php /*}
							}
							*/?>

						</div>-->

									<div class="col-md-5 col-xl-12 col-xxl-5 pl-lg-4 pl-xl-2 pl-xxl-5 text-center text-md-left text-xl-center text-xxl-left">
										<hr class="border-dashed d-block d-md-none d-xl-block d-xxl-none my-4">
										<button class="btn btn-primary mt-3 px-5" type="submit" id="submit">Register</button>
										<p class="fs--1 mt-3 mb-0">By clicking <strong>Register </strong>button you agree to the <a href="<?php echo base_url('page/terms')?>">Terms &amp; Conditions</a></p>
									</div>

								</form>
							</div>
							<div class="tab-pane px-sm-3 px-md-5" id="bootstrap-wizard-tab3">
								<form class="form-validation">
									<div class="form-row">
										<div class="col">
											<div class="form-group">
												<label for="card-number">Card Number</label>
												<input class="form-control" id="card-number" placeholder="XXXX XXXX XXXX XXXX" type="text" />
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="card-name">Name on Card</label>
												<input class="form-control" id="card-name" placeholder="John Doe" name="cardName" type="text" />
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-6">
											<div class="form-group">
												<label for="card-holder-country">Country</label>
												<select class="custom-select selectpicker" id="card-holder-country" name="customSelectCountry">
													<option value="">Select your country ...</option>
													<option value="Afghanistan">Afghanistan</option>
													<option value="Albania">Albania</option>
													<option value="Algeria">Algeria</option>
													<option value="American Samoa">American Samoa</option>
													<option value="Andorra">Andorra</option>
													<option value="Angola">Angola</option>
													<option value="Anguilla">Anguilla</option>
													<option value="Antarctica">Antarctica</option>
													<option value="Antigua and Barbuda">Antigua and Barbuda</option>
													<option value="Argentina">Argentina</option>
													<option value="Armenia">Armenia</option>
													<option value="Aruba">Aruba</option>
													<option value="Australia">Australia</option>
													<option value="Austria">Austria</option>
													<option value="Azerbaijan">Azerbaijan</option>
													<option value="Bahamas">Bahamas</option>
													<option value="Bahrain">Bahrain</option>
													<option value="Bangladesh">Bangladesh</option>
													<option value="Barbados">Barbados</option>
													<option value="Belarus">Belarus</option>
													<option value="Belgium">Belgium</option>
													<option value="Belize">Belize</option>
													<option value="Benin">Benin</option>
													<option value="Bermuda">Bermuda</option>
													<option value="Bhutan">Bhutan</option>
													<option value="Bolivia">Bolivia</option>
													<option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
													<option value="Botswana">Botswana</option>
													<option value="Bouvet Island">Bouvet Island</option>
													<option value="Brazil">Brazil</option>
													<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
													<option value="Brunei Darussalam">Brunei Darussalam</option>
													<option value="Bulgaria">Bulgaria</option>
													<option value="Burkina Faso">Burkina Faso</option>
													<option value="Burundi">Burundi</option>
													<option value="Cambodia">Cambodia</option>
													<option value="Cameroon">Cameroon</option>
													<option value="Canada">Canada</option>
													<option value="Cape Verde">Cape Verde</option>
													<option value="Cayman Islands">Cayman Islands</option>
													<option value="Central African Republic">Central African Republic</option>
													<option value="Chad">Chad</option>
													<option value="Chile">Chile</option>
													<option value="China">China</option>
													<option value="Christmas Island">Christmas Island</option>
													<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
													<option value="Colombia">Colombia</option>
													<option value="Comoros">Comoros</option>
													<option value="Congo">Congo</option>
													<option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
													<option value="Cook Islands">Cook Islands</option>
													<option value="Costa Rica">Costa Rica</option>
													<option value="Cote d'Ivoire">Cote d'Ivoire</option>
													<option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
													<option value="Cuba">Cuba</option>
													<option value="Cyprus">Cyprus</option>
													<option value="Czech Republic">Czech Republic</option>
													<option value="Denmark">Denmark</option>
													<option value="Djibouti">Djibouti</option>
													<option value="Dominica">Dominica</option>
													<option value="Dominican Republic">Dominican Republic</option>
													<option value="East Timor">East Timor</option>
													<option value="Ecuador">Ecuador</option>
													<option value="Egypt">Egypt</option>
													<option value="El Salvador">El Salvador</option>
													<option value="Equatorial Guinea">Equatorial Guinea</option>
													<option value="Eritrea">Eritrea</option>
													<option value="Estonia">Estonia</option>
													<option value="Ethiopia">Ethiopia</option>
													<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
													<option value="Faroe Islands">Faroe Islands</option>
													<option value="Fiji">Fiji</option>
													<option value="Finland">Finland</option>
													<option value="France">France</option>
													<option value="France Metropolitan">France Metropolitan</option>
													<option value="French Guiana">French Guiana</option>
													<option value="French Polynesia">French Polynesia</option>
													<option value="French Southern Territories">French Southern Territories</option>
													<option value="Gabon">Gabon</option>
													<option value="Gambia">Gambia</option>
													<option value="Georgia">Georgia</option>
													<option value="Germany">Germany</option>
													<option value="Ghana">Ghana</option>
													<option value="Gibraltar">Gibraltar</option>
													<option value="Greece">Greece</option>
													<option value="Greenland">Greenland</option>
													<option value="Grenada">Grenada</option>
													<option value="Guadeloupe">Guadeloupe</option>
													<option value="Guam">Guam</option>
													<option value="Guatemala">Guatemala</option>
													<option value="Guinea">Guinea</option>
													<option value="Guinea-Bissau">Guinea-Bissau</option>
													<option value="Guyana">Guyana</option>
													<option value="Haiti">Haiti</option>
													<option value="Heard and Mc Donald Islands">Heard and Mc Donald Islands</option>
													<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
													<option value="Honduras">Honduras</option>
													<option value="Hong Kong">Hong Kong</option>
													<option value="Hungary">Hungary</option>
													<option value="Iceland">Iceland</option>
													<option value="India">India</option>
													<option value="Indonesia">Indonesia</option>
													<option value="Iran (Islamic Republic of)">Iran (Islamic Republic of)</option>
													<option value="Iraq">Iraq</option>
													<option value="Ireland">Ireland</option>
													<option value="Israel">Israel</option>
													<option value="Italy">Italy</option>
													<option value="Jamaica">Jamaica</option>
													<option value="Japan">Japan</option>
													<option value="Jordan">Jordan</option>
													<option value="Kazakhstan">Kazakhstan</option>
													<option value="Kenya">Kenya</option>
													<option value="Kiribati">Kiribati</option>
													<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
													<option value="Korea, Republic of">Korea, Republic of</option>
													<option value="Kuwait">Kuwait</option>
													<option value="Kyrgyzstan">Kyrgyzstan</option>
													<option value="Lao, People's Democratic Republic">Lao, People's Democratic Republic</option>
													<option value="Latvia">Latvia</option>
													<option value="Lebanon">Lebanon</option>
													<option value="Lesotho">Lesotho</option>
													<option value="Liberia">Liberia</option>
													<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
													<option value="Liechtenstein">Liechtenstein</option>
													<option value="Lithuania">Lithuania</option>
													<option value="Luxembourg">Luxembourg</option>
													<option value="Macau">Macau</option>
													<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
													<option value="Madagascar">Madagascar</option>
													<option value="Malawi">Malawi</option>
													<option value="Malaysia">Malaysia</option>
													<option value="Maldives">Maldives</option>
													<option value="Mali">Mali</option>
													<option value="Malta">Malta</option>
													<option value="Marshall Islands">Marshall Islands</option>
													<option value="Martinique">Martinique</option>
													<option value="Mauritania">Mauritania</option>
													<option value="Mauritius">Mauritius</option>
													<option value="Mayotte">Mayotte</option>
													<option value="Mexico">Mexico</option>
													<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
													<option value="Moldova, Republic of">Moldova, Republic of</option>
													<option value="Monaco">Monaco</option>
													<option value="Mongolia">Mongolia</option>
													<option value="Montserrat">Montserrat</option>
													<option value="Morocco">Morocco</option>
													<option value="Mozambique">Mozambique</option>
													<option value="Myanmar">Myanmar</option>
													<option value="Namibia">Namibia</option>
													<option value="Nauru">Nauru</option>
													<option value="Nepal">Nepal</option>
													<option value="Netherlands">Netherlands</option>
													<option value="Netherlands Antilles">Netherlands Antilles</option>
													<option value="New Caledonia">New Caledonia</option>
													<option value="New Zealand">New Zealand</option>
													<option value="Nicaragua">Nicaragua</option>
													<option value="Niger">Niger</option>
													<option value="Nigeria">Nigeria</option>
													<option value="Niue">Niue</option>
													<option value="Norfolk Island">Norfolk Island</option>
													<option value="Northern Mariana Islands">Northern Mariana Islands</option>
													<option value="Norway">Norway</option>
													<option value="Oman">Oman</option>
													<option value="Pakistan">Pakistan</option>
													<option value="Palau">Palau</option>
													<option value="Panama">Panama</option>
													<option value="Papua New Guinea">Papua New Guinea</option>
													<option value="Paraguay">Paraguay</option>
													<option value="Peru">Peru</option>
													<option value="Philippines">Philippines</option>
													<option value="Pitcairn">Pitcairn</option>
													<option value="Poland">Poland</option>
													<option value="Portugal">Portugal</option>
													<option value="Puerto Rico">Puerto Rico</option>
													<option value="Qatar">Qatar</option>
													<option value="Reunion">Reunion</option>
													<option value="Romania">Romania</option>
													<option value="Russian Federation">Russian Federation</option>
													<option value="Rwanda">Rwanda</option>
													<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
													<option value="Saint Lucia">Saint Lucia</option>
													<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
													<option value="Samoa">Samoa</option>
													<option value="San Marino">San Marino</option>
													<option value="Sao Tome and Principe">Sao Tome and Principe</option>
													<option value="Saudi Arabia">Saudi Arabia</option>
													<option value="Senegal">Senegal</option>
													<option value="Seychelles">Seychelles</option>
													<option value="Sierra Leone">Sierra Leone</option>
													<option value="Singapore">Singapore</option>
													<option value="Slovakia (Slovak Republic)">Slovakia (Slovak Republic)</option>
													<option value="Slovenia">Slovenia</option>
													<option value="Solomon Islands">Solomon Islands</option>
													<option value="Somalia">Somalia</option>
													<option value="South Africa">South Africa</option>
													<option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
													<option value="Spain">Spain</option>
													<option value="Sri Lanka">Sri Lanka</option>
													<option value="St. Helena">St. Helena</option>
													<option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
													<option value="Sudan">Sudan</option>
													<option value="Suriname">Suriname</option>
													<option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
													<option value="Swaziland">Swaziland</option>
													<option value="Sweden">Sweden</option>
													<option value="Switzerland">Switzerland</option>
													<option value="Syrian Arab Republic">Syrian Arab Republic</option>
													<option value="Taiwan, Province of China">Taiwan, Province of China</option>
													<option value="Tajikistan">Tajikistan</option>
													<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
													<option value="Thailand">Thailand</option>
													<option value="Togo">Togo</option>
													<option value="Tokelau">Tokelau</option>
													<option value="Tonga">Tonga</option>
													<option value="Trinidad and Tobago">Trinidad and Tobago</option>
													<option value="Tunisia">Tunisia</option>
													<option value="Turkey">Turkey</option>
													<option value="Turkmenistan">Turkmenistan</option>
													<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
													<option value="Tuvalu">Tuvalu</option>
													<option value="Uganda">Uganda</option>
													<option value="Ukraine">Ukraine</option>
													<option value="United Arab Emirates">United Arab Emirates</option>
													<option value="United Kingdom">United Kingdom</option>
													<option value="United States">United States</option>
													<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
													<option value="Uruguay">Uruguay</option>
													<option value="Uzbekistan">Uzbekistan</option>
													<option value="Vanuatu">Vanuatu</option>
													<option value="Venezuela">Venezuela</option>
													<option value="Vietnam">Vietnam</option>
													<option value="Virgin Islands (British)">Virgin Islands (British)</option>
													<option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
													<option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
													<option value="Western Sahara">Western Sahara</option>
													<option value="Yemen">Yemen</option>
													<option value="Yugoslavia">Yugoslavia</option>
													<option value="Zambia">Zambia</option>
													<option value="Zimbabwe">Zimbabwe</option>
												</select>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group form-group">
												<label for="card-holder-zip-code">Zip Code</label>
												<input class="form-control" id="card-holder-zip-code" placeholder="1234" name="zipCode" type="text" />
											</div>
										</div>
										<div class="col-6">
											<div class="form-group mb-0">
												<label for="card-exp-date">Exp Date</label>
												<input class="form-control" id="card-exp-date" placeholder="15/2024" name="expDate" type="text" />
											</div>
										</div>
										<div class="col-6">
											<div class="form-group mb-0">
												<label for="card-cvv">CVV<span class="fa fa-question-circle ml-2" data-toggle="tooltip" data-placement="top" title="Card verification value"></span></label>
												<input class="form-control" id="card-cvv" placeholder="123" name="cvv" maxlength="3" pattern="[0-9]{3}" type="text" />
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane text-center px-sm-3 px-md-5 <?php if(isset($_GET['payment_completed'])){ echo 'done active'; }?>" id="bootstrap-wizard-tab4">
								<div class="-wrapper">
									<div class=" mx-auto my-3" >
										<img class="d-block mx-auto mb-4" src="<?php echo base_url();?>assets/img/illustrations/rocket.png" alt="shield" width="180">
									</div>
								</div>

								<h2 class="mb-1">Payment Successful</h2>
								<p>Thank you! Your payment is complete</p>
								<a class="btn btn-primary px-5 my-3" href="<?php echo base_url();?>">Back To Site</a>
							</div>
						</div>
					</div>

				</div>
			</div>

			<?php $this->load->view('partial/footer'); ?>
		</div>
		<div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
			<div class="modal-dialog mt-6" role="document">
				<div class="modal-content border-0">
					<div class="modal-header px-5 text-white position-relative modal-shape-header">
						<div class="position-relative z-index-1">
							<div>
								<h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
								<p class="fs--1 mb-0">Please create your free Falcon account</p>
							</div>
						</div>
						<button class="close text-white position-absolute t-0 r-0 mt-1 mr-1" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body py-4 px-5">
						<form>
							<div class="form-group">
								<label for="modal-auth-name">Name</label>
								<input class="form-control" type="text" id="modal-auth-name" />
							</div>
							<div class="form-group">
								<label for="modal-auth-email">Email address</label>
								<input class="form-control" type="email" id="modal-auth-email" />
							</div>
							<div class="form-row">
								<div class="form-group col-6">
									<label for="modal-auth-password">Password</label>
									<input class="form-control" type="password" id="modal-auth-password" />
								</div>
								<div class="form-group col-6">
									<label for="modal-auth-confirm-password">Confirm Password</label>
									<input class="form-control" type="password" id="modal-auth-confirm-password" />
								</div>
							</div>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="modal-auth-register-checkbox" />
								<label class="custom-control-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Register</button>
							</div>
						</form>
						<div class="w-100 position-relative mt-5">
							<hr class="text-300" />
							<div class="position-absolute absolute-centered t-0 px-3 bg-white text-sans-serif fs--1 text-500 text-nowrap">or register with</div>
						</div>
						<div class="form-group mb-0">
							<div class="row no-gutters">
								<div class="col-sm-6 pr-sm-1"><a class="btn btn-outline-google-plus btn-sm btn-block mt-2" href="#"><span class="fab fa-google-plus-g mr-2" data-fa-transform="grow-8"></span> google</a></div>
								<div class="col-sm-6 pl-sm-1"><a class="btn btn-outline-facebook btn-sm btn-block mt-2" href="#"><span class="fab fa-facebook-square mr-2" data-fa-transform="grow-8"></span> facebook</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<?php $this->load->view('partial/footerscript')?>

<?php if(isset($_GET['passwordChanged'])){ ?>

	<script type="text/javascript">



		$(document).ready(function() {
			$(function () {
				// Toastr options
				toastr.options = {
					"debug": false,
					"newestOnTop": false,
					"positionClass": "toast-top-right",
					"closeButton": true,
					"toastClass": "animated  fadeInDown",
				};

				toastr.success('You have successfully changed your password.');


			});
		});

	</script>

<?php  }?>

<script>
	$(document).ready(function() {
		$('#wizard-email').on('blur',function(){
				var name = $(this).val();
				$.ajax({
					url: "<?php echo base_url();?>users/CheckUserMail/" + name, success: function (result) {
						console.log(result);
						if(result == 'Exist'){
							$('#error').html('<label id="wizard-email-error" class="error" for="wizard-email">Email already Exist. Please change</label>');
							$('#submit').attr('disabled','disabled');
						}else{
							$('#error').html();
							$('#submit').removeAttr('disabled');
						}

					}
				});

		});
	});

	$(document).ready(function() {
		$('#loginAs').on('click',function(){
			$("#login_modal").toggleClass('show');
		});
	});
	$('#navbarDropdownLogin').on('click',function(){
		$("#login_modal").toggleClass('show');
	});

</script>

</body>

</html>


