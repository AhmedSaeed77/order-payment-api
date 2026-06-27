<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\OrderStatus;

class UpdateOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                    'items'                 =>  ['nullable','array'],
                    'items.*.product_name'  =>  ['required','string'],
                    'items.*.quantity'      =>  ['required','integer','min:1'],
                    'items.*.price'         =>  ['required','numeric','min:0'],
                    'status'                =>  ['nullable',Rule::enum(OrderStatus::class)],
                ];
    }
}
