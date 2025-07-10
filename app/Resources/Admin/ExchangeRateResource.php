<?php

namespace App\Resources\Admin;

use App\Models\ExchangeRate;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;


class ExchangeRateResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = ExchangeRate::class;
    protected static string $panel = 'admin';
    public static string $label = 'Exchange Rate';

    

    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('from_currency', 'From Currency')
        ->column('to_currency', 'To Currency')
        ->column('rate', 'Rate')
        ->column('date', 'Date')
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
        ->field('from_currency', 'text', ['required' => true])
        ->field('to_currency', 'text', ['required' => true])
        ->field('rate', 'text', ['required' => true])
        ->field('date', 'date', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'from_currency' => 'string|required',
            'to_currency' => 'string|required',
            'rate' => 'string|required',
            'date' => 'date|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $exchangerate = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('from_currency', 'text', [
                        'required' => true,
                        'value' => $exchangerate->from_currency
                    ])
        ->field('to_currency', 'text', [
                        'required' => true,
                        'value' => $exchangerate->to_currency
                    ])
        ->field('rate', 'text', [
                        'required' => true,
                        'value' => $exchangerate->rate
                    ])
        ->field('date', 'date', [
                        'required' => true,
                        'value' => $exchangerate->date
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'exchangerate' => $exchangerate,
            'form' => $form,
            'resource' => static::getResourceData($exchangerate),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $exchangerate = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'from_currency' => 'string|required',
            'to_currency' => 'string|required',
            'rate' => 'string|required',
            'date' => 'date|required',
            
        ]);
    
        $exchangerate->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $exchangerate = static::$model::findOrFail($id);
        $exchangerate->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}