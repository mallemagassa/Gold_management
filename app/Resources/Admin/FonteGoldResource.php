<?php

namespace App\Resources\Admin;

use App\Models\FonteGold;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\LocalRate;
use App\Models\BaremeDesignationCarat;

class FonteGoldResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = FonteGold::class;
    protected static string $panel = 'admin';
    public static string $label = "Fonte d'Or";

    
    public static function localRateOptions(): array
    {
        return LocalRate::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function baremeDesignationCaratOptions(): array
    {
        return BaremeDesignationCarat::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('weight_grams_min', 'Weight Grams Min')
        ->column('weight_grams_max', 'Weight Grams Max')
        ->column('densite', 'Densite')
        ->column('purity_estimated', 'Purity Estimated')
        ->column('price_per_gram_local', 'Price Per Gram Local')
        ->column('total_price', 'Total Price')
        ->column('fonte_date', 'Fonte Date')
        ->column('local_rate_id', 'Local Rate Id')
        ->column('bareme_designation_carat_id', 'Bareme Designation Carat Id')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function show($id): \Inertia\Response
{
    $fontegold = static::$model::with(static::$model::relationsToLoad())->findOrFail($id);

    return Inertia::render(static::getComponentPath('show'), [
        'fontegold' => $fontegold,
        'resource' => static::getResourceData($fontegold),
    ]);
}
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
            ->field('weight_grams_min', 'number', ['required' => true])
            ->field('weight_grams_max', 'number', ['required' => true])
            ->field('densite', 'number', ['readonly' => true])
            ->field('bareme_designation_carat_id', 'select', [
                'options' => BaremeDesignationCarat::pluck('carat', 'id'),
                'required' => true
            ])
            ->field('purity_estimated', 'number', ['readonly' => true])
            ->field('price_per_gram_local', 'number', ['readonly' => true])
            ->field('total_price', 'number', ['readonly' => true])
            ->field('fonte_date', 'date', ['required' => true])
            ->field('local_rate_id', 'select', [
                'options' =>function() {
                $latest = LocalRate::latest()->first();
                return $latest ? [$latest->id => $latest->rate_per_gram] : [];
            },
                'required' => true
            ])
            ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
            'baremeOptions' => BaremeDesignationCarat::all()->toArray()
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        // dd(request());
        $data = request()->validate([
            'weight_grams_min' => 'numeric|required',
            'weight_grams_max' => 'numeric|required',
            'densite' => 'numeric|required',
            'purity_estimated' => 'numeric|required',
            'price_per_gram_local' => 'numeric|required',
            'total_price' => 'numeric|required',
            'fonte_date' => 'date|required',
            'local_rate_id' => 'integer|required',
            'bareme_designation_carat_id' => 'integer|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $fontegold = static::$model::with(static::$model::relationsToLoad())->findOrFail($id);
    
        $form = (new FormBuilder())
            ->field('weight_grams_min', 'number', [
                'required' => true,
                'value' => $fontegold->weight_grams_min
            ])
            ->field('weight_grams_max', 'number', [
                'required' => true,
                'value' => $fontegold->weight_grams_max
            ])
            ->field('densite', 'number', [
                'required' => true,
                'value' => $fontegold->densite,
                'readonly' => true
            ])
            ->field('bareme_designation_carat_id', 'select', [
                'options' => BaremeDesignationCarat::pluck('carat', 'id'),
                'value' => $fontegold->bareme_designation_carat_id,
                'required' => true
            ])
            ->field('purity_estimated', 'number', [
                'required' => true,
                'value' => $fontegold->purity_estimated,
                'readonly' => true
            ])
            ->field('price_per_gram_local', 'number', [
                'required' => true,
                'value' => $fontegold->price_per_gram_local,
                'readonly' => true
            ])
            ->field('total_price', 'number', [
                'required' => true,
                'value' => $fontegold->total_price,
                'readonly' => true
            ])
            ->field('fonte_date', 'date', [
                'required' => true,
                'value' => $fontegold->fonte_date //->format('Y-m-d')
            ])
            ->field('local_rate_id', 'select', [
                'options' =>function() {
                $latest = LocalRate::latest()->first();
                return $latest ? [$latest->id => $latest->rate_per_gram] : [];
            },
                'value' => $fontegold->local_rate_id,
                'required' => true
            ])
            ->make();
    
        return Inertia::render(static::getComponentPath('edit'), [
            'fontegold' => $fontegold,
            'form' => $form,
            'resource' => static::getResourceData($fontegold),
            'baremeOptions' => BaremeDesignationCarat::all()->toArray()
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $fontegold = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'weight_grams_min' => 'numeric|required',
            'weight_grams_max' => 'numeric|required',
            'densite' => 'numeric|required',
            'purity_estimated' => 'numeric|required',
            'price_per_gram_local' => 'numeric|required',
            'total_price' => 'numeric|required',
            'fonte_date' => 'date|required',
            'local_rate_id' => 'integer|required',
            'bareme_designation_carat_id' => 'integer|required',
            
        ]);
    
        $fontegold->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $fontegold = static::$model::findOrFail($id);
        $fontegold->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}