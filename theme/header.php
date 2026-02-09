 <nav class="navbar navbar-standard navbar-expand-lg fixed-top pt-3 navbar-dark navbar-theme">
        <div class="container"><a class="navbar-brand" href="index.php"><span class="text-white">Falcon</span></a>
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarStandard">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link text-300 text-white fs--2" href="index.php">Home</a></li>
              <li class="nav-item"><a class="nav-link text-300 text-white fs--2" href="#">About </a></li>
              <li class="nav-item"><a class="nav-link text-300 text-white fs--2" href="#">pricing</a></li>
              <li class="nav-item"><a class="nav-link text-300 text-white fs--2" href="categories.php">Categories</a></li>
              <li class="nav-item"><a class="nav-link text-300 text-white fs--2" href="#">Support</a></li>
              
            </ul>
            <ul class="navbar-nav ml-auto">
             <li class="nav-item">
                <form class="form-inline search-box">
                  <input class="form-control rounded-pill search-input" type="search" placeholder="Search..." aria-label="Search" /><span class="position-absolute fas fa-search text-400 search-box-icon"></span>
                </form>
              </li>
              
              <li class="nav-item dropdown"><a class="nav-link dropdown-toggle text-300 text-white fs--2" id="navbarDropdownLogin" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-card" aria-labelledby="navbarDropdownLogin">
                  <div class="card shadow-none navbar-card-login">
                    <div class="card-body fs--1 p-4 font-weight-normal">
                      <div class="row text-left justify-content-between align-items-center mb-2">
                        <div class="col-auto">
                          <h5 class="mb-0">Log in</h5>
                        </div>
                        <div class="col-auto">
                          <p class="fs--1 text-600 mb-0">or <a href="javascript:;">Create an account</a></p>
                        </div>
                      </div>
                      <form>
                        <div class="form-group">
                          <input class="form-control" type="email" placeholder="Email address" />
                        </div>
                        <div class="form-group">
                          <input class="form-control" type="password" placeholder="Password" />
                        </div>
                        <div class="row justify-content-between align-items-center">
                          <div class="col-auto">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" type="checkbox" id="modal-checkbox" />
                              <label class="custom-control-label" for="modal-checkbox">Remember me</label>
                            </div>
                          </div>
                          <div class="col-auto"><a class="fs--1" href="javascript:;">Forgot Password?</a></div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Log in</button>
                        </div>
                      </form>
                      <div class="w-100 position-relative mt-4">
                        <hr class="text-300" />
                        <div class="position-absolute absolute-centered t-0 px-3 bg-white text-sans-serif fs--1 text-500 text-nowrap">or log in with</div>
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
              </li>
            <!--   <li class="nav-item"><a class="nav-link" href="#!" data-toggle="modal" data-target="#exampleModal">Sign up now</a></li> -->
            </ul>
          </div>
        </div>
      </nav>
       <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body p-4">
              <div class="row text-left justify-content-between align-items-center mb-2">
                <div class="col-auto">
                  <h5 id="modalLabel">Register</h5>
                </div>
                <div class="col-auto">
                  <p class="fs--1 text-600 mb-0">Have an account? <a href="javascript:;">Login</a></p>
                </div>
              </div>
              <form>
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Name" />
                </div>
                <div class="form-group">
                  <input class="form-control" type="email" placeholder="Email address" />
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <input class="form-control" type="password" placeholder="Password" />
                  </div>
                  <div class="form-group col-6">
                    <input class="form-control" type="password" placeholder="Confirm Password" />
                  </div>
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="modal-register-checkbox" />
                  <label class="custom-control-label" for="modal-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Register</button>
                </div>
              </form>
              <div class="w-100 position-relative mt-4">
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