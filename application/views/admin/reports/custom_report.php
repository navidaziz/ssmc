<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customize Report</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>CCML</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css"
        media="screen,print" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css"
        media="screen,print" id="skin-switcher" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css"
        media="screen,print" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css"
        media="screen,print" />


    <style>
        body {
            background: rgb(204, 204, 204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            /* height: 29.7cm;  */
            height: auto;
        }

        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }

        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
                color: black;
            }

        }


        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            padding: 8px;
            line-height: 1;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 15px !important;
        }
    </style>
</head>

<body>
    <page size='A4'>
        <div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">

            <h3 style="text-align: center;">
                <strong>
                    <?php echo $system_global_settings[0]->system_title  ?>
                </strong>
            </h3>
            <h4 style="text-align: center;">
                Customize Report
                <strong>
                    ( Date:
                    <?php echo date("d F, Y ", strtotime($start_date)) ?> to
                    <?php echo date("d F, Y ", strtotime($end_date)) ?> )
                </strong>
            </h4>

            <h5>Category Wise Report</h5>


            <table class="table table-bordered" id="today_categories_wise_report">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>Categories</th>
                        <th>Total</th>
                        <th>Cancelled</th>
                        <th>Confirmed</th>
                        <th>Discounts</th>
                        <th>Total Rs</th>
                    </tr>

                </thead>
                <tbody>

                    <?php
                    $count = 1;
                    foreach ($today_cat_wise_progress_reports as $report) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $report->test_category; ?></td>
                            <td style="text-align: center;">
                                <?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                            <td style="text-align: center;"><?php echo $report->total_receipt_cancelled; ?></td>
                            <td style="text-align: center;"><?php echo $report->total_count; ?></td>
                            <td style="text-align: center;"><?php echo $report->total_dis_count; ?> -
                                <?php echo $report->total_discount; ?></td>
                            <td style="text-align: center;"><?php echo $report->total_sum; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="2" style="text-align: right;">Total</th>
                        <th style="text-align: center;">
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_count + $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled ?>
                        </th>
                        <th style="text-align: center;">
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled; ?></th>
                        <th style="text-align: center;">
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_count ?></th>
                        <td style="text-align: center;">
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_dis_count; ?> -
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_discount; ?></td>
                        <th style="text-align: center;">
                            <?php echo $today_total_cat_wise_progress_reports[0]->total_sum ?></th>
                    </tr>
                </tbody>
            </table>

            <h5>Dr's. OPD Wise Report</h5>

            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Doctor Name</th>
                    <th>Total Appoint.</th>
                    <th>Cancelled</th>
                    <th>Confirmed</th>
                    <th>Discount</th>
                    <th>Dr. Total</th>
                    <th>Shares Total</th>
                    <th>Total Rs</th>
                </tr>
                <?php
                $count = 1;
                foreach ($today_OPD_reports as $report) { ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $report->test_group_name; ?></td>
                        <td style="text-align: center;">
                            <?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                        <td style="text-align: center;"><?php echo $report->total_receipt_cancelled; ?></td>
                        <td style="text-align: center;"><?php echo $report->total_count; ?></td>
                        <td style="text-align: center;"><?php echo $report->total_dis_count; ?> -
                            <?php echo $report->total_discount; ?></td>
                        <td style="text-align: center;">
                            <?php echo $report->total_sum - $report->shares; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $report->shares; ?>
                        </td>
                        <td style="text-align: center;"><?php echo $report->total_sum; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="2" style="text-align: right;">OPD Total</th>
                    <th style="text-align: center;">
                        <?php echo $today_total_OPD_reports[0]->total_count + $today_total_OPD_reports[0]->total_receipt_cancelled ?>
                    </th>
                    <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_receipt_cancelled; ?>
                    </th>
                    <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count ?></th>
                    <td style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_dis_count; ?> -
                        <?php echo $today_total_OPD_reports[0]->total_discount; ?></td>
                    <th style="text-align: center;">
                        <?php echo $today_total_OPD_reports[0]->total_sum - $today_total_OPD_reports[0]->shares ?></th>
                    <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->shares ?></th>
                    <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_sum ?></th>
                </tr>
            </table>

            <br />

            <?php

            $query = "SELECT
                  `roles`.`role_title`,
                  `users`.`user_title`  
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
            $user_data = $this->db->query($query)->result()[0];
            ?> </p>

            <p class="divFooter" style="text-align: right;"><b><?php echo $user_data->user_title; ?>
                    <?php echo $user_data->role_title; ?></b>
                <br /><?php echo $system_global_settings[0]->system_title ?> City <br />
                <strong>Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?></strong>
            </p>


        </div>

    </page>
</body>



</html>