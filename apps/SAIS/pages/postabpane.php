<ul class="nav nav-tabs">


    <?php  $query = 'SELECT * FROM category WHERE COMPANY_ID = '.$_SESSION['COMPANY_ID'];
    $result = mysqli_query($db, $query);

    if ($result):
    if(mysqli_num_rows($result)>0):

    foreach($result as $cat){ ?>

    <li class="nav-item">
        <a class="nav-link" href="#" data-target="#<?php echo $cat['CNAME']?>" data-toggle="tab"><?php echo $cat['CNAME']?></a>
    </li>

    <?php };
    endif;
    endif;?>

</ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                              <!-- 1ST TAB -->



                                <?php  $query = 'SELECT * FROM category WHERE COMPANY_ID = '.$_SESSION['COMPANY_ID'];
                                $result = mysqli_query($db, $query);

                                if ($result):
                                if(mysqli_num_rows($result)>0):

                                foreach($result as $cat){  ?>

                                      <?php  $query = 'SELECT * FROM product WHERE CATEGORY_ID= "'.$cat['CATEGORY_ID'].'" GROUP BY PRODUCT_CODE ORDER by PRODUCT_CODE ASC';
                                        $result = mysqli_query($db, $query);

                                        if ($result):
                                             ?>

                                  <div class="tab-pane fade in mt-2" id="<?php echo $cat['CNAME']?>">
                                  <div class="row">
                                      <?php     while($product = mysqli_fetch_assoc($result)):
                                                //print_r($product);
                                      ?>
                                    <div class="col-sm-4 col-md-2" >
                                      <form method="post" action="pos.php?action=add&id=<?php echo $product['PRODUCT_ID']; ?>">
                                          <div class="products">
                                              <h6 class="text-info"><?php echo $product['NAME']; ?></h6>
                                              <h6>$ <?php echo $product['PRICE']; ?></h6>
                                              <input type="text" name="quantity" class="form-control" value="1" />
                                              <input type="hidden" name="name" value="<?php echo $product['NAME']; ?>" />
                                              <input type="hidden" name="price" value="<?php echo $product['PRICE']; ?>" />
                                              <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info"
                                                     value="Add" />
                                          </div>
                                      </form>
                                  </div>
                                      <?php endwhile; ?>
                                    </div>
                                </div>
                                            <?php

                                    endif;   
                                    ?>

                                <?php }
                                        endif;
                                    endif;
                                    ?>
                            </div>