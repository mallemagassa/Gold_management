<?php

namespace App\Resources\Admin;

use App\Models\GoldMarketPrice;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;


class GoldMarketPriceResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = GoldMarketPrice::class;
    protected static string $panel = 'admin';
    public static string $label = 'Gold Market Price';

    

    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('date', 'Date')
        ->column('price_per_gram_usd', 'Price Per Gram Usd')
        ->column('source', 'Source')
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
        ->field('date', 'date', ['required' => true])
        ->field('price_per_gram_usd', 'text', ['required' => true])
        ->field('source', 'text', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'date' => 'date|required',
            'price_per_gram_usd' => 'string|required',
            'source' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $goldmarketprice = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('date', 'date', [
                        'required' => true,
                        'value' => $goldmarketprice->date
                    ])
        ->field('price_per_gram_usd', 'text', [
                        'required' => true,
                        'value' => $goldmarketprice->price_per_gram_usd
                    ])
        ->field('source', 'text', [
                        'required' => true,
                        'value' => $goldmarketprice->source
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'goldmarketprice' => $goldmarketprice,
            'form' => $form,
            'resource' => static::getResourceData($goldmarketprice),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $goldmarketprice = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'date' => 'date|required',
            'price_per_gram_usd' => 'string|required',
            'source' => 'string|required',
            
        ]);
    
        $goldmarketprice->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $goldmarketprice = static::$model::findOrFail($id);
        $goldmarketprice->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}