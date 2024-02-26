<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\Address;
use Exception;

class AddressController extends Controller {
    protected $address;

    public function __construct() {
        $this->address = new Address();
    }

    public function index() {
        try {
            $addresss = $this->address->all();
            return $this->response($addresss);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            $addressData = $this->address->findOrFail($id);// Acessar a relação de endereço
            return $this->response([
                'address' => $addressData,
            ]);
        } catch (Exception $e) {
            return $this->response(['message' => $e->getMessage()], 404);
        }
    }

    public function create(Request $request) {
        try {
            $data = $request->all();
            $addressData = $this->address->create($data);
            return $this->response([
                'message' => 'Endereço criado com sucesso',
                'address' => $addressData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $addressData = $this->address->update($id, $request->all());
            return $this->response([
                'message' => 'Endereço atualizado com sucesso',
                'address' => $addressData
            ]);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            $this->address->delete($id);
            return $this->response(['message' => 'Endereço deletado com sucesso'], 204);
        } catch (Exception $error) {
            return $this->response(['message' => $error->getMessage()], 404);
        }
    }
}
