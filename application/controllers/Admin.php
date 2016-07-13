<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $page_items = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->model('photo_model');
        $this->load->library(array('pagination', 'session', 'form_validation', 'image_lib'));
        $this->load->helper('form');

        $this->page_items = array(
            'msg' => null,
            'table_photo' => null,
            'form_upload' => null,
            'form_edit' => null,
            'pagination' => null,
        );

        if ( ! $this->session->userdata('logged_in'))
        {
            // Allow some methods?
            $allowed = array(
                'index',
                'login',
            );
            if ( ! in_array($this->router->fetch_method(), $allowed))
            {
                redirect('admin');
            }
        }
    }

    public function index()
    {
        if ( ! $this->session->userdata('logged_in')) {
            $this->page_items['msg'] = "Login to see this page.";

            $this->render('index', $this->page_items);
        } else {

            if ($this->input->get()) {
                $this->session->set_userdata('order_field', $this->input->get('order_field'));
                $this->session->set_userdata('order', $this->input->get('order'));
            }

            // Get photo with offset based on 3 segment of uri
            $photos = $this->photo_model->get(
                $this->current_page(),
                ($this->session->userdata('order_field') ?: 'id'),
                ($this->session->userdata('order') ?: 'asc')
            );

            if ( ! $photos) {
                $this->page_items['msg'] = "No photo found in database.";

                $this->render('index', $this->page_items);
            } else {
                $this->page_items['table_photo'] = $this->load->view(
                    'admin/photo/parts_table_photo',
                    array('photos' => $photos),
                    true
                );

                $this->init_pagination();

                $this->page_items['pagination'] = $this->load->view(
                    'admin/templates/parts_pagination',
                    array('links' => $this->pagination->create_links()),
                    true
                );

                $this->render('index', $this->page_items);
            }
        }
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('admin');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->page_items['msg'] = validation_errors('<span> ','<span>');

                $this->render('index', $this->page_items);
            } else {
                $pass = $this->input->post('password');
                $hash = $this->config->item('hash');

                if ( ! password_verify($pass, $hash)) {
                    $this->page_items['msg'] = "Wrong password.";

                    $this->render('index', $this->page_items);
                } else {
                    $this->session->set_userdata('logged_in', true);

                    redirect('admin');
                }
            }
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('admin');
    }

    public function upload()
    {
        $this->form_validation->set_rules('name', 'Photo name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->page_items['msg'] = validation_errors('<span> ','</span>');
            $this->page_items['form_upload'] = $this->load->view(
                'admin/photo/parts_form_upload',
                $this->page_items,
                true
            );

            $this->render('photo/upload', $this->page_items);
        } else {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['encrypt_name']         = true;
            $config['max_size']             = 5000;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('photo')) {
                $this->page_items['msg'] = $this->upload->display_errors('<span> ', '</span>');
                $this->page_items['form_upload'] = $this->load->view(
                    'admin/photo/parts_form_upload',
                    $this->page_items,
                    true
                );

                $this->render('photo/upload', $this->page_items);
            } else {
                $upload_data = $this->upload->data();
                $data = $this->input->post();
                $source = 'uploads/'.$upload_data['file_name'];

                $this->create_thumb($source, 100, 75, true);
                $this->create_thumb($source, 640, 480, false);

                $data['link'] ='uploads/' . $upload_data['file_name'];
                $data['link_thumb'] =
                    'uploads/' .
                    $upload_data['raw_name'] .
                    '_thumb' .
                    $upload_data['file_ext']
                ;

                $this->photo_model->persist($data);

                $this->page_items['msg'] = "Upload success.";

                $this->render('index', $this->page_items);
            }
        }

    }

    public function edit($id=null)
    {
        if ( ! is_numeric($id)) {
            $this->page_items['msg'] = "No photo with such id";

            $this->render('index', $this->page_items);
        } else {
            $this->form_validation->set_rules('name', 'Photo name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');

            if ($this->form_validation->run() == false) {
                $photo = $this->photo_model->get_by_id($id);

                if ( ! $photo) {
                    $this->page_items['msg'] = "No photo with such id.";

                    $this->render('index', $data);
                } else {
                    $date = $photo['date'];
                    $format = 'm/d/Y';
                    $photo['date'] = date($format, strtotime($date));

                    $this->page_items['msg'] = validation_errors('<span> ','</span>');
                    $this->page_items['form_edit'] = $this->load->view(
                        'admin/photo/parts_form_edit',
                        array('msg' => $this->page_items['msg'], 'photo' => $photo),
                        true
                    );

                    $this->render('photo/edit', $this->page_items);
                }
            } else {
                $data['photo'] = $this->input->post();
                $this->photo_model->update($data['photo']['id'], $data['photo']);

                $this->page_items['msg'] = "Edit photo success.";
                $this->render('index', $this->page_items);
            }
        }

    }

    public function delete($id)
    {
        $photo = $this->photo_model->get_by_id($id);

        unlink($photo['link']);
        unlink($photo['link_thumb']);

        $this->photo_model->delete($id);

        redirect('admin');
    }

    private function init_pagination()
    {
        // Codeigniter pagination configuration
        $config = array();
        $config['base_url'] = site_url() . '/admin/index';
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
        // Get page index from 3rd segment of uri
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        return $page;
    }

    private function create_thumb($source, $w, $h, $thumb)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = $thumb;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = $w;
        $config['height']       = $h;
        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        $this->image_lib->clear();
    }

    private function render($view, $data)
    {
        $this->load->view('admin/templates/header');
        $this->load->view('admin/' . $view, $data);
        $this->load->view('admin/templates/footer');
    }
}
