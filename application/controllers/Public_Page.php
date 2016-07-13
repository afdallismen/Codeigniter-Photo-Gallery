<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_Page extends CI_Controller
{
    private $page_items = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('photo_model');
        $this->load->library('pagination');
        $this->load->helper(array('download', 'form'));

        $this->page_items = array(
            'msg' => null,
            'gallery' => null,
            'pagination' => null
        );
    }

    public function index()
    {
        // Get photo with offset based on 3 segment of uri
        $order_field = 'id';
        $order = 'asc';
        $photos = $this->photo_model->get(
            $this->current_page(),
            $order_field,
            $order
        );

        if ( ! $photos) {
            $this->page_items['msg'] = "No photo to display yet.";

            $this->render('index', $this->page_items);
        } else {
            $this->page_items['gallery'] = $this->load->view(
                'public/photo/parts_gallery',
                array('photos' => $photos),
                true
            );

            $this->init_pagination();

            $this->page_items['pagination'] = $this->load->view(
                'public/templates/parts_pagination',
                array('links' => $this->pagination->create_links()),
                true
            );

            $this->render('index', $this->page_items);
        }
    }

    public function view($id=null)
    {
        if ( ! is_numeric($id)) {
            $this->page_items['msg'] = "No photo with such id.";

            $this->render('photo/view', $this->page_items);
        } else {
            $photo = $this->photo_model->get_by_id($id);

            if ( ! $photo) {
                $$this->page_items['msg'] = "Photo not found.";

                $this->render('photo/view', $this->page_items);
            } else {
                $date = $photo['date'];
                $format = 'd F Y';
                $photo['date'] = date($format, strtotime($date));

                $this->page_items['detail'] = $this->load->view(
                    'public/photo/parts_detail',
                    array('photo' => $photo),
                    true
                );

                $this->render('photo/view', $this->page_items);
            }
        }
    }

    public function download_image()
    {
        force_download($this->input->post('image_link'), null);
    }

    private function init_pagination()
    {
        // Codeigniter pagination configuration
        $config = array();
        $config['base_url'] = site_url() . '/public_page/index';
        $config['total_rows'] = $this->photo_model->record_count();
        $config['per_page'] = 18;
        $config['uri_segment'] = 3;
        // Applying bootstrap templates to codeigniter pagination
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
    }

    private function current_page()
    {
        // Get page index from 3 segment of uri
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        return $page;
    }

    private function render($view, $page_items)
    {
        $this->load->view('public/templates/header');
        $this->load->view('public/'. $view, $page_items);
        $this->load->view('public/templates/footer');
    }
}
