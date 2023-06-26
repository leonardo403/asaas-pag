<?php

if (!function_exists('formatOnlyNumber')) {
    function formatOnlyNumber($cpf_cnpj){
        return trim(preg_replace('/[^0-9]/', '', $cpf_cnpj));
    }
}

if (!function_exists('validateCpfCnpj')) {
    function validateCpfCnpj($cpf_cnpj) {
        if (preg_match('/^(\d)\1*$/', $cpf_cnpj)) {
            return false; // número repetido
        }

        if (strlen($cpf_cnpj) == 11) { // CPF
            // Calcula o primeiro dígito verificador
            $soma = 0;
            for ($i = 0; $i < 9; $i++) {
                $soma += intval($cpf_cnpj[$i]) * (10 - $i);
            }
            $digito_verificador_1 = ($soma % 11 < 2) ? 0 : (11 - $soma % 11);

            // Calcula o segundo dígito verificador
            $soma = 0;
            for ($i = 0; $i < 10; $i++) {
                $soma += intval($cpf_cnpj[$i]) * (11 - $i);
            }
            $digito_verificador_2 = ($soma % 11 < 2) ? 0 : (11 - $soma % 11);

            // Verifica se os dígitos verificadores estão corretos
            return ($cpf_cnpj[9] == $digito_verificador_1 && $cpf_cnpj[10] == $digito_verificador_2);
        } else if (strlen($cpf_cnpj) == 14) { // CNPJ
            // Calcula o primeiro dígito verificador
            $soma = 0;
            $peso = 5;
            for ($i = 0; $i < 12; $i++) {
                $soma += intval($cpf_cnpj[$i]) * $peso;
                $peso = ($peso == 2) ? 9 : ($peso - 1);
            }
            $digito_verificador_1 = ($soma % 11 < 2) ? 0 : (11 - $soma % 11);

            // Calcula o segundo dígito verificador
            $soma = 0;
            $peso = 6;
            for ($i = 0; $i < 13; $i++) {
                $soma += intval($cpf_cnpj[$i]) * $peso;
                $peso = ($peso == 2) ? 9 : ($peso - 1);
            }
            $digito_verificador_2 = ($soma % 11 < 2) ? 0 : (11 - $soma % 11);

            // Verifica se os dígitos verificadores estão corretos
            return ($cpf_cnpj[12] == $digito_verificador_1 && $cpf_cnpj[13] == $digito_verificador_2);
        } else {
            return false; // o número não é nem um CPF nem um CNPJ válido
        }
    }
}

if (!function_exists('asaasCurlSend')) {
    function asaasCurlSend($method, $endpoint, $data = '')
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, asaasCurlGetOpt(
                $method, $endpoint, $data
            ));

            $response = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            return asaasCurlFormatResponse($response, $httpCode);
        }
        catch (\Exception $e) {
            return asaasCurlFormatResponse();
        }
    }
}

if (!function_exists('asaasCurlGetOpt')) {
    function asaasCurlGetOpt($method, $endpoint, $data = '')
    {
        if($method == 'POST') {
            return [
                CURLOPT_URL => env('ASAAS_DOMAIN') . $endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'access_token: ' . env('ASAAS_KEY')
                ]
            ];
        }
        else if($method == 'GET'){
            return [
                CURLOPT_URL => env('ASAAS_DOMAIN').$endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'access_token: '.env('ASAAS_KEY')
                ]
            ];
        }
        else {
            return [];
        }
    }
}

if (!function_exists('asaasCurlFormatResponse')) {
    function asaasCurlFormatResponse($response = '', $httpCode = '')
    {
        if(!$response && !$httpCode){
            return [
                'status' => 400,
                'data'   => "Erro ao processar requisição.",
            ];
        }

        // Status code error
        $httpError = '';
        switch ($httpCode){
            case 401:
                $httpError = 'Operação não autorizada.';
                break;
            case 404:
                $httpError = 'O recurso solicitado não foi encontrado.';
                break;
            case 500:
                $httpError = 'Serviço indisponível no momento, tente novamente em alguns instantes.';
                break;
        }

        if(!empty($httpError)){
            return [
                'status' => $httpCode,
                'data'   => $httpError,
            ];
        }

        // Response error
        $response = json_decode($response, true);

        if(isset($response['errors'])){
            $errors = array_map(function ($error) {
                return '- ' . asaasPtBr($error['description']);
            }, $response['errors']);

            return [
                'status' => 422,
                'data'   => implode(PHP_EOL, $errors)
            ];
        }

        // Response success
        return [
            'status' => 200,
            'data'   => $response,
        ];
    }
}

if (!function_exists('asaasPtBr')) {
    function asaasPtBr($str)
    {
        $de   = ['nome', 'name', 'email' , 'customer'];
        $para = ['Nome', 'Nome', 'E-mail', 'Cliente' ];
        $str  = str_replace($de, $para, $str);
        $de   = array_map('ucfirst', $de);
        return str_replace($de, $para, $str);
    }
}
