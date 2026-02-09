<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>About Us | MeweMarket</title>
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

			<div class="card mb-3">
				<div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(<?php echo base_url();?>assets/img/illustrations/corner-4.png);">
				</div>
				<!--/.bg-holder-->
				<div class="card-body">
					<div class="row">
						<div class="col-lg-8">
							<h3 class="mb-0">About Mewemarket</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-body">
					<p class="fs--1 mb-0">
						Mewemarket is committed to ensuring that your privacy is protected. Should we ask you to provide
						certain information by which you can be identified when using this website, then you can be
						assured that it will only be used in accordance with this privacy statement
					</p>
					<hr class="my-3">
					<p class="fs--1 mb-0">
						We will not sell, distribute or lease your personal information to third parties unless we have
						your permission or are required by law to do so. We may use your personal information to send
						you promotional information about third parties which we think you may find interesting if you
						tell us that you wish this to happen.
					</p>
					<hr class="my-3">
					<p class="fs--1 mb-0">
						If you believe that any information we are holding on you is incorrect or incomplete, please
						write to or email us as soon as possible. We will promptly correct any information found to be
						incorrect.
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-xxl-4 ">
				<div class="card">
					<div class="card-body bg-light pb-0">
						<div class="bg-holder rounded-soft overlay overlay-0" style="background-image:url(<?php echo base_url();?>assets/img/generic/office_table.jpg);">

						</div> <!--/.bg-holder-->
						<div class="position-relative  w-100 text-center py-lg-5 ">
							<h3 class="font-weight-light text-white w-100 overflow-hidden">A smarter way to tell about <span class="typed-text font-weight-bold ml-1" data-typed-text='["new features.","product updates.","a new idea.","an announcment."]'></span></h3>
							<p class="w-100 font-weight-light d-inline-block text-white text-300">is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						</div>
					</div>
				</div>
			</div>
			</div>

			<div class="row no-gutters">
				<div class="space  mb-0 w-100"></div>
				<div class="w-100 ">

					<div class="row no-gutters">
						<div class="col-lg-6 mt-5">
							<h3>
								Mewemarket is a world-leading online community for creative assets, tools and talent
							</h3>

							<p>Millions of people around the world visit Mewemarket to buy and sell creative assets, use smart
								design templates, learn creative skills or even hire freelancers. With an industry-leading
								marketplace paired with an unlimited subscription service, Mewemarket helps creatives like you
								get projects done faster.</p>

							<p>Millions of people around the world visit Mewemarket to buy and sell creative assets, use smart
								design templates, learn creative skills or even hire freelancers. With an industry-leading
								marketplace paired with an unlimited subscription service, Mewemarket helps creatives like you
								get projects done faster.</p>
						</div>
						<div class="col-lg-6 mt-5">
							<img width="100%" src="<?php echo base_url();?>assets/img/illustrations/2.png" />
						</div>
					</div>

					<div class="row no-gutters mb-3">
						<div class="col-lg-12 col-xxl-4 pr-lg-2 mb-3 mb-lg-0">
							<div class="card h-100">

								<div class="bg-light card-body px-0 py-0">
									<div class="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>

			<?php $this->load->view('partial/footer'); ?>
		</div>
	</div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
<?php $this->load->view('partial/footerscript')?>
</body>
</html>
