<?php

namespace App\Http\Requests;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Foundation\Http\FormRequest;

class SubKriteriaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "kode" => "required|string|max:255",
            "nama" => "required|string|max:255",
            "nilai" => "required|numeric|min:0|max:9",
            "kriteria_id" => "required|exists:kriterias,id", // Ensure kriteria_id exists
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Fetch all SubKriteria entries related to the given kriteria_id
        $cekKode = SubKriteria::where('kriteria_id', $this->kriteria_id)->get();

        if ($cekKode->isNotEmpty()) {
            $lastKode = $cekKode->last()->kode; // Get the last kode
            $prefix = substr($lastKode, 0, 1); // Extract the prefix (e.g., "A")
            $ctr = (int) substr($lastKode, 1) + 1; // Increment the numeric part
            $kode = $prefix . $ctr; // Combine prefix and incremented counter
        } else {
            // Fetch the related Kriteria entry
            $kriteria = Kriteria::find($this->kriteria_id);

            if ($kriteria !== null) {
                $kode = $kriteria->kode . '1'; // Default to first code for the Kriteria
            } else {
                $kode = 'DEFAULT_CODE'; // Fallback code
            }
        }

        // Merge the generated kode into the validation data
        $this->merge([
            'kode' => $kode,
        ]);
    }
}
