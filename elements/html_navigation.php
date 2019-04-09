<?php ?>

        <!-- .aside -->
        <aside class="bg-black aside-md hidden-print hidden-xs" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">                        
                        <img src="images/phoenix.png" class="dker" alt="...">
                        
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"><?php echo $_SESSION['user']->full_name; ?></strong> 
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block"><?php echo $_SESSION['user']->position; ?></span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">                      
                      <li>
                        <span class="arrow top hidden-nav-xs"></span>
                        <a href="#">Settings</a>
                      </li>
                      <li>
                        <a href="profile.html">Profile</a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge bg-danger pull-right">3</span>
                          Notifications
                        </a>
                      </li>
                      <li>
                        <a href="docs.html">Help</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="modal.lockme.html" data-toggle="ajaxModal" >Logout</a>
                      </li>
                    </ul>
                  </div>
                </div>                


                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                  <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Start</div>
                  <ul class="nav nav-main" data-ride="collapse">
                    <li <?php if(MHelper::curPageName() == 'mainscreen.php'){ echo 'class="active"'; } ?> >
                      <a href="mainscreen" class="auto">
                        <i class="i i-statistics icon">
                        </i>
                        <span class="font-bold">Overview</span>
                      </a>
                    </li>
                    <!-- product file -->
                    <li <?php if(MHelper::curPageName() == 'product_file_list.php'
                            || MHelper::curPageName() == 'product_file_add_item.php'
                            ){ echo 'class="active"'; }?> >
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        
                        <i class="i i-stack icon">
                        </i>
                        <span class="font-bold">Product File</span>
                      </a>
                      <ul class="nav dk">
                        <li <?php if(MHelper::curPageName() == 'product_file_list.php'){ echo 'class="active"'; } ?>>
                          <a href="product_file_list" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>List</span>
                          </a>
                        </li>
                        <li <?php if(MHelper::curPageName() == 'product_file_add_item.php'){ echo 'class="active"'; } ?> >
                          <a href="product_file_add_item" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Add Item</span>
                          </a>
                        </li>
                      </ul>
                    </li>                    
                    <!-- end product file -->
                    <li <?php if(MHelper::curPageName() == 'container_add.php'
                            || MHelper::curPageName() == 'container_list.php'
                            ){ echo 'class="active"'; } ?> >
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="fa fa-cubes">
                        </i>
                        <span class="font-bold">Containers</span>
                      </a>
                      <ul class="nav dk">
                        <li <?php if(MHelper::curPageName() == 'container_add.php'){ echo 'class="active"'; } ?>>
                          <a href="container_add" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Add container</span>
                          </a>
                        </li>
                        <li <?php if(MHelper::curPageName() == 'container_list.php'){ echo 'class="active"'; } ?>>
                          <a href="container_list" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Containers List</span>
                          </a>
                        </li>
                        
                      </ul>
                    </li>
                    <li <?php if(MHelper::curPageName() == 'process_receive.php'
                            || MHelper::curPageName() == 'process_dispatch_single.php'
                            ){ echo 'class="active"'; } ?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="fa fa-barcode">
                        </i>
                        <span class="font-bold">Process</span>
                      </a>
                      <ul class="nav dk">
                        <li <?php if(MHelper::curPageName() == 'process_receive.php'){ echo 'class="active"'; } ?>>
                          <a href="process_receive" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Receive</span>
                          </a>
                        </li>
                        <li <?php if(MHelper::curPageName() == 'process_dispatch_single.php'){ echo 'class="active"'; } ?>>
                          <a href="process_dispatch_single" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Dispatch single item</span>
                          </a>
                        </li>                        
                      </ul>
                    </li>
                    <!-- Stock -->
                    <li  <?php if(MHelper::curPageName() == 'stock_holding.php'){ echo 'class="active"'; } ?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="fa fa-book">
                        </i>
                        <span class="font-bold">Stock Management</span>
                      </a>
                      <ul class="nav dk">
                        <li  <?php if(MHelper::curPageName() == 'stock_holding.php'){ echo 'class="active"'; } ?>>
                          <a href="stock_holding" class="auto">                            
                            <i class="i i-dot"></i>

                            <span>Stock holding</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <!-- SYSTEM -->
                    <li  <?php if(MHelper::curPageName() == 'system_php_info.php' || MHelper::curPageName() == 'system_generate.php'
                            || MHelper::curPageName() == 'system_insert_form_generator.php'
                            || MHelper::curPageName() == 'system_generate_serial_number.php'
                            || MHelper::curPageName() == 'system_settings.php'
                            ){ echo 'class="active"'; } ?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="fa fa-cogs">
                        </i>
                        <span class="font-bold">System</span>
                      </a>
                      <ul class="nav dk">
                        <li  <?php if(MHelper::curPageName() == 'system_php_info.php'){ echo 'class="active"'; } ?>>
                          <a href="system_php_info" class="auto">                            
                            <i class="i i-dot"></i>

                            <span>PHP Information</span>
                          </a>
                        </li>
                        <li  <?php if(MHelper::curPageName() == 'system_generate.php'){ echo 'class="active"'; } ?>>
                          <a href="system_generate" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Generate</span>
                          </a>
                        </li>
                        <li <?php if(MHelper::curPageName() == 'system_insert_form_generator.php'){ echo 'class="active"'; } ?>>
                          <a href="system_insert_form_generator" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Insert form generator</span>
                          </a>
                        </li>
                        <li <?php if(MHelper::curPageName() == 'system_generate_serial_number.php'){ echo 'class="active"'; } ?>>
                          <a href="system_generate_serial_number" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Serial Number Generator</span>
                          </a>
                        </li>                        
                        <li <?php if(MHelper::curPageName() == 'system_settings.php'){ echo 'class="active"'; } ?>>
                          <a href="system_settings" class="auto">                                                        
                            <i class="i i-dot"></i>

                            <span>Serial Number Generator</span>
                          </a>
                        </li> 
                      </ul>
                    </li>
                  </ul>
                  <div class="line dk hidden-nav-xs"></div>


                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer hidden-xs no-padder text-center-nav-xs">

              <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                <i class="i i-circleleft text"></i>
                <i class="i i-circleright text-active"></i>
              </a>
            </footer>
          </section>
        </aside>
        <!-- /.aside -->