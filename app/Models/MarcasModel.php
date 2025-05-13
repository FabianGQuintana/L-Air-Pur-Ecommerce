<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcasModel extends Model
{
    protected $table            = 'Marcas';
    protected $primaryKey       = 'id_marca';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_marca', 'nombre_marca','activo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;

}