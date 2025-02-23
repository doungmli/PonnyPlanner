<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
            'group_id' => 'required|exists:groups,id',
            'status' => 'required|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $existingInvoice = Invoice::where('group_id', $this->group_id)
                ->where('month', $this->month)
                ->where('year', $this->year)
                ->first();

            if ($existingInvoice) {
                $validator->errors()->add('group_id', 'Une facture existe déjà pour ce groupe ce mois.');
            }
        });
    }
}
