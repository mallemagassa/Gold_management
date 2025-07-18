<?php

namespace App\Resources\Admin;

use App\Models\BaremeDesignationCarat;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\LocalGoldPurchase;

class BaremeDesignationCaratResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = BaremeDesignationCarat::class;
    protected static string $panel = 'admin';
    public static string $label = "Désignation Bareme Carat";

    
    public static function achatsOptions(): array
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
        ->column('carat', 'Carat')
        ->column('density_min', 'Density Min')
        ->column('density_max', 'Density Max')
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
        ->field('carat', 'text', ['required' => true])
        ->field('density_min', 'text', ['required' => true])
        ->field('density_max', 'text', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'carat' => 'string|required',
            'density_min' => 'string|required',
            'density_max' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $baremedesignationcarat = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('carat', 'text', [
                        'required' => true,
                        'value' => $baremedesignationcarat->carat
                    ])
        ->field('density_min', 'text', [
                        'required' => true,
                        'value' => $baremedesignationcarat->density_min
                    ])
        ->field('density_max', 'text', [
                        'required' => true,
                        'value' => $baremedesignationcarat->density_max
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'baremedesignationcarat' => $baremedesignationcarat,
            'form' => $form,
            'resource' => static::getResourceData($baremedesignationcarat),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $baremedesignationcarat = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'carat' => 'string|required',
            'density_min' => 'string|required',
            'density_max' => 'string|required',
            
        ]);
    
        $baremedesignationcarat->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $baremedesignationcarat = static::$model::findOrFail($id);
        $baremedesignationcarat->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}