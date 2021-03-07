<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH. 'libraries/Format.php';


class ApiProductController extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model');
    }

    public function index_get()
    {
       echo "default";
    }

    public function indexProject_get()
    {
        $projects = new Project_model;
        $result_project = $projects->get_projects();
        $this->response($result_project, 200);
    }

    public function editProject_get($id){
        $projects = new Project_model;
        $projects = $projects->get_project($id);
        $this->response($projects,200);
    }

    public function storeProject_post()
    {
        $projects = new Project_model;
        $data = [
            'project_user_id' =>  $this->input->post('project_user_id'),
            'project_name' => $this->input->post('project_name'),
            'project_body' => $this->input->post('project_body'),
            
        ];
        $result = $projects->create_project($data);
        if($result > 0)
        {
            $this->response([
                'status' => true,
                'message' => 'NEW PROJECT CREATED'
            ], RestController::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO CREATE NEW PROJECT'
            ], RestController::HTTP_BAD_REQUEST);
        }
        
    }


    public function updateProject_put($id)
    {
        $project = new Project_model;
        $data = [
            'project_user_id' =>  $this->put('project_user_id'),
            'project_name' => $this->put('project_name'),
            'project_body' => $this->put('project_body')
        ];
        $result = $project->edit_project($id, $data);
        if($result > 0)
        {
            $this->response([
                'status' => true,
                'message' => 'PROJECT UPDATED'
            ], RestController::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO UPDATE PROJECT'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function deleteProject_delete($id)
    {
        $project = new Project_model;
        $result = $project->delete_project($id);
        if($result > 0)
        {
            $this->response([
                'status' => true,
                'message' => 'PROJECT DELETED'
            ], RestController::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => false,
                'message' => 'FAILED TO DELETE PROJECT'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}

?>