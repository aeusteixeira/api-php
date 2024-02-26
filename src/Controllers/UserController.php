<?php

namespace App\Controllers;

use App\Models\User;
use App\Http\Request;
use Exception;

class UserController extends Controller {
    protected $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        try {
            $users = $this->user->all();
            return $this->response($users);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            $userData = $this->user->findOrFail($id);
            return $this->response($userData);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 404);
        }
    }

    public function create(Request $request) {
        try {
            $data = $request->all();
            $userData = $this->user->create($data);
            return $this->response([
                'message' => 'Usuário criado com sucesso',
                'user' => $userData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $userData = $this->user->update($id, $request->all());
            return $this->response([
                'message' => 'Usuário atualizado com sucesso',
                'user' => $userData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            $this->user->delete($id);
            return $this->response(['message' => 'Usuário deletado com sucesso'], 204);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 404);
        }
    }
}
