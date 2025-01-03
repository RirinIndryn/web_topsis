<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = "kriteria";
    protected $primaryKey = "id";
    public $incrementing = "true";
    // protected $keyType = "string";
    public $timestamps = "true";
    protected $fillable = [
        "kode",
        "nama",
        "bobot",
        "kategori"
    ];

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }


    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }
}
