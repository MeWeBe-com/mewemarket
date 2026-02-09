<table style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td style="padding-right:10px;padding-left:10px;" id="bodyCell" valign="top" align="center">

			<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="600">
				<tr>
					<td align="center" valign="top">

						<table style="max-width:600px;" class="wrapperWebview" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							<tr>
								<td valign="top" align="center">
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<tr>
											<td style="padding-top: 20px; padding-right: 0px;" class="webview" valign="middle" align="right">
												<!-- Email View in Browser // -->
												<a class="text hideOnMobile" href="#" target="_blank" style="color:#777777; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:right; text-decoration:underline; padding:0; margin:0"></a>
											</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
						<!-- Email Wrapper Header Open //-->
						<table style="max-width:600px;" class="wrapperWebview" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							<tr>
								<td valign="top" align="center">
									<!-- Content Table Open // -->
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<tr>
											<td style="padding-top: 40px; padding-bottom: 40px;" class="emailLogo" valign="middle" align="center">
												<!-- Logo and Link // -->
												<a href="#" target="_blank" style="text-decoration:none;" class="">
													<img src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" style="width: 100%; max-width: 250px; height: auto; display: block;" class="" width="150" border="0">
												</a>
											</td>
										</tr>
										</tbody>
									</table>
									<!-- Content Table Close // -->
								</td>
							</tr>
							</tbody>
						</table>
						<table style="max-width:600px;" class="wrapperBody" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							<tr>
								<td valign="top" align="center">
									<table style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" class="tableCard" width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<tr>
											<td style="background-color: rgb(4, 67, 162); font-size: 1px; line-height: 3px;" class="topBorder" height="3">&nbsp;</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;" class="imgHero" valign="top" align="left">
												<a href="#" target="_blank" style="text-decoration:none;" class="">
													<img src="" alt="" style="width: 100%; max-width: 598px; height: auto; display: block;" class="" width="598" border="0">
												</a>
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" class="mainTitle" valign="top" align="left">
												<h2 class="text" style="color: rgb(4, 67, 162); font-family: &quot;Poppins&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;"><?php echo ($heading)?>
												</h2>
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px; padding-left: 20px; padding-right: 20px;" class="subTitle" valign="top" align="left">
												<h4 class="text" style="color:rgb(102,102,102); font-family:'Poppins', Helvetica, Arial, sans-serif; font-size:14px; font-weight:500; font-style:normal; letter-spacing:normal; line-height:24px; text-transform:none; text-align:left; padding:0; margin:0"><?php echo ($secondHeading)?></h4>
											</td>
										</tr>

										<?php if(!empty($thirdHeading)){?>
										<tr>
											<td style="padding-bottom: 20px; padding-left: 20px; padding-right: 20px;" class="subTitle" valign="top" align="left">
												<h4 class="text" style="color:rgb(102,102,102); font-family:'Poppins', Helvetica, Arial, sans-serif; font-size:14px; font-weight:500; font-style:normal; letter-spacing:normal; line-height:24px; text-transform:none; text-align:left; padding:0; margin:0"><?php echo ($thirdHeading)?></h4>
											</td>
										</tr>
										<?php }?>
										<tr>
											<td style="padding-left:20px;padding-right:20px;" class="containtTable ui-sortable" valign="top" align="left">
												<?php if(!empty($TextLineOne)){?>
													<table class="tableDescription" style="" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody>
														<tr>
															<td style="padding-bottom: 20px;" class="description" valign="top" align="left">
																<!-- Description Text// -->
																<p class="text" style="color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;"><?php echo $TextLineOne ;?>
																</p>
															</td>
														</tr>
														</tbody>
													</table>
												<?php }?>
												<?php if(!empty($TextLineTwo)){?>
													<table class="tableDescription" style="" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody>
														<tr>
															<td style="padding-bottom: 20px;" class="description" valign="top" align="left">
																<!-- Description Text// -->
																<p class="text" style="color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;"><?php echo $TextLineTwo ;?></p>
															</td>
														</tr>
														</tbody>
													</table>
												<?php }?>
												<?php if(!empty($TextLineThree)){?>
													<table class="tableDescription" style="" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody>
														<tr>
															<td style="padding-bottom: 20px;" class="description" valign="top" align="left">
																<!-- Description Text// -->
																<p class="text" style="color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;"><?php echo $TextLineThree ;?></p>
															</td>
														</tr>
														</tbody>
													</table>
												<?php }?>
												<?php if(!empty($TextLineFourth)){?>
													<table class="tableDescription" style="" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody>
														<tr>
															<td style="padding-bottom: 20px;" class="description" valign="top" align="left">
																<!-- Description Text// -->
																<p class="text" style="color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;" data-font="active"><?php echo $TextLineFourth ;?></p>
															</td>
														</tr>
														</tbody>
													</table>
												<?php }?>

												<?php if(!empty($TextLineFifth)){ ?>
													<table class="tableDescription" style="" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody>
														<tr>
															<td style="padding-bottom: 20px;" class="description" valign="top" align="left">
																<p class="text" style="color: rgb(102, 102, 102); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; font-style: normal; letter-spacing: normal; line-height: 22px; text-transform: none; text-align: left; padding: 0px; margin: 0px;" data-font="active"><?php echo $TextLineFifth ;?></p>
															</td>
														</tr>
														</tbody>
													</table>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td style="font-size:1px;line-height:1px;" height="20">&nbsp;</td>
										</tr>
										<tr>
											<td style="padding-bottom: 40px;" class="emailRegards" valign="middle" align="center">
												<a href="#" target="_blank" style="text-decoration:none;" class="">
													<img src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" style="width:100%;
                                                max-width:150px; height:auto; display:block;" class="" width="150" border="0">
												</a>
											</td>
										</tr>
										</tbody>
									</table>
									<table class="space" width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<tr>
											<td style="font-size:1px;line-height:1px;" height="30">&nbsp;</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
						<table style="max-width:600px;" class="wrapperFooter" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							<tr>
								<td valign="top" align="center">
									<table class="footer" width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<?php /*?><tr>
                                          <td style="padding: 10px 10px 5px;" class="brandInfo" valign="top" align="center">
                                             <p class="text" style="color:#777777; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp;Visiopath Inc.
                                             </p>
                                          </td>
                                       </tr><?php */?>
										<tr>
											<td style="padding: 0px 10px 20px;" class="footerLinks" valign="top" align="center">
												<p class="text" style="color:#777777; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">
													<a href="<?php echo base_url();?>" style="color:#777777;text-decoration:underline;" target="_blank">MeweMarket.com</a>  |
													<a href="<?php echo base_url();?>" style="color:#777777;text-decoration:underline;" target="_blank">MeweMarket.com</a>
												</p>
											</td>
										</tr>
										<tr>
											<td style="padding: 0px 10px 10px;" class="footerEmailInfo" valign="top" align="center">
												<p class="text" style="color:#777777; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">
													if you have any questions contact us on <a href="mailto:yaze.live@gmail.com"  style="color:#777777;text-decoration:underline;" target="_blank">info@MeweMarket.com</a><br>
												</p>
											</td>
										</tr>
										<tr>
											<td style="font-size:1px;line-height:1px;" height="30">&nbsp;</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<!-- Space -->
							<tr>
								<td style="font-size:1px;line-height:1px;" height="30">&nbsp;</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</tbody>
</table>

