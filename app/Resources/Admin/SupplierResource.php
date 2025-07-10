<?php

namespace App\Resources\Admin;

use App\Models\Supplier;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;


class SupplierResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = Supplier::class;
    protected static string $panel = 'admin';
    public static string $label = 'Fournisseurs';

    

    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('name', 'Name')
        ->column('type', 'Type')
        ->column('contact_info', 'Contact Info')
        ->column('identification_number', 'Identification Number')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function show($id): \Inertia\Response
    {
        $application = static::$model::with(array_keys((new static::$model)->getRelations()))
            ->findOrFail($id);
    
        return Inertia::render(static::getComponentPath('show'), [
            'application' => $application->loadMissing(array_keys($application->getRelations())),
            'resource' => static::getResourceData($application),
        ]);
    }
    
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
        ->field('name', 'text', ['required' => true])
        ->field('type', 'select', [
            'options' => [
                'orpailleur_individuel' => 'orpailleur_individuel', 
                'cooperative' => 'cooperative',
                'intermediaire' => 'intermediaire', 
            ],'required' => true]) //['orpailleur_individuel', 'cooperative', 'intermediaire']
        ->field('contact_info', 'textarea', ['required' => true])
        ->field('identification_number', 'text', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'name' => 'string|required',
            'type' => 'string|required',
            'contact_info' => 'string|required',
            'identification_number' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $supplier = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('name', 'text', [
                        'required' => true,
                        'value' => $supplier->name
                    ])
        ->field('type', 'text', [
                        'required' => true,
                        'value' => $supplier->type
                    ])
        ->field('contact_info', 'textarea', [
                        'required' => true,
                        'value' => $supplier->contact_info
                    ])
        ->field('identification_number', 'text', [
                        'required' => true,
                        'value' => $supplier->identification_number
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'supplier' => $supplier,
            'form' => $form,
            'resource' => static::getResourceData($supplier),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $supplier = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'name' => 'string|required',
            'type' => 'string|required',
            'contact_info' => 'string|required',
            'identification_number' => 'string|required',
            
        ]);
    
        $supplier->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $supplier = static::$model::findOrFail($id);
        $supplier->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}