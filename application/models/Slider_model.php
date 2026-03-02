<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Slider_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    function add_slider($data)
    {
        $data = escape_array($data);

        $slider_data = [
            'type' => $data['slider_type'],
            'image' => $data['image'],
        ];

        if (isset($data['slider_type']) && $data['slider_type'] == 'categories' && isset($data['category_id']) && !empty($data['category_id'])) {
            $slider_data['type_id'] = $data['category_id'];
        }

        if (isset($data['slider_type']) && $data['slider_type'] == 'products' && isset($data['product_id']) && !empty($data['product_id'])) {
            $slider_data['type_id'] = $data['product_id'];
        }

        if (isset($data['edit_slider'])) {
            if (empty($data['image'])) {
                unset($slider_data['image']);
            }

            $this->db->set($slider_data)->where('id', $data['edit_slider'])->update('sliders');
        } else {
            $this->db->insert('sliders', $slider_data);
        }
    }

    // function get_slider_list()
    // {
    //     $offset = 0;
    //     $limit = 10;
    //     $sort = 'id';
    //     $order = 'ASC';
    //     $multipleWhere = '';

    //     if (isset($_GET['offset']))
    //         $offset = $_GET['offset'];
    //     if (isset($_GET['limit']))
    //         $limit = $_GET['limit'];

    //     if (isset($_GET['sort']))
    //         if ($_GET['sort'] == 'id') {
    //             $sort = "id";
    //         } else {
    //             $sort = $_GET['sort'];
    //         }
    //     if (isset($_GET['order']))
    //         $order = $_GET['order'];

    //     if (isset($_GET['search']) and $_GET['search'] != '') {
    //         $search = $_GET['search'];
    //         $multipleWhere = ['`id`' => $search, '`type`' => $search];
    //     }

    //     $count_res = $this->db->select(' COUNT(id) as `total` ');

    //     if (isset($multipleWhere) && !empty($multipleWhere)) {
    //         $count_res->or_where($multipleWhere);
    //     }
    //     if (isset($where) && !empty($where)) {
    //         $count_res->where($where);
    //     }

    //     $slider_count = $count_res->get('sliders')->result_array();

    //     foreach ($slider_count as $row) {
    //         $total = $row['total'];
    //     }

    //     $search_res = $this->db->select(' * ');
    //     if (isset($multipleWhere) && !empty($multipleWhere)) {
    //         $search_res->or_like($multipleWhere);
    //     }
    //     if (isset($where) && !empty($where)) {
    //         $search_res->where($where);
    //     }

    //     $slider_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get('sliders')->result_array();

    //     $bulkData = array();
    //     $bulkData['total'] = $total;
    //     $rows = array();
    //     $tempRow = array();

    //     foreach ($slider_search_res as $row) {
    //         $row = output_escaping($row);

    //         $operate = ' <a href="' . base_url('admin/slider?edit_id=' . $row['id']) . '" class="btn btn-success btn-xs mr-1 mb-1"  title="Edit" data-id="' . $row['id'] . '" data-url="admin/slider/"><i class="fa fa-pen"></i></a>';
    //         $operate .= ' <a  href="javascript:void(0)" class="btn btn-danger btn-xs mr-1 mb-1"  title="Delete" id="delete-slider" data-id="' . $row['id'] . '"  ><i class="fa fa-trash"></i></a>';

    //         $tempRow['id'] = $row['id'];
    //         $tempRow['type'] = $row['type'];
    //         $tempRow['type_id'] = $row['type_id'];
    //         if($row['type'] == 'products'){
    //             $names = fetch_details(['id' => $row['type_id']], 'products', 'name');
    //             $tempRow['name'] = isset($names[0]['name']) ? $names[0]['name'] :"";
    //         }else if($row['type'] == 'categories'){
    //             $names = fetch_details(['id' => $row['type_id']], 'categories', 'name');
    //             $tempRow['name'] = isset($names[0]['name']) ? $names[0]['name'] : "";
    //         }else{
    //             $tempRow['name'] = "";
    //         }

    //         if (empty($row['image']) || file_exists(FCPATH . $row['image']) == FALSE) {
    //             $row['image'] = base_url() . NO_IMAGE;
    //             $row['image_main'] = base_url() . NO_IMAGE;
    //         } else {
    //             $row['image_main'] = base_url($row['image']);
    //             $row['image'] = get_image_url($row['image'], 'thumb', 'sm');
    //         }
    //         $tempRow['image'] = "<div class='image-box-100'><a href='" . $row['image_main'] . "' data-toggle='lightbox' data-gallery='gallery'> <img src='" . $row['image'] . "' class='rounded' ></a></div>";
    //         $tempRow['operate'] = $operate;
    //         $rows[] = $tempRow;
    //     }
    //     $bulkData['rows'] = $rows;
    //     print_r(json_encode($bulkData));
    // }

    function get_slider_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 's.id';
        $order = 'ASC';
        $multipleWhere = '';

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'id') {
                $sort = "s.id";
            } else {
                $sort = $_GET['sort'];
            }
        }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['s.id' => $search, 's.type' => $search];
        }

        // ------- COUNT QUERY -------
        $count_res = $this->db->select('COUNT(s.id) as total', false)
            ->from('sliders s')
            ->join('products p', 'p.id = s.type_id AND s.type = "products"', 'left')
            ->join('categories c', 'c.id = s.type_id AND s.type = "categories"', 'left');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->group_start();
            $count_res->or_like($multipleWhere);
            $count_res->or_like('p.name', $search);
            $count_res->or_like('c.name', $search);
            $count_res->group_end();
        }

        $slider_count = $count_res->get()->row_array();
        $total = isset($slider_count['total']) ? $slider_count['total'] : 0;

        // ------- DATA QUERY -------
        $search_res = $this->db->select('
            s.*,
            COALESCE(p.name, c.name) as name
        ')
            ->from('sliders s')
            ->join('products p', 'p.id = s.type_id AND s.type = "products"', 'left')
            ->join('categories c', 'c.id = s.type_id AND s.type = "categories"', 'left');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->group_start();
            $search_res->or_like($multipleWhere);
            $search_res->or_like('p.name', $search);
            $search_res->or_like('c.name', $search);
            $search_res->group_end();
        }

        $slider_search_res = $search_res
            ->order_by($sort, $order)
            ->limit($limit, $offset)
            ->get()
            ->result_array();

        // ------- PREPARE RESPONSE -------
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($slider_search_res as $row) {
            $row = output_escaping($row);

            $operate = ' <a href="' . base_url('admin/slider?edit_id=' . $row['id']) . '" class="btn btn-success btn-xs mr-1 mb-1"  title="Edit" data-id="' . $row['id'] . '" data-url="admin/slider/"><i class="fa fa-pen"></i></a>';
            $operate .= ' <a href="javascript:void(0)" class="btn btn-danger btn-xs mr-1 mb-1"  title="Delete" id="delete-slider" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row['id'];
            $tempRow['type'] = $row['type'];
            $tempRow['type_id'] = $row['type_id'];
            $tempRow['name'] = isset($row['name']) ? $row['name'] : '';

            if (empty($row['image']) || file_exists(FCPATH . $row['image']) == FALSE) {
                $row['image'] = base_url() . NO_IMAGE;
                $row['image_main'] = base_url() . NO_IMAGE;
            } else {
                $row['image_main'] = base_url($row['image']);
                $row['image'] = get_image_url($row['image'], 'thumb', 'sm');
            }

            $tempRow['image'] = "<div class='image-box-100'>
            <a href='" . $row['image_main'] . "' data-toggle='lightbox' data-gallery='gallery'>
                <img src='" . $row['image'] . "' class='rounded'>
            </a>
        </div>";
            $tempRow['operate'] = $operate;

            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        echo json_encode($bulkData);
    }
}
