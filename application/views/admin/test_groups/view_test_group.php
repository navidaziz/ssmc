 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                 <li>
                     <i class="fa fa-table"></i>
                     <a href="<?php echo site_url(ADMIN_DIR . "test_groups/view/"); ?>"><?php echo $this->lang->line('Test Groups'); ?></a>
                 </li>
                 <li><?php echo $title; ?></li>
             </ul>
             <!-- /BREADCRUMBS -->
             <div class="row">

                 <div class="col-md-6">
                     <div class="clearfix">
                         <h3 class="content-title pull-left"><?php echo $test_groups[0]->test_group_name; ?></h3>
                     </div>
                     <div class="description">
                         Time <?php echo $test_groups[0]->test_time; ?> - Price <?php echo $test_groups[0]->test_price; ?> Rs
                     </div>
                 </div>

                 <div class="col-md-6">
                     <div class="pull-right">
                         <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "test_groups/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                         <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "test_groups/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                     </div>
                 </div>

             </div>


         </div>
     </div>
 </div>
 <!-- /PAGE HEADER -->

 <!-- PAGE MAIN CONTENT -->
 <div class="row">


     <div class="col-md-8">
         <div class="box border blue" id="messenger">
             <div class="box-title">
                 <h4><i class="fa fa-bell"></i> Group Tests List</h4>

             </div>
             <div class="box-body">

                 <div class="table-responsive">

                     <table class="table table-bordered">
                         <thead>

                             <tr>
                                 <th>#</th>
                                 <th><?php echo $this->lang->line('test_name'); ?></th>
                                 <th>Unit</th>
                                 <th>Normal Value</th>
                                 <th>Test Type</th>
                                 <th><?php echo $this->lang->line('Order'); ?></th>
                                 <th><?php echo $this->lang->line('Action'); ?></th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $count = 1;
                                foreach ($test_group_tests as $test_group_test) : ?>

                                 <tr>
                                     <td><?php echo $count++; ?></td>
                                     <td> <?php echo $test_group_test->test_name; ?> </td>
                                     <td>
                                         <input onkeyup="add_test_unit('<?php echo $test_group_test->test_id; ?>')" type="text" value="<?php echo $test_group_test->unit; ?>" name="test_unit" id="test_unit_<?php echo $test_group_test->test_id; ?>" />
                                     </td>
                                     <td> <?php echo $test_group_test->normal_values; ?> </td>
                                     <td><?php echo $test_group_test->test_type; ?></td>
                                     <td>

                                         <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "test_groups/up_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-up"></i> </a>
                                         <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "test_groups/down_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-down"></i></a>
                                     </td>
                                     <td>
                                         <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "test_groups/delete_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-trash-o"></i></a>
                                     </td>
                                 </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>

                     <?php //echo $pagination; 
                        ?>


                 </div>


             </div>

         </div>
     </div>



     <div class="col-md-4">
         <div class="box border blue" id="add_test_form" style="display: none;">
             <div class="box-title">
                 <h4><i class="fa fa-plus"></i> Add New Test</h4>
             </div>
             <div class="box-body">
                 <?php
                    $add_form_attr = array("class" => "form-horizontal");
                    echo form_open_multipart(ADMIN_DIR . "test_groups/save_test_data/" . $test_groups[0]->test_group_id, $add_form_attr);
                    ?>
                 <table class="table">
                     <tr>
                         <th><?php echo $this->lang->line('test_category') ?></th>
                         <th><?php echo form_dropdown("test_category_id", $test_categories, "", "class=\"form-c ontrol\" required style=\"\""); ?></th>
                     </tr>
                     <tr>
                         <th><?php echo $this->lang->line('test_type') ?></th>
                         <th><?php echo form_dropdown("test_type_id", $test_types_list, "", "class=\"form-co ntrol\" required style=\"\""); ?></th>
                     </tr>
                     <tr>
                         <th><?php echo $this->lang->line('test_name') ?></th>
                         <th><input type="text" name="test_name" value="" id="test_name" class="form-con trol" style="" required="required" title="Test Name" placeholder="Test Name"></th>
                     </tr>

                     <tr>
                         <th><?php echo $this->lang->line('normal_values') ?></th>
                         <th>
                             <textarea name="normal_values" value="" id="normal_values" class="form-co ntrol" style="width: 100%;" rows="7" title="Normal Values" placeholder="Normal Values"></textarea>
                         </th>
                     </tr>
                     <tr>
                         <th>Add Test</th>
                         <th><input type="submit" name="submit" value="Save" class="b tn bt n-primary" style=""></th>
                     </tr>
                 </table>
                 <?php echo form_close(); ?>






             </div>
         </div>



         <div class="box border blue" id="messenger">
             <div class="box-title">
                 <h4><i class="fa fa-bell"></i>Select Test for test group</h4>
                 <button class="btn btn-daanger btn-sm" onclick="$('#add_test_form').toggle()"><i class="fa fa-plus"></i> Add Test</button>
             </div>
             <div class="box-body">

                 <?php
                    $add_form_attr = array("class" => "form-horizontal");
                    echo form_open_multipart(ADMIN_DIR . "test_groups/save_test_group_data/" . $test_groups[0]->test_group_id, $add_form_attr);
                    ?>

                 <div class="form-group">


                     <div class="col-md-12">
                         <b>Search Test</b>
                         <select name="test_id[]" class="js-example-basic-single" multiple="multiple" required="required" style="width: 100% !important;">
                             <?php foreach ($test_types as $test_type) { ?>
                                 <optgroup label="<?php echo $test_type->test_type;  ?>">
                                     <?php foreach ($test_type->tests as $test_id => $test_name) { ?>
                                         <option value="<?php echo $test_id; ?>"><?php echo $test_name; ?></option>
                                     <?php } ?>
                                 </optgroup>
                             <?php } ?>
                         </select>
                     </div>
                     <?php echo form_error("test_id", "<p class=\"text-danger\">", "</p>"); ?>
                 </div>


                 <div class="col-md-offset-2 col-md-10">
                     <?php
                        $submit = array(
                            "type"  =>  "submit",
                            "name"  =>  "submit",
                            "value" =>  $this->lang->line('Save'),
                            "class" =>  "btn btn-primary",
                            "style" =>  ""
                        );
                        echo form_submit($submit);
                        ?>



                     <?php
                        $reset = array(
                            "type"  =>  "reset",
                            "name"  =>  "reset",
                            "value" =>  $this->lang->line('Reset'),
                            "class" =>  "btn btn-default",
                            "style" =>  ""
                        );
                        echo form_reset($reset);
                        ?>
                 </div>
                 <div style="clear:both;"></div>

                 <?php echo form_close(); ?>

             </div>

         </div>
     </div>


     <!-- /MESSENGER -->
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
     // In your Javascript (external .js resource or <script> tag)
     $(document).ready(function() {
         $('.js-example-basic-single').select2();
     });
 </script>