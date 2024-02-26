<?php 

namespace App\Controllers;

use App\Models\User;
use App\Http\Request;

class UserController extends Controller{
    public function index() {
        $user = new User();
        return $this->response($user->all());
    }

    public function show($id) {
        $user = new User();
        $userData = $user->read($id);
        return $this->response($userData);
    }
    

    public function create(Request $request) {
        $data = $request->all();
        $user = new User();
        $userId = $user->create($data);
        return $this->response(['message' => 'Usuário criado com sucesso', 'user' => $userId]);
    }
    

    public function update(Request $request, $id) {
        $user = new User();
        $updatedUser = $user->update($id, $request->all());
    
        if ($updatedUser) {
            return $this->response($updatedUser);
        } else {
            return $this->response(['error' => 'Usuário não encontrado ou erro na atualização'], 404);
        }
    }
    

    public function delete($id) {
        $user = new User();
        $userDeleted = $user->delete($id);
        return $this->response($userDeleted);
    }
}