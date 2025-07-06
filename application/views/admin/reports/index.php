<!-- PAGE HEADER-->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-6">
                    <div class="clearfix">
                        <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $title; ?></div>
                </div>

                <div class="col-md-6">

                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
            </div>
            <div class="box-body">

                <div class="table-responsive">
                    <h4><strong>Category Wise Report</strong></h4>
                    <form action="<?php echo site_url(ADMIN_DIR . 'reports/custom_report'); ?>" method="get" target="_blank" class="form-inline" role="form">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="report">Report</label>
                            <br />
                            <button type="submit" class="btn btn-primary">View Report</button>
                        </div>

                    </form>

                    <hr />

                    <h4><strong>Lab Test Report</strong></h4>
                    <form action="<?php echo site_url(ADMIN_DIR . 'reports/categories_custom_report'); ?>" method="get" target="_blank" class="form-inline" role="form">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="report">Report</label>
                            <br />
                            <button type="submit" class="btn btn-danger">View Report</button>
                        </div>

                    </form>

                    <hr />




                </div>


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>