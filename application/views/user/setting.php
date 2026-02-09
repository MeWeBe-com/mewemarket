<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>User Dashboard | Mewemarket</title>

	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->


	<!-- ===============================================-->
	<!--    Stylesheets-->
	<!-- ===============================================-->

	<?php $this->load->view('partial/head') ?>

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
			<div class="row no-gutters">
				<div class="col-lg-12 pr-lg-2">
					<div class="card mb-3">
						<div class="card-header">
							<h5 class="mb-0">Profile Settings</h5>
						</div>
						<div class="card-body bg-light">
							<form method="post" class="form-validation" data-options='{"rules":{"confirmPassword":{"equalTo":"#wizard-password"}},"messages":{"confirmPassword":{"equalTo":"Passwords didn&#39;t match"},"terms":{"required":"You must accept terms and privacy policy"}}}' action="<?php echo base_url('users/AddNewUser')?>">
								<input type="hidden" name="user_id" value="<?php echo $user_details[0]->user_id; ?>" >
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="first-name">First Name</label>
											<input class="form-control" id="first-name" type="text" name="first_name" value="<?php echo $user_details[0]->first_name; ?>" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="last-name">Last Name</label>
											<input class="form-control" id="last-name" type="text" name="last_name" value="<?php echo $user_details[0]->last_name; ?>" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="email1">Email</label>
											<input class="form-control" readonly id="email1" type="text" name="user_email" value="<?php echo $user_details[0]->user_email; ?>" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="phone">Phone</label>
											<input class="form-control" maxlength="15" id="phone" type="text" name="contact_number" value="<?php echo $user_details[0]->contact_number; ?>">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="street">Street</label>
											<input class="form-control" id="street" type="text" name="street" value="<?php echo $user_details[0]->street; ?>" >
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="state">State</label>
											<input class="form-control" id="state" type="text" name="state" value="<?php echo $user_details[0]->state; ?>">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="zip_code">Zip Code</label>
											<input class="form-control" id="zip_code" type="text" name="zip_code" value="<?php echo $user_details[0]->zip_code; ?>" >
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="country">Country</label>
											<select class="custom-select selectpicker" required id="wizard-country" name="country_id">
												<option value="">Select your country ...</option>
												<?php foreach($countries as $country){ ?>
													<option <?php if($user_details[0]->country_id == $country->country_id){ echo "selected"; }?> value="<?php echo $country->country_id;?>"><?php echo $country->country_name;?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="col-lg-12">
										<hr class="border-dashed border-bottom-0">
									</div>

									<div class="col-lg-12">

									<div class="form-group">
										<label for="wizard-username">Username *</label>
										<input class="form-control" readonly type="text" name="user_name" value="<?php echo $user_details[0]->user_name;?>" />
									</div>
									<div class="form-row">
										<div class="col-6">
											<div class="form-gorup">
												<label for="wizard-password">Password </label>
												<input class="form-control" type="password" name="user_password" placeholder="Password"  id="wizard-password" />
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="wizard-confirm-password">Confirm Password </label>
												<input class="form-control" type="password" name="confirmPassword" placeholder="Confirm Password" id="wizard-confirm-password" />
											</div>
										</div>
									</div>
									</div>

									<div class="col-lg-12">
										<hr class="border-dashed border-bottom-0">
									</div>

									<div class="col-12 d-flex justify-content-end">
										<button class="btn btn-primary" type="submit">Update </button>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>

			</div>
			<?php $this->load->view('partial/footer')?>
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


</body>

</html>
