<?php

namespace App\Http\Requests;


class ClientRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'name' => 'required',
            'cpf_cnpj' => 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @return array
     */
    public function update()
    {
        return [
            'name'  => 'required|string|max:50',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|min:11|max:11',
            'postal_code'    => 'required|string|min:8|max:8',
            'address'        => 'required|string|max:100',
            'province'       => 'required|string|max:50',
            'address_number' => 'required|string|max:10',
            'complement'     => 'max:50',
        ];
    }

    /**
     * Get the validation rules that apply to the delete request.
     *
     * @return array
     */
    public function destroy()
    {
        return [
            'id' => 'required|integer'
        ];
    }
}
