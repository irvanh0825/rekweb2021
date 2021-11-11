<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Game extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Game_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('game/game_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Game_model->json();
    }

    public function read($id) 
    {
        $row = $this->Game_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'genre' => $row->genre,
		'game_name' => $row->game_name,
	    );
            $this->load->view('game/game_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('game'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('game/create_action'),
	    'id' => set_value('id'),
	    'genre' => set_value('genre'),
	    'game_name' => set_value('game_name'),
	);
        $this->load->view('game/game_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'genre' => $this->input->post('genre',TRUE),
		'game_name' => $this->input->post('game_name',TRUE),
	    );

            $this->Game_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('game'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Game_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('game/update_action'),
		'id' => set_value('id', $row->id),
		'genre' => set_value('genre', $row->genre),
		'game_name' => set_value('game_name', $row->game_name),
	    );
            $this->load->view('game/game_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('game'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'genre' => $this->input->post('genre',TRUE),
		'game_name' => $this->input->post('game_name',TRUE),
	    );

            $this->Game_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('game'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Game_model->get_by_id($id);

        if ($row) {
            $this->Game_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('game'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('game'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('genre', 'genre', 'trim|required');
	$this->form_validation->set_rules('game_name', 'game name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "game.xls";
        $judul = "game";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Genre");
	xlsWriteLabel($tablehead, $kolomhead++, "Game Name");

	foreach ($this->Game_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->genre);
	    xlsWriteLabel($tablebody, $kolombody++, $data->game_name);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=game.doc");

        $data = array(
            'game_data' => $this->Game_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('game/game_doc',$data);
    }

}

/* End of file Game.php */
/* Location: ./application/controllers/Game.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-11-11 18:22:43 */
/* http://harviacode.com */