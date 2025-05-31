<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $protectFields = true;
    protected $useSoftDeletes = false;
    protected $returnType       = 'array';
    protected $allowedFields = ['nombre','apellido','telefono', 'email', 'password_hash','rol', 'activo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    //Dates
    protected $useTimestamps = false;
}
