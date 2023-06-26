<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ClientRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\AsaasService;

class ClientController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var AsaasService
     */
    private $asaasService;

    public function __construct(
        AsaasService $asaasService,
        Client $client
    )
    {
        $this->client = $client;
        $this->asaasService = $asaasService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {

        try {
            // Valida o CPF ou CNPJ
            $cpf_cnpj = formatOnlyNumber($request->input('cpf_cnpj'));

            if(!validateCpfCnpj($cpf_cnpj)){
                return response()->json('O CPF ou CNPJ informado é inválido.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $client = $this->client->findCpfCnpj($cpf_cnpj)->first();

            if (!$client) {
                $response = $this->asaasService->createClient($request);
                $client = Client::create($request->validated());
                if($response['status'] == 200){
                    $client->asaas_id = $response['data']['id'];
                    $client->save();
                }
                //$client = $this->client->findCpfCnpj($cpf_cnpj)->first();
            }

            return response()->json([
                                    'message' => 'Cadastrado com sucesso !',
                                    'data' => $client], Response::HTTP_CREATED
                                );
        } catch (\Exception $e) {
            return response()->json([
                     'Exception message:' => $e->getMessage() ." - ". $e->getCode()],
                      Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, $id)
    {
        // Verifica se o cliente existe
        $client = $this->client->find($id);

        if (!$client) {
            return response()->json('Cliente não encontrado.', 404);
        }

        $response = $this->asaasService->updateClient($request, $client->asaas_id);

        if($response['status'] != 200) {
            return response()->json($response['data'], $response['status']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Cliente removido com sucesso !']);
    }
}
