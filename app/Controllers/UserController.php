<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // $data['users'] = $this->userModel->findAll(); 
        return view('users/index');
    }

    public function fetch()
    {
        $users = $this->userModel->findAll();
        return $this->response->setJSON($users);
    }

    public function create()
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];
        $this->userModel->insert($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'User added successfully']);
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];
        $this->userModel->update($id, $data);
        return $this->response->setJSON(['status' => 'User updated successfully']);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return $this->response->setJSON(['status' => 'User deleted successfully']);
    }
}
