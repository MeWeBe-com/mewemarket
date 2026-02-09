<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Home | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php')?>

</head>
<body class="perfect-scrollbar-on">

    <!-- Main Container -->
    <!-- Main Container -->
    <div class="wrapper">

        <!-- Main SideBar Menu -->
         <?php $this->load->view('partial/sidebar.php') ;?>
        <!-- Body Content Start-->
        <div class="main-panel">
                   <div class="col-md-12 p-0">
            <!-- Top Menu Bar Start -->
            <?php $this->load->view('partial/navbar.php') ;?>
            
            </div>
            <!-- Top Menu Bar ENd -->
            
            <div class="">
                <div class="col-lg-12 p-0">
                    <div class="space10"></div>
                    <div class="col-lg-12 tx_bold6 text-capti">
                      <a href=""  class="text-red">Projects</a>
                    </div>

                    <div class="space10"></div>
                        <div class="col-lg-12 ">
                            
                            <div class="card">
                                 <div class="col-lg-9 col-md-8">
                                
                                <div class="card-content  table-full-width">
                                    <div class="card-header row pt-0">
                                        <div class="col-md-6  col-sm-6 col-xs-12">
                                            <!-- <span>29th June 2020</span> -->
                                            <span>Location:<span> UK</span></span>
                                        </div> 
                                        
                                    </div>

                                    
                                  <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                        <span>Status: <span class="text-success"> Online</span></span>
                                    </div>

                                   
                                    <!-- <div class="col-md-12 col-sm-6 col-xs-12 pt-3 pb-3">
                                        <h6>Outline of the project here </h6>
 <?php echo $project->description; ?>
                                    </div> -->
                                    
                                </div>
                                   
                            </div>
                             <div class="col-lg-3 col-md-4">
                            
                           <div class=" ">
                                
                                <div class="card-content pt-0 pb-0">
                                    <ul class="list-unstyled team-members">
                                        <li>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <div class="avatar">
                                                        <img src="<?php echo base_url('assets/images/faces/face-2.jpg')?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 mt-3 ml-3">
                                                    DJ Khaled
                                                    <br>
                                                     <span class="text-success"> <small>Online</small></span>
                                                </div>
                                             </div>
                                        </li>
                                      
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                          
                    </div>
                </div>

                <div class="">
                    <div class="col-lg-12 p-0">
                      


                       



<div class="col-md-12">
                            <div class="card ">
                                <div class="card-header row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h4 class="card-title tx_bold6">Projects Assigend</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p class="mb0 text-right"><p class="mb0 text-right"><!-- <a href="<?php echo base_url('sub_projects/index/'.$project->id)?>" > View Sub Projects </a>  --> </p> </p>
                                    </div>
                                </div>
                                <div class="card-content">
                                     <table  class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" id="datatables">
                                         <thead>
                                            <tr>
                                                 <th width="30%"> </th>
                                                <th class="pl-0 text-center" width="30%">Time logged this week</th>
                                              <!--   <th>Description</th> -->
                                                <th width="30%" class="pl-0 text-center">Time logged total   </th>
                                                <th width="30%" class="pl-0 text-center">Deadline</th>
 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr>
                                                <th>
                                                 
                                                        Project 1 
                                                    
                                   
                                                </th>
                                                <td class="pl-0 text-center" width="30%">8</td>
                                               <!--  <td><?php echo $sub_project->description?></td> -->
                                                <td width="30%" class="pl-0 text-center">22</td>
                                                <td width="30%" class="pl-0 text-center">July 27th</td>

                                            </tr>
                                         </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
 
                        

                         <div class="col-md-12">
                            <div class="card pb-4">
                               <div class="card-header row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4 class="card-title tx_bold6">Work gallery</h4>
                                    <p> <div class="mt-4"></div>
                                        <button class="btn-danger btn-sm btn btn-fill">Screenshots</button>
                                        <button class="btn-sm btn btn-fill">Photos</button>
                                    </p>
                                </div>
                                    <div class="col-md-6  col-sm-6 col-xs-6">
                                    <!-- <p class="mb0 text-right"><a href="javascript:;">View all</a></p> -->

                                    </div>
                                </div>
                                 <div class="row mt-4 gallery_home_min gallery_three">
                                 
                                <div class="col-lg-3">
                                    <div class="card"> 
                                        <div class="card-content gallery_home text-center">
                                            <img src="<?php echo base_url('assets/images/faces/face-2.jpg')?>" alt="">
                                        </div>
                                        <div class="mt-3 col-lg-12 mt-4 p-0">
                                        <span class=" d-block mb-2">06:11 21/08/2020</span>
                                        <span class=" d-block"><a class="text-red text-capti tx_bold6" href="#">Project 1</a></span>
                                        </div>
                                        
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="card"> 
                                        <div class="card-content gallery_home text-center">
                                            <img src="<?php echo base_url('assets/images/faces/face-2.jpg')?>" alt="">
                                        </div>
                                    <div class="mt-3 col-lg-12 mt-4 p-0">
                                        <span class=" d-block mb-2">06:11 21/08/2020</span>
                                        <span class=" d-block"><a class="text-red text-capti tx_bold6" href="#">Project 2</a></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="card"> 
                                        <div class="card-content gallery_home text-center">
                                            <img src="<?php echo base_url('assets/images/faces/face-2.jpg')?>" alt="">
                                        </div>
                                        <div class="mt-3 col-lg-12 mt-4 p-0">
                                        <span class=" d-block mb-2">06:11 21/08/2020</span>
                                        <span class=" d-block"><a class="text-red text-capti tx_bold6" href="#">Project 3</a></span>
                                        </div>

                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="card"> 
                                        <div class="card-content gallery_home text-center">
                                            <img src="<?php echo base_url('assets/images/faces/face-2.jpg')?>" alt="">
                                        </div>
                                        <div class="mt-3 col-lg-12 mt-4 p-0">
                                        <span class=" d-block mb-2">06:11 21/08/2020</span>
                                        <span class=" d-block"><a class="text-red text-capti tx_bold6" href="#">Project 4</a></span>
                                        </div>

                                    </div>
                                </div>
                       </div>
                            </div>

                        </div>      

                      <!--  <div class="col-md-12">
                            <div class="card">
                               <div class="card-header row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <h4 class="card-title tx_bold6">Photos</h4>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 mb-3">
                                    <div class="col-md-2 mt-4 mb-4 col-sm-6 col-xs-12 no-padding-gutters">
                                        <a href="#" class="mb0 btn btn-outline-dark btn-fill  btn-block ">Upload</a>
                                    </div>
                                </div>

                            </div>

                        </div> -->
                    </div>
             </div>


            <!-- Footer Bar Start -->
           <?php $this->load->view('partial/footer.php') ;?>
            <!-- Footer Bar End -->
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="col-lg-12 text-center">
                <h5> 
                    10:40 Monday June 29th
                </h5>

                <h4 class="mt-3">
                    Screenshot will be taken in
                </h4>

                <span class="Timer">
                    5
                </span>
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <?php  $this->load->view('partial/footerscript.php') ;?>

</body>
</html>
