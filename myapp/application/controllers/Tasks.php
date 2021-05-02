<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function display($task_id)
    {
        $data['project_id'] = $this->task_model->get_task_project_id($task_id);
        $data['project_name'] = $this->task_model->get_project_name($data['project_id']);

        $data['task'] = $this->task_model->get_task($task_id);
        $data['main_view'] = "tasks/display";
        $this->load->view('layouts/main', $data);
    }


    
    
    // your new methods go here
    public function create($pid)
    {
        $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('task_body', 'Task Description', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['main_view'] = 'tasks/create_task';
            $this->load->view('layouts/main', $data);
        } else {
            $data = array(
                'project_id' => $pid,
                'task_name' => $this->input->post('task_name'),
                'task_body' => $this->input->post('task_body')
                );

            if ($this->task_model->create_task($data)) {
                $this->session->set_flashdata('task_created', 'Your Task has been created');

                redirect("projects/display/$pid");
            }
        }
    }

    public function mark_complete($task_id)
    {
       
            if ($this->task_model->mark_task_complete($task_id)) {
                $this->session->set_flashdata('task_updated', 'Your Task has been completed');
                redirect("tasks/display/$task_id");
            }else{
                redirect("tasks/display/$task_id");
            }
        
    }

    public function mark_incomplete($task_id)
    {
       
            if ($this->task_model->mark_task_incomplete($task_id)) {
                $this->session->set_flashdata('task_updated', 'Your Task has been completed');
                redirect("tasks/display/$task_id");
            }else{
                redirect("tasks/display/$task_id");
            }
        
    }

    public function delete($id)
    {
       
        $this->task_model->delete_task($id);
        redirect("projects/index");
          
        
    }
	
}
