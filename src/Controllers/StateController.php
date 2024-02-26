<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\State;
use Exception;

class StateController extends Controller {
    protected $state;

    public function __construct() {
        $this->state = new State();
    }

    public function index() {
        try {
            $states = $this->state->all();
            return $this->response($states);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            $stateData = $this->state->findOrFail($id);
            return $this->response([
                'state' => $stateData,
            ]);
        } catch (Exception $e) {
            return $this->response(['message' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request) {
        try {
            $data = $request->all();
            $stateData = $this->state->create($data);
            return $this->response([
                'message' => 'Estado criado com sucesso',
                'state' => $stateData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $stateData = $this->state->update($id, $request->all());
            return $this->response([
                'message' => 'Estado atualizado com sucesso',
                'state' => $stateData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            $this->state->delete($id);
            return $this->response(['message' => 'Estado deletado com sucesso'], 204);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 404);
        }
    }
}
