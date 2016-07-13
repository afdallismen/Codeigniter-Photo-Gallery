<?php
class TestView extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->publicIndex();
    }

    public function publicIndex()
    {
        $this->render('public', 'public/index');
    }

    public function publicView()
    {
        $this->render('public', 'public/photo/view');
    }

    public function adminIndex()
    {
        $this->render('admin', 'admin/index');
    }

    public function adminLogin()
    {
        $this->render('admin', 'admin/auth/login');
    }

    public function adminLogout()
    {
        $this->render('admin', 'admin/auth/logout');
    }

    public function adminDelete()
    {
        $this->render('admin', 'admin/photo/delete');
    }

    public function adminEdit()
    {
        $this->render('admin', 'admin/photo/edit');
    }

    public function adminUpload()
    {
        $this->render('admin', 'admin/photo/upload');
    }

    public function adminView()
    {
        $this->render('admin', 'admin/photo/view');
    }

    private function render($template, $content)
    {
        $this->load->view($template . '/templates/header');
        $this->load->view($content);
        $this->load->view($template . '/templates/footer');
    }
}
