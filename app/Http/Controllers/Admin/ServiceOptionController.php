<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use Illuminate\Http\Request;

class ServiceOptionController extends Controller
{
    /**
     * Afficher les options d'un service
     */
    public function index(Service $service)
    {
        $options = $service->options()->orderBy('sort_order')->get();
        return view('admin.service-options.index', compact('service', 'options'));
    }

    /**
     * Formulaire de création d'une option
     */
    public function create(Service $service)
    {
        return view('admin.service-options.create', compact('service'));
    }

    /**
     * Enregistrer une nouvelle option
     */
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:0'],
            'is_required' => ['boolean'],
            'available' => ['boolean'],
            'max_quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['service_id'] = $service->id;
        $validated['is_required'] = $request->has('is_required');
        $validated['available'] = $request->has('available');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        ServiceOption::create($validated);

        return redirect()
            ->route('admin.services.options.index', $service)
            ->with('success', 'Option créée avec succès.');
    }

    /**
     * Formulaire d'édition d'une option
     */
    public function edit(Service $service, ServiceOption $option)
    {
        // Vérifier que l'option appartient bien au service
        if ($option->service_id !== $service->id) {
            abort(404);
        }

        return view('admin.service-options.edit', compact('service', 'option'));
    }

    /**
     * Mettre à jour une option
     */
    public function update(Request $request, Service $service, ServiceOption $option)
    {
        // Vérifier que l'option appartient bien au service
        if ($option->service_id !== $service->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:0'],
            'is_required' => ['boolean'],
            'available' => ['boolean'],
            'max_quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['is_required'] = $request->has('is_required');
        $validated['available'] = $request->has('available');

        $option->update($validated);

        return redirect()
            ->route('admin.services.options.index', $service)
            ->with('success', 'Option mise à jour avec succès.');
    }

    /**
     * Supprimer une option
     */
    public function destroy(Service $service, ServiceOption $option)
    {
        // Vérifier que l'option appartient bien au service
        if ($option->service_id !== $service->id) {
            abort(404);
        }

        $option->delete();

        return redirect()
            ->route('admin.services.options.index', $service)
            ->with('success', 'Option supprimée avec succès.');
    }
}
