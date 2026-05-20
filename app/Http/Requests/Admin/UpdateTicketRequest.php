<?php

namespace App\Http\Requests\Admin;

use App\Enums\TicketStatus;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('serial_number')) {
            $this->merge([
                'serial_number' => strtoupper(trim((string) $this->input('serial_number'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Ticket $ticket */
        $ticket = $this->route('ticket');

        return [
            'serial_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique(Ticket::class, 'serial_number')->ignore($ticket),
            ],
            'city_id' => ['required', Rule::exists(City::class, 'id')],
            'status' => ['required', Rule::in(TicketStatus::values())],
            'rejection_reason' => [
                Rule::requiredIf($this->input('status') === TicketStatus::Rejected->value),
                'nullable',
                'string',
                'max:1000',
            ],
            'proof_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
