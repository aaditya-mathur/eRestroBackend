<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Payment_statistics_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    public function get_payment_statistics_list(
        $offset = 0,
        $limit = 10,
        $sort = 'ot.id',
        $order = 'DESC'
    ) {
        $multipleWhere = '';

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "ot.id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['ot.order_id' => $search, 'ot.admin_payment' => $search, 'ot.partner_payment' => $search, 'ot.rider_payment' => $search, 'ot.total_amount' => $search, 'ot.delivery_tip' => $search];
        }

        $count_res = $this->db->select(' COUNT(ot.id) as `total`')
            ->join('users', 'ot.rider_id = users.id', 'left')
            ->join('partner_data pd', 'pd.user_id = ot.partner_id', 'left');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $attr_count = $count_res->get('order_transaction ot')->result_array();

        foreach ($attr_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select('ot.*,users.username as rider_name,pd.partner_name as partner_name')
            ->join('users', 'ot.rider_id = users.id', 'left')
            ->join('partner_data pd', 'pd.user_id = ot.partner_id', 'left');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $city_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->group_by('ot.id')->get('order_transaction ot')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($city_search_res as $row) {
            $row = output_escaping($row);
            $tempRow['id'] = $row['id'];
            $tempRow['order_id'] = $row['order_id'];
            $tempRow['partner_id'] = $row['partner_id'];
            $tempRow['partner_name'] = $row['partner_name'];
            $tempRow['rider_id'] = $row['rider_id'];
            $tempRow['rider_name'] = $row['rider_name'];
            $tempRow['admin_payment'] = $row['admin_payment'];
            $tempRow['partner_payment'] = $row['partner_payment'];
            $tempRow['rider_payment'] = $row['rider_payment'];
            $tempRow['delivery_tip'] = $row['delivery_tip'];
            $tempRow['total_amount'] = $row['total_amount'];
            // $tempRow['promo_discount'] = $row['promo_discount'];
            $tempRow['settelment_status'] = ($row['settelment_status'] == '1') ? '<a class="badge badge-success text-white" >Settled</a>' : '<a class="badge badge-danger text-white" >Not Settled</a>';
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
}
