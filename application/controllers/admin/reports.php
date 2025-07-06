<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->lang->load("patients", 'english');
		$this->lang->load("system", 'english');
		$this->load->model("admin/test_group_model");
		$this->load->model("admin/reports_model");
		$this->load->model("admin/invoice_model");
		$this->load->model("admin/test_type_model");


		$this->load->model("admin/patient_model");
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------



	public function index()
	{


		$this->data['title'] = 'Reports';
		$this->data["view"] = ADMIN_DIR . "reports/index";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}






	// public function custom_report()
	// {
	// 	$start_date = $this->input->get('start_date');
	// 	$end_date = $this->input->get('end_date');

	// 	//$this->data = $this->reports_model->daily_reception_report($date);
	// 	$this->data = $this->reports_model->today_recp_report($date);
	// 	$this->data['date'] = $date;

	// 	$this->load->view(ADMIN_DIR . "reports/daily_reception_report", $this->data);
	// }

	public function categories_custom_report()
	{



		$this->data['start_date'] = $start_date = $this->input->get('start_date');
		$this->data['end_date']   = $end_date   = $this->input->get('end_date');

		$query = "SELECT * FROM `test_categories` WHERE `test_category_id` IN (1,2,3,4)";
		$test_categories = $this->db->query($query)->result();

		foreach ($test_categories as $test_categorie) {
			$query = "SELECT 
                tg.`test_group_name` AS test_name, 
                COUNT(tg.`test_group_id`) AS test_total,
                SUM(itg.`price`) AS total_rs 
            FROM 
                `invoice_test_groups` AS itg
            JOIN 
                `test_groups` AS tg ON itg.`test_group_id` = tg.`test_group_id`
            JOIN 
                `invoices` AS i ON itg.`invoice_id` = i.`invoice_id`
            WHERE 
                i.`is_deleted` = 0
                AND tg.`category_id` = ?
                AND DATE(itg.`created_date`) BETWEEN ? AND ?
            GROUP BY 
                tg.`test_group_id`
            ORDER BY 
                test_total DESC";

			$result = $this->db->query($query, [
				$test_categorie->test_category_id,
				$start_date,
				$end_date
			]);

			$test_categorie->test_total = $result->result();
		}


		$this->data['test_categories'] = $test_categories;


		$this->load->view(ADMIN_DIR . "reports/categories_custom_report", $this->data);
	}


	public function custom_report()
	{

		$this->data['start_date'] = $start_date = $this->input->get('start_date');
		$this->data['end_date'] = $end_date = $this->input->get('end_date');


		$query = "SELECT
						`test_categories`.`test_category`
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
						, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
						, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
						, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
						FROM
						`test_categories`
						LEFT JOIN `invoices` 
						ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
						WHERE DATE(`invoices`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
						AND `invoices`.`category_id` !=5
						GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$this->data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
			, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
			, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
			, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
			, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
						FROM
						`test_categories`
						LEFT JOIN `invoices` 
						ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
						WHERE DATE(`invoices`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
						AND `invoices`.`category_id` !=5";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$this->data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
						`test_groups`.`test_group_name`
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
						, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
						, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
						, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_groups`,
					`invoices` 
					WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
					AND `invoices`.`category_id`=5
					AND DATE(`invoices`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
					GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$this->data["today_OPD_reports"] = $today_OPD_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum,
			SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
			, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
			, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
			, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
						, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_groups`,
					`invoices` 
					WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
					AND `invoices`.`category_id`=5
					AND DATE(`invoices`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "' ";
		$today_OPD_report = $this->db->query($query)->result();
		$this->data["today_total_OPD_reports"] = $today_OPD_report;


		$query = "SELECT
						`test_groups`.`test_group_name`
						, `test_groups`.`test_group_id`
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`alkhidmat_income`,NULL)) AS shares
						, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
						, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
						, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
						, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_groups`,
					`invoices` 
					WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
					AND `invoices`.`category_id`=5
					AND `test_groups`.`share` >0
					AND DATE(`invoices`.`created_date`) BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
					GROUP BY `test_groups`.`test_group_name`";
		$income_from_drs = $this->db->query($query)->result();
		$this->data["income_from_drs"] = $income_from_drs;
		$this->load->view(ADMIN_DIR . "reports/custom_report", $this->data);
	}


	public function daily_reception_report()
	{
		$date = $this->input->get('date');
		if ($date) {
			$date = date("Y-m-d", strtotime($date));
		} else {
			$date = date("Y-m-d");
		}
		//$this->data = $this->reports_model->daily_reception_report($date);
		$this->data = $this->reports_model->today_recp_report($date);
		$this->data['date'] = $date;

		$this->load->view(ADMIN_DIR . "reports/daily_reception_report", $this->data);
	}



	public function today_recp_report($date)
	{

		$this->data = $this->reports_model->today_recp_report($date);
		$this->load->view(ADMIN_DIR . "reports/custom_report", $this->data);
	}

	public function monthly_report($month, $year)
	{
		$month = (int) $month;
		$year = (int) $year;
		$this->data['month'] = date("F, Y ", strtotime($year . "-" . $month . "-1"));
		$this->data['month_filter'] = $month;
		$this->data['year_filter'] = $year;



		$this->data['day_wise_monthly_report'] = $this->reports_model->day_wise_monthly_report($month, $year);
		$this->data['monthly_total_report'] = $this->reports_model->monthly_total_report($month, $year);
		$this->data["this_month_OPD_reports"] = $this->reports_model->this_month_opd_report($month, $year);
		$this->data["this_month_total_OPD_reports"] = $this->reports_model->this_month_total_opd_report($month, $year);

		$this->data['this_month_expenses'] = $this->reports_model->this_months_expense_types($month, $year);
		$this->data['this_month_total_expenses'] = $this->reports_model->this_month_total_expense();
		$this->data['monthly_expenses'] = $this->reports_model->monthly_expenses($month, $year);
		$this->data['categories_wise_cancellations'] = $this->reports_model->categories_wise_cancellations();
		$this->data['dr_refers'] = $this->reports_model->dr_refers($month, $year);
		$this->data['this_month_tests'] = $this->reports_model->this_month_tests($month, $year);


		$this->load->view(ADMIN_DIR . "reports/monthly_report", $this->data);
	}
}
