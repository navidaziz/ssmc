<!doctype html>
<html>

<head>
    <title>Receipt</title>
    <style>
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                margin: 0;
                font-family: Arial, sans-serif;
                font-size: 11px;
                color: black;
            }

            .pos-wrapper {
                width: 80mm;
                padding: 5px;
                margin: auto;
            }

            h4,
            h5,
            h6 {
                margin: 0;
                padding: 2px 0;
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
            }

            td,
            th {
                border: 1px solid black;
                padding: 2px;
                word-break: break-word;
            }

            .no-border {
                border: none !important;
            }

            .center {
                text-align: center;
            }

            .right {
                text-align: right;
            }
        }
    </style>
</head>

<body>
    <div class="pos-wrapper">

        <h4><?php echo $system_global_settings[0]->system_title ?> Chitral</h4>
        <h6><?php echo $system_global_settings[0]->address; ?><br>PHONE <?php echo $system_global_settings[0]->phone_number; ?></h6>
        <h5>RECEIPT NO: <?php echo $invoice_detail->invoice_id; ?></h5>

        <?php if ($invoice_detail->receipt_print == 0) {
            echo "<h5>Token NO: " . $invoice_detail->test_token_id . "</h5>";
            $this->db->query("UPDATE `invoices` SET `receipt_print`=1 WHERE `invoice_id` = '" . $invoice_detail->invoice_id . "'");
        } else {
            echo "<h5>Token NO: ******" . substr($invoice_detail->test_token_id, -4) . "</h5>";
        } ?>

        <h5>Appointment No:
            <?php
            if ($invoice_detail->category_id != 5) {
                $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
                echo $this->db->query($query)->result()[0]->test_category . " - " . $invoice_detail->today_count;
            } else {
                $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
                $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                echo $invoice_detail->today_count . "<br>" . $opd_doctor . "<br>" . date("d F, Y", strtotime($invoice_detail->created_date));
            } ?>
        </h5>

        <table class="no-border">
            <tr>
                <td class="no-border">Patient:</td>
                <td class="no-border" style="font-weight: bold;"><?php echo ucwords(strtolower($invoice_detail->patient_name)); ?></td>
            </tr>
            <tr>
                <td class="no-border">Gender:</td>
                <td class="no-border"><?php echo $invoice_detail->patient_gender; ?> &nbsp;&nbsp; Age: <?php echo @$invoice_detail->patient_age; ?> Y</td>
            </tr>
            <tr>
                <td class="no-border">Address:</td>
                <td class="no-border"><?php echo ucwords(strtolower($invoice_detail->patient_address)); ?></td>
            </tr>
            <?php if ($invoice_detail->category_id != 5) { ?>
                <tr>
                    <td class="no-border">Referred By:</td>
                    <td class="no-border"><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . " (" . $invoice_detail->doctor_designation . ")"; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="no-border">Date & Time:</td>
                <td class="no-border"><?php echo date("d F, Y h:i:s", strtotime($invoice_detail->created_date)); ?></td>
            </tr>
        </table>

        <br>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Details</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($invoice->invoice_details as $invoicedetail) { ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                            <?php echo ($invoice_detail->category_id != 5) ? $invoicedetail->test_group_name : "Consultation Fee"; ?>
                        </td>
                        <td class="right"><?php echo $invoicedetail->price; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" class="right">Total</td>
                    <td class="right"><?php echo number_format($invoice->price, 2); ?> Rs</td>
                </tr>
                <tr>
                    <td colspan="2" class="right">Discount</td>
                    <td class="right"><?php echo number_format($invoice->discount ?: 0, 2); ?> Rs</td>
                </tr>
                <tr>
                    <td colspan="2" class="right"><strong>Net Total</strong></td>
                    <td class="right"><strong><?php echo number_format($invoice->total_price, 2); ?> Rs</strong></td>
                </tr>
            </tbody>
        </table>

        <br>
        <p class="center" style="font-size: 10px;">
            Data entered by:
            <?php
            $user = $this->db->query("SELECT user_title FROM users WHERE user_id='" . $invoice->created_by . "'")->row();
            $role = $this->db->query("SELECT roles.role_title FROM roles JOIN users ON roles.role_id = users.role_id WHERE users.user_id='" . $invoice->created_by . "'")->row();
            echo $user->user_title . " (" . $role->role_title . ")";
            ?>
        </p>
    </div>
</body>

</html>