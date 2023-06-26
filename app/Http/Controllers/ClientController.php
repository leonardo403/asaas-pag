<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ClientRequest;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(

        Client $client
    )
    {

        $this->client = $client;
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
            $cpf_cnpj = formatOnlyNumber($request->cpf_cnpj);

            if(!validateCpfCnpj($cpf_cnpj)){
                return response()->json('O CPF ou CNPJ informado é inválido.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $client = $this->client->findCpfCnpj($cpf_cnpj)->first();

            if (!$client) {
                $client = Client::create($request->validated());

                $response = Http::post('', [
                    $client
                ]);

                $client = $this->client->findCpfCnpj($cpf_cnpj)->first();
            }



            return response()->json([
                                    'message' => 'Cadastrado com sucesso !',
                                    'data' => $client], Response::HTTP_CREATED
                                );
        } catch (\Throwable $th) {
            return response()->json('Erro ao processar a requisição.', Response::HTTP_BAD_REQUEST);
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
    public function update(ClientRequest $request, Client $client)
    {
        //
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
