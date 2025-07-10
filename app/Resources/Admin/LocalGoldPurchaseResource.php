<?php

namespace App\Resources\Admin;

use App\Models\BaremeDesignationCarat;
use App\Models\LocalGoldPurchase;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\Supplier;
use App\Models\LocalRate;
use App\Models\User;

class LocalGoldPurchaseResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = LocalGoldPurchase::class;
    protected static string $panel = 'admin';
    public static string $label = 'Local Gold Purchase';

    
    public static function supplierOptions(): array
    {
        return Supplier::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function localRateOptions(): array
    {
        return LocalRate::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function agentOptions(): array
    {
        return User::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('supplier.name', 'Supplier') 
        ->column('weight_grams_max', 'Max')
        ->column('weight_grams_min', 'Min')
        ->column('purity_estimated', 'Purity Estimated')
        ->column('price_per_gram_local', 'Price Per Gram Local')
        ->column('total_price', 'Total Price')
        ->column('purchase_date', 'Purchase Date')
        ->column('localRate.rate_per_gram', 'Local Rate Id')
        ->column('payment_status', 'Payment Status')
        ->column('agent.name', 'Agent')
        ->column('receipt_reference', 'Receipt Reference')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function show($id): \Inertia\Response
    {
        $relations = array_merge(static::$model::relationsToLoad(), [
            'baremeDesignationCarat',
            'localRate',
            'supplier',
            'agent'
        ]);
        
        $localgoldpurchase = static::$model::with($relations)->findOrFail($id);
    
        return Inertia::render(static::getComponentPath('show'), [
            'localgoldpurchase' => $localgoldpurchase,
            'resource' => static::getResourceData($localgoldpurchase),
        ]);
    }
    
    
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
        ->field('supplier_id', 'select', [
                        'options' => Supplier::pluck('name', 'id'),
                        'required' => true
                    ])
        ->field('weight_grams_min', 'number', ['required' => true])
        ->field('weight_grams_max', 'number', ['required' => true])
        ->field('densite', 'number', ['required' => true])
        // ->field('bareme_designation_carat_id', 'select', [
        //     'options' => BaremeDesignationCarat::pluck('carat', 'id'),
        //     'required' => true
        // ])
        ->field('purity_estimated', 'text', ['required' => true])
        ->field('price_per_gram_local', 'text', ['required' => true])
        ->field('total_price', 'text', ['required' => true])
        ->field('purchase_date', 'date', ['required' => true])
        // ->field('local_rate_id', 'number', ['required' => true])
        ->field('local_rate_id', 'select', [
            'options' => LocalRate::pluck('rate_per_gram', 'id'),
            'required' => true
        ])
        ->field('payment_status', 'select', ['required' => true,
                            'options' => [
                            'pending' => 'pending',
                            'paid' => 'paid'
                                    ],])
        ->field('agent_id', 'select', [
                        'options' => \App\Models\User::pluck('name', 'id'),
                        'required' => true
                    ])
        ->field('receipt_reference', 'text', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'baremeOptions' => BaremeDesignationCarat::all()->toArray(),
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'weight_grams_min' => 'numeric|required',
            'weight_grams_max' => 'numeric|required',
            'densite' => 'numeric|required',
            'purity_estimated' => 'string|required',
            'price_per_gram_local' => 'string|required',
            'total_price' => 'string|required',
            'purchase_date' => 'date|required',
            'local_rate_id' => 'integer|required',
            'bareme_designation_carat_id' => 'integer|required',
            'payment_status' => 'string|required',
            'agent_id' => 'required|exists:users,id',
            'receipt_reference' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $localgoldpurchase = static::$model::findOrFail($id);
    
        $form = (new FormBuilder())
            ->field('supplier_id', 'select', [
                'options' => Supplier::pluck('name', 'id'),
                'value' => $localgoldpurchase->supplier_id,
                'required' => true
            ])
            ->field('weight_grams_min', 'number', [
                'required' => true,
                'value' => $localgoldpurchase->weight_grams_min
            ])
            ->field('weight_grams_max', 'number', [
                'required' => true,
                'value' => $localgoldpurchase->weight_grams_max
            ])
            ->field('densite', 'number', [
                'required' => true,
                'value' => $localgoldpurchase->densite
            ])
            ->field('bareme_designation_carat_id', 'select', [
                'options' => BaremeDesignationCarat::pluck('carat', 'id'),
                'value' => $localgoldpurchase->bareme_designation_carat_id,
                'required' => true
            ])
            ->field('purity_estimated', 'text', [
                'required' => true,
                'value' => $localgoldpurchase->purity_estimated
            ])
            ->field('price_per_gram_local', 'text', [
                'required' => true,
                'value' => $localgoldpurchase->price_per_gram_local
            ])
            ->field('total_price', 'text', [
                'required' => true,
                'value' => $localgoldpurchase->total_price
            ])
            ->field('purchase_date', 'date', [
                'required' => true,
                'value' => $localgoldpurchase->purchase_date//->format('Y-m-d')
            ])
            ->field('local_rate_id', 'select', [
                'options' => LocalRate::pluck('rate_per_gram', 'id'),
                'value' => $localgoldpurchase->local_rate_id,
                'required' => true
            ])
            ->field('payment_status', 'select', [
                'required' => true,
                'value' => $localgoldpurchase->payment_status,
                'options' => [
                    'pending' => 'En attente',
                    'paid' => 'Payé'
                ],
            ])
            ->field('agent_id', 'select', [
                'options' => \App\Models\User::pluck('name', 'id'),
                'value' => $localgoldpurchase->agent_id,
                'required' => true
            ])
            ->field('receipt_reference', 'text', [
                'required' => true,
                'value' => $localgoldpurchase->receipt_reference
            ])
            ->make();
    
        return Inertia::render(static::getComponentPath('edit'), [
            'localgoldpurchase' => $localgoldpurchase,
            'form' => $form,
            'resource' => static::getResourceData($localgoldpurchase),
            'baremeOptions' => BaremeDesignationCarat::all()->toArray()
        ]);
    }
    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $localgoldpurchase = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'weight_grams_min' => 'numeric|required',
            'weight_grams_max' => 'numeric|required',
            'densite' => 'numeric|required',
            'purity_estimated' => 'string|required',
            'price_per_gram_local' => 'string|required',
            'total_price' => 'string|required',
            'purchase_date' => 'date|required',
            'local_rate_id' => 'integer|required',
            'payment_status' => 'string|required',
            'bareme_designation_carat_id' => 'integer|required',
            'agent_id' => 'required|exists:users,id',
            'receipt_reference' => 'string|required',
            
        ]);
    
        $localgoldpurchase->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $localgoldpurchase = static::$model::findOrFail($id);
        $localgoldpurchase->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}