<?php
class TestView extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('public/index');
    }

    private function render($content)
    {
        $this->load->view('public/templates/header');
        $this->load->view($content);
        $this->load->view('public/templates/footer');
    }
}
