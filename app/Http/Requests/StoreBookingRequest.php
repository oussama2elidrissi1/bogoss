<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou vérifier que l'utilisateur est authentifié
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'string'],
            'notes' => ['nullable', 'string', 'max:1000'],
            
            // Items du panier
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['required', 'exists:services,id'],
            'items.*.staff_id' => ['nullable', 'exists:staff,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'items.*.notes' => ['nullable', 'string', 'max:500'],
            
            // Options par item
            'items.*.options' => ['nullable', 'array'],
            'items.*.options.*.option_id' => ['required', 'exists:service_options,id'],
            'items.*.options.*.quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La date de réservation est obligatoire.',
            'date.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
            'time.required' => 'L\'heure de réservation est obligatoire.',
            'items.required' => 'Vous devez sélectionner au moins un service.',
            'items.min' => 'Vous devez sélectionner au moins un service.',
            'items.*.service_id.required' => 'Chaque item doit avoir un service valide.',
            'items.*.service_id.exists' => 'Le service sélectionné n\'existe pas.',
            'items.*.staff_id.exists' => 'Le praticien sélectionné n\'existe pas.',
            'items.*.options.*.option_id.exists' => 'Une option sélectionnée n\'existe pas.',
        ];
    }

    /**
     * Validation personnalisée supplémentaire
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            
            foreach ($items as $index => $item) {
                // Vérifier que les options appartiennent bien au service
                if (!empty($item['options'])) {
                    $serviceId = $item['service_id'] ?? null;
                    $optionIds = collect($item['options'])->pluck('option_id')->filter();
                    
                    if ($serviceId && $optionIds->isNotEmpty()) {
                        $validOptions = \App\Models\ServiceOption::where('service_id', $serviceId)
                            ->whereIn('id', $optionIds)
                            ->where('available', true)
                            ->pluck('id');
                        
                        $invalidOptions = $optionIds->diff($validOptions);
                        if ($invalidOptions->isNotEmpty()) {
                            $validator->errors()->add(
                                "items.{$index}.options",
                                "Certaines options ne sont pas valides pour ce service."
                            );
                        }
                    }
                }
                
                // Vérifier que le service est disponible
                if (!empty($item['service_id'])) {
                    $service = \App\Models\Service::find($item['service_id']);
                    if ($service && !$service->available) {
                        $validator->errors()->add(
                            "items.{$index}.service_id",
                            "Le service '{$service->name}' n'est pas disponible actuellement."
                        );
                    }
                }
            }
        });
    }
}
