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
    public static string $label = "Achat d'Or Local";

    
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
        ->column('supplier.name', 'Fournisseur') 
        ->column('purchase_date', "Date d'Achat")
        ->column('payment_status', 'Status Payement ')
        ->column('agent.name', 'Nom Agent')
        ->column('receipt_reference', 'Référence du Reçu')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    // Dans votre contrôleur
    public static function show($id): \Inertia\Response
    {
        $relations = array_merge(static::$model::relationsToLoad(), [
            'baremeDesignationCarat',
            'supplier',
            'agent',
            'items' // Charger les items associés
        ]);
        
        $localgoldpurchase = static::$model::with($relations)->findOrFail($id);

        return Inertia::render(static::getComponentPath('show'), [
            'localgoldpurchase' => $localgoldpurchase,
            'resource' => static::getResourceData($localgoldpurchase),
            'baremeOptions' => BaremeDesignationCarat::all(), // Pour les calculs de carat
        ]);
    }
    
    
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
            ->field('supplier_id', 'select', [
                'options' => Supplier::pluck('name', 'id'),
                'required' => true
            ])
            ->field('purchase_date', 'date', ['required' => true])
            ->field('payment_status', 'select', [
                'required' => true,
                'options' => [
                    'pending' => 'pending',
                    'paid' => 'paid'
                ],
            ])
            ->field('agent_id', 'select', [
                'options' => User::pluck('name', 'id'),
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
            'purchase_date' => 'date|required',
            'payment_status' => 'string|required|in:pending,paid',
            'agent_id' => 'required|exists:users,id',
            'receipt_reference' => 'string|required|max:255',
            'items' => 'required|array|min:1',
            'items.*.weight_grams_min' => 'required|numeric|min:0',
            'items.*.weight_grams_max' => 'required|numeric|min:0|gt:items.*.weight_grams_min',
            'items.*.densite' => 'required|numeric|min:0',
            'items.*.bareme_designation_carat_id' => 'required|exists:bareme_designation_carats,id',
            'items.*.purity_estimated' => 'required|numeric|min:0|max:100',
            'items.*.price_per_gram_local' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
            'items.*.local_rate' => 'required|numeric|min:0',
        ], [
            'items.*.weight_grams_max.gt' => 'Le poids à l\'air doit être supérieur au poids à l\'eau',
            'items.required' => 'Au moins un article est requis',
            'items.*.required' => 'Tous les champs de l\'article sont obligatoires',
        ]);
    
        $purchase = LocalGoldPurchase::create($data);
    
        foreach ($data['items'] as $item) {
            $purchase->items()->create($item);
        }
    
        return redirect()->route(static::getRouteName('index'))
            ->with('success', 'Achat enregistré avec succès');
    }

    public static function edit($id): \Inertia\Response
    {
        $localgoldpurchase = static::$model::with('items')->findOrFail($id);

        $form = (new FormBuilder())
            ->field('supplier_id', 'select', [
                'options' => Supplier::pluck('name', 'id'),
                'value' => $localgoldpurchase->supplier_id,
                'required' => true
            ])
            ->field('purchase_date', 'date', [
                'required' => true,
                'value' => $localgoldpurchase->purchase_date
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
            'baremeOptions' => BaremeDesignationCarat::all()->toArray(),
            'localRateOptions' => LocalRate::latest()->first() ? [LocalRate::latest()->first()->id => LocalRate::latest()->first()->rate_per_gram] : [],
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $localgoldpurchase = static::$model::findOrFail($id);

        $data = request()->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'date|required',
            'payment_status' => 'string|required|in:pending,paid',
            'agent_id' => 'required|exists:users,id',
            'receipt_reference' => 'string|required|max:255',
            'items' => 'required|array|min:1',
            'items.*.weight_grams_min' => 'required|numeric|min:0',
            'items.*.weight_grams_max' => 'required|numeric|min:0|gt:items.*.weight_grams_min',
            'items.*.densite' => 'required|numeric|min:0',
            'items.*.bareme_designation_carat_id' => 'required|exists:bareme_designation_carats,id',
            'items.*.purity_estimated' => 'required|numeric|min:0|max:100',
            'items.*.price_per_gram_local' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
            'items.*.local_rate' => 'required|numeric|min:0',
        ], [
            'items.*.weight_grams_max.gt' => 'Le poids à l\'air doit être supérieur au poids à l\'eau',
            'items.required' => 'Au moins un article est requis',
            'items.*.required' => 'Tous les champs de l\'article sont obligatoires',
        ]);
        // Mettre à jour l'achat principal
        $localgoldpurchase->update($data);

        // Gérer les items (création, mise à jour, suppression)
        $existingItems = $localgoldpurchase->items()->pluck('id')->toArray();
        $updatedItems = [];

        foreach ($data['items'] as $item) {
            if (isset($item['id'])) {
                // Mise à jour d'un item existant
                $localgoldpurchase->items()->where('id', $item['id'])->update($item);
                $updatedItems[] = $item['id'];
            } else {
                // Création d'un nouvel item
                $newItem = $localgoldpurchase->items()->create($item);
                $updatedItems[] = $newItem->id;
            }
        }

        // Supprimer les items qui ne sont plus dans la liste
        $itemsToDelete = array_diff($existingItems, $updatedItems);
        if (!empty($itemsToDelete)) {
            $localgoldpurchase->items()->whereIn('id', $itemsToDelete)->delete();
        }

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


 