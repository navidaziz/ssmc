 <!doctype html>
 <html>

 <head>
     <title>Receipt</title>
     <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css"
         media="screen,print" />
     <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css"
         media="screen,print" id="skin-switcher" />

     <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css"
         media="screen,print" />
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
     <page size='A4'>



         <table style="width: 99%; margin: 2px; padding:2px; ">
             <thead>
                 <tr>
                     <td>
                         <table style="width: 100%; margin-top: 10px; color:black">

                             <tr>
                                 <td style="text-align: center;">
                                     <h4><?php echo $system_global_settings[0]->system_title ?> Chitral</h4>
                                     <h6 style="font-size: 11px;"><?php echo $system_global_settings[0]->address; ?>
                                         <br /> PHONE <?php echo $system_global_settings[0]->phone_number; ?>
                                     </h6>
                                     <h5>RECEIPT NO: <?php echo $invoice_detail->invoice_id; ?>
                                         <?php if ($invoice_detail->receipt_print == 0) { ?>
                                             <span style="font-size: 17px; display: block; margin-top: 5px;">Token NO:
                                                 <?php echo $invoice_detail->test_token_id; ?></span>
                                         <?php
                                                $query = "UPDATE `invoices` SET `invoices`.`receipt_print`=1 WHERE `invoices`.`invoice_id` = '" . $invoice_detail->invoice_id . "'";
                                                $this->db->query($query);
                                            } else { ?>
                                             <span style="font-size: 17px; display: block; margin-top: 5px;">Token NO:
                                                 ******<?php echo substr($invoice_detail->test_token_id, -4); ?></span>

                                         <?php } ?>
                                         <h4>
                                             Appointment No:
                                             <?php
                                                if ($invoice_detail->category_id != 5) {

                                                    $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
                                                    echo $this->db->query($query)->result()[0]->test_category;
                                                    echo " - " . $invoice_detail->today_count;
                                                } else {
                                                    $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
                                                    $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                                                    echo  $invoice_detail->today_count;
                                                    echo "<br />" . $opd_doctor . '<br />';
                                                    echo date("d F, Y ", strtotime($invoice_detail->created_date));
                                                } ?>
                                         </h4>
                                     </h5>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     <h5 style="border: 1px dashed  black; padding: 2px; color:black">
                                         <table width="100%" style="font-size: 15px;">
                                             <tr>
                                                 <td width="100">Patient: </td>
                                                 <td style="font-size: 20px;">
                                                     <?php echo trim(ucwords(strtolower($invoice_detail->patient_name))); ?>
                                                 </td>
                                             </tr>
                                             <!--                       
                      <tr>
                        <td>Mobile No:</td>
                        <td><?php echo $invoice_detail->patient_mobile_no; ?></td>
                      </tr> -->
                                             <tr>
                                                 <td colspan="2">Gender: <span
                                                         style="font-size: 20px;"><?php echo $invoice_detail->patient_gender; ?></span>
                                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age:
                                                     <span
                                                         style="font-size: 20px;"><?php echo @$invoice_detail->patient_age; ?>
                                                         Y </span>
                                                 </td>
                                             </tr>

                                             <tr>
                                                 <td>Address</td>
                                                 <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_address))); ?>
                                                 </td>
                                             </tr>

                                             <?php if ($invoice_detail->category_id != 5) { ?>
                                                 <tr>
                                                     <td>Refereed By:</td>
                                                     <td><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . "( " . $invoice_detail->doctor_designation . " )"; ?>
                                                     </td>
                                                 </tr>
                                             <?php } ?>
                                             <tr>
                                                 <td>Date & Time:</td>
                                                 <td><?php echo date("d F, Y h:i:s", strtotime($invoice_detail->created_date)); ?>
                                                 </td>
                                             </tr>
                                         </table>
                                         <h5>
                                 </td>

                             </tr>

                             <tr>
                                 <td>

                                     <h5>
                                         <table border="1" width="100%"
                                             style="border-collapse:collapse; color:black; font-size: 15px;">
                                             <tr>
                                                 <td>#</td>
                                                 <td>Details</td>
                                                 <td>Amount</td>
                                             </tr>
                                             <?php
                                                $count = 1;
                                                foreach ($invoice->invoice_details as $invoicedetail) { ?>
                                                 <tr>
                                                     <td><?php echo $count++; ?></td>
                                                     <td>
                                                         <?php if ($invoice_detail->category_id != 5) { ?>
                                                             <?php echo $invoicedetail->test_group_name; ?>
                                                         <?php } else {
                                                                echo "Consultation Fee";
                                                            } ?>
                                                     </td>
                                                     <td><?php echo $invoicedetail->price; ?></td>
                                                 </tr>
                                             <?php } ?>
                                             <tr>
                                                 <th colspan="3" style="text-align: right;">
                                                     <h4>
                                                         Total: <?php echo $invoice->price; ?>.00 Rs <br />
                                                         Discount: <?php if ($invoice->discount) {
                                                                        echo $invoice->discount;
                                                                    } else {
                                                                        echo "00";
                                                                    }  ?>.00 Rs <br />
                                                         Total: <?php echo $invoice->total_price; ?>.00 Rs
                                                     </h4>
                                 </td>
                             </tr>

                         </table>
                         </h5>
                     </td>
                 </tr>
         </table>
         </td>
         </tr>
         </thead>

         </table>
         <p style="font-size: smaller; font-weight: initial; text-align: center; color:black">Data entered by:
             <?php $query = "SELECT user_title from users WHERE user_id='" . $invoice->created_by . "'";
                echo $this->db->query($query)->result()[0]->user_title;
                $query = "SELECT
                  `roles`.`role_title` 
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $invoice->created_by . "'";
                echo " (" . $this->db->query($query)->result()[0]->role_title . ")";
                ?> </p>
         </div>

     </page>
 </body>



 </html>