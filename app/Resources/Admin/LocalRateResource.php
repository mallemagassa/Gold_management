<?php

namespace App\Resources\Admin;

use App\Models\LocalRate;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\User;
use App\Models\LocalGoldPurchase;

class LocalRateResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = LocalRate::class;
    protected static string $panel = 'admin';
    public static string $label = 'Local Rate';

    
    public static function creatorOptions(): array
    {
        return User::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function purchasesOptions(): array
    {
        return LocalGoldPurchase::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->orderBy('effective_date', 'desc')
        ->column('rate_per_gram', 'Rate Per Gram')
        ->column('currency', 'Currency')
        ->column('effective_date', 'Effective Date')
        ->column('creator.name', 'Created By')
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
        ->field('rate_per_gram', 'text', ['required' => true])
        ->field('currency', 'text', ['required' => true])
        ->field('effective_date', 'date', ['required' => true])
        ->field('created_by', 'select', [
            'options' => User::pluck('name', 'id'),
            'required' => true 
            
            ])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'rate_per_gram' => 'string|required',
            'currency' => 'string|required',
            'effective_date' => 'date|required',
            'created_by' => 'integer|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $localrate = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('rate_per_gram', 'text', [
                        'required' => true,
                        'value' => $localrate->rate_per_gram
                    ])
        ->field('currency', 'text', [
                        'required' => true,
                        'value' => $localrate->currency
                    ])
        ->field('effective_date', 'date', [
                        'required' => true,
                        'value' => $localrate->effective_date
                    ])
        ->field('created_by', 'select', [
                        'options' => User::pluck('name', 'id'),
                        'required' => true 
                        
                        ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'localrate' => $localrate,
            'form' => $form,
            'resource' => static::getResourceData($localrate),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $localrate = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'rate_per_gram' => 'string|required',
            'currency' => 'string|required',
            'effective_date' => 'date|required',
            'created_by' => 'integer|required',
            
        ]);
    
        $localrate->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $localrate = static::$model::findOrFail($id);
        $localrate->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}