<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssinaturaConsentimento extends Model
{
    protected $fillable = ['ip_endereco', 'latitude', 'longitude', 'dados_pessoas_id'];
    use HasFactory;
}
