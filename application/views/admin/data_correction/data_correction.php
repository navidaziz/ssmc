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
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "tests/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "tests/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-file"></i>Reception Receipt</h4>
            </div>
            <div class="box-body" style="font-size: 12px !important;">

                <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) {

                    $type = "";
                    if ($this->session->flashdata("msg_success")) {
                        $type = "success";
                        $msg = $this->session->flashdata("msg_success");
                    } elseif ($this->session->flashdata("msg_error")) {
                        $type = "danger";
                        $msg = $this->session->flashdata("msg_error");
                    } else {
                        $type = "info";
                        $msg = $this->session->flashdata("msg");
                    }
                    echo '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
                ?>



                <?php }  ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Receipts</th>
                            <th>Rs:</th>
                            <th>Cancellation Reasons</th>
                            <th>Reasons Detail</th>
                            <th>Receipt Token</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($all_tests as $test) {
                        $color = '';
                        if ($test->is_deleted == 1) {
                            $color = "#ffe8e7";
                        }


                    ?>
                        <tr style="background-color: <?php echo $color; ?>;">
                            <td><?php echo $test->invoice_id; ?> </td>
                            <td><?php
                                if ($test->category_id != 5) {
                                    echo $test_categories[$test->category_id] . "-" . $test->today_count;
                                } else {
                                    $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $test->opd_doctor . "'";
                                    $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                                    echo $opd_doctor . "-" . $test->today_count;
                                } ?>
                            </td>
                            <td><?php echo $test->patient_name; ?></td>
                            <td><?php echo $test->patient_mobile_no; ?></td>
                            <td>
                                <!-- <a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "lab/print_patient_test_receipts/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Receipt</a> -->

                            </td>
                            <!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> -->
                            <td><?php echo $test->total_price; ?></td>
                            <td>
                                <?php if ($test->is_deleted == 0) { ?>
                                    <form method="post" action="<?php echo site_url(ADMIN_DIR . "data_correction/cancel_receipt"); ?>">
                                        <input type="hidden" name="invoice_id" value="<?php echo $test->invoice_id; ?>" />
                                        <select required="required" name="cancel_reason">
                                            <option value="">Cancellation Reasons</option>
                                            <option value="patient_cancelled">Patient Cancelled</option>
                                            <option value="fault_entry">Fault Entery</option>
                                            <option value="opd_doctor_return">OPD Doctor Return</option>
                                            <option value="advance_booking_cancellation">Advance Booking Cancellation</option>
                                        </select>
                                    <?php } else { ?>
                                        <?php echo $test->cancel_reason; ?>
                                    <?php } ?>
                            </td>

                            <td>
                                <?php if ($test->is_deleted == 0) { ?>
                                    <input required="required" type="text" name="cancel_reason_detail" style="width: 200px;" />
                                <?php } else { ?>
                                    <?php echo $test->cancel_reason_detail; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($test->is_deleted == 0) { ?>
                                    <input required="required" type="text" name="receipt_token" style="width: 100px;" />
                                <?php } else { ?>
                                    <?php echo $test->test_token_id; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($test->is_deleted == 0) { ?>
                                    <input type="submit" name="correct_date" value="Cancel Receipt" />
                                    </form>
                                <?php }  ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function add_test_unit(test_id) {
        test_unit = $('#test_unit_' + test_id).val();
        $.ajax({
            type: "POST",
            url: '<?php echo site_url(ADMIN_DIR . "test_groups/add_test_unit"); ?>',
            data: {
                test_unit: test_unit,
                test_id,
                test_id
            }
        }).done(function(data) {
            //$('#edit_student_info_body').html(data);
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#testTable').DataTable({
            "pageLength": 500
        });
    });
</script>