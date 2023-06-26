<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'asaas_id',
        'cpf_cnpj',
        'name',
        'email',
        'phone',
        'postal_code',
        'address',
        'address_number',
        'complement',
        'province',
    ];

    public function findCpfCnpj($cpf_cpnj)
    {
        return $query->where('cpf_cnpj', '=', $cpf_cpnj);
    }
}
