<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('temperatures_model');
        $this->load->model('electricity_model');
        
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    public function last_temp()
    {
        echo json_encode($this->temperatures_model->get_last_temps());
    }

    public function temp_24h()
    {
        echo json_encode($this->temperatures_model->get_24h_temps());
    }

    public function electricity_state()
    {
        $this->load->model('supla_model');
        echo json_encode($this->supla_model->get_counter_state($_GET['channel']));
    }

    public function electricity_counters()
    {
        echo json_encode($this->electricity_model->get_all_counters());
    }
}
