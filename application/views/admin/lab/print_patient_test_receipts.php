<!doctype html>
<html>

<head>
    <title>POS Receipt</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        body {
            width: 80mm;
            margin: 0 auto;
        }

        h4,
        h5,
        h6 {
            margin: 2px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        td,
        th {
            padding: 4px;
            border: 1px solid #000;
            text-align: left;
        }

        .no-border td {
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .dashed {
            border: 1px dashed black;
            padding: 5px;
        }

        @media print {
            body {
                width: 80mm;
            }
        }
    </style>
</head>

<body> 

    <h4><strong><?php echo $system_global_settings[0]->system_title; ?></strong></h4>
    <small><?php echo $system_global_settings[0]->address; ?></small>
    <h6>PHONE: <?php echo $system_global_settings[0]->phone_number; ?></h6>

    <h5>Receipt No: <?php echo $invoice_detail->invoice_id; ?></h5>
    <h5>
        Token No:
        <?php if ($invoice_detail->receipt_print == 0) {
            echo $invoice_detail->test_token_id;
            $query = "UPDATE `invoices` SET `receipt_print`=1 WHERE `invoice_id` = '{$invoice_detail->invoice_id}'";
            $this->db->query($query);
        } else {
            echo '******' . substr($invoice_detail->test_token_id, -4);
        } ?>
    </h5>

    <h5>
        Appointment No:
        <?php
        if ($invoice_detail->category_id != 5) {
            $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
            echo $this->db->query($query)->result()[0]->test_category . " - " . $invoice_detail->today_count;
        } else {
            $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
            echo $invoice_detail->today_count . "<br />" . $this->db->query($query)->result()[0]->test_group_name . "<br />" . date("d F, Y", strtotime($invoice_detail->created_date));
        } ?>
    </h5>

    <div class="dashed">
        <table class="no-border">
            <tr>
                <td>Patient:</td>
                <td class="bold"><?php echo ucwords(strtolower($invoice_detail->patient_name)); ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo $invoice_detail->patient_gender; ?> | Age: <?php echo $invoice_detail->patient_age; ?> Y</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo ucwords(strtolower($invoice_detail->patient_address)); ?></td>
            </tr>
            <?php if ($invoice_detail->category_id != 5) { ?>
                <tr>
                    <td>Referred By:</td>
                    <td><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . " (" . $invoice_detail->doctor_designation . ")"; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Date & Time:</td>
                <td><?php echo date("d F, Y h:i:s", strtotime($invoice_detail->created_date)); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Details</th>
            <th>Amount</th>
        </tr>
        <?php
        $count = 1;
        foreach ($invoice->invoice_details as $invoicedetail) {
        ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td>
                    <?php echo ($invoice_detail->category_id != 5) ? $invoicedetail->test_group_name : 'Consultation Fee'; ?>
                </td>
                <td><?php echo number_format($invoicedetail->price, 2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2" class="text-right bold">Total</td>
            <td><?php echo number_format($invoice->price, 2); ?> Rs</td>
        </tr>
        <tr>
            <td colspan="2" class="text-right bold">Discount</td>
            <td><?php echo $invoice->discount; ?> Rs</td>
        </tr>
        <tr>
            <td colspan="2" class="text-right bold">Net Total</td>
            <td><?php echo number_format($invoice->total_price, 2); ?> Rs</td>
        </tr>
    </table>

    <p class="text-center" style="margin-top:10px;">Data entered by:
        <?php
        $query = "SELECT user_title FROM users WHERE user_id='{$invoice->created_by}'";
        echo $this->db->query($query)->result()[0]->user_title;
        $query = "SELECT roles.role_title FROM roles JOIN users ON roles.role_id = users.role_id WHERE users.user_id='{$invoice->created_by}'";
        echo " (" . $this->db->query($query)->result()[0]->role_title . ")";
        ?>
    </p>

</body>

</html>