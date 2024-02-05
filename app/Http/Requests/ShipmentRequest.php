<?php

namespace App\Http\Requests;

use App\Rules\OutgoingShipmentItemExceedsStockQuantity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contact_id'                   => ['required', 'exists:contacts,id'],
            'warehouse_id'                 => ['required', 'exists:warehouses,id'],
            'quantity'                     => ['required', 'integer', 'min:1'],
            'description'                  => ['nullable', 'string', 'max:255'],
            'reference'                    => ['required', 'string', 'max:255'],
            'tracking_number'              => ['nullable', 'string', 'max:255'],
            'status'                       => ['required', 'string', 'max:255'],
            'shipment_type'                => ['required', 'string', 'max:255'],
            'scheduled_date'               => ['required', 'date'],
            'shipment_date'                => ['nullable', 'date'],
            'shipmentItems'                => ['required', 'array', 'min:1'],
            'shipmentItems.*.product_id'   => ['required', 'exists:products,id'],
            'shipmentItems.*.quantity'     => ['required', 'integer', 'min:1'],
            'shipmentItems.*.batch_number' => ['nullable', 'string', 'max:255'],
            'shipmentItems.*.barcode'      => ['nullable', 'string', 'max:255'],
            'shipmentItems.*.expiry_date'  => ['nullable', 'date'],
        ];
    }
}
