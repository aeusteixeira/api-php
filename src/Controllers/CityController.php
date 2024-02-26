<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\City;
use Exception;

class CityController extends Controller {
    protected $city;

    public function __construct() {
        $this->city = new City();
    }

    public function index() {
        try {
            $citys = $this->city->all();
            return $this->response($citys);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            $cityData = $this->city->findOrFail($id);
            return $this->response([
                'city' => $cityData,
            ]);
        } catch (Exception $e) {
            return $this->response(['message' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request) {
        try {
            $data = $request->all();
            $cityData = $this->city->create($data);
            return $this->response([
                'message' => 'Endereço criado com sucesso',
                'city' => $cityData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $cityData = $this->city->update($id, $request->all());
            return $this->response([
                'message' => 'Endereço atualizado com sucesso',
                'city' => $cityData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            $this->city->delete($id);
            return $this->response(['message' => 'Endereço deletado com sucesso'], 204);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 404);
        }
    }
}
