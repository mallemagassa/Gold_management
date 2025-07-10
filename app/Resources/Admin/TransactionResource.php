<?php

namespace App\Resources\Admin;

use App\Models\Transaction;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\User;

class TransactionResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = Transaction::class;
    protected static string $panel = 'admin';
    public static string $label = 'Transaction';

    
    public static function creatorOptions(): array
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
        ->column('type', 'Type')
        ->column('reference_id', 'Reference Id')
        ->column('description', 'Description')
        ->column('amount', 'Amount')
        ->column('currency', 'Currency')
        ->column('exchange_rate_used', 'Exchange Rate Used')
        ->column('date', 'Date')
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
        ->field('type', 'select', [
            'options' => [
                'achat_local' => 'achat_local', 
                'traitement' => 'traitement',
                'transport' => 'transport', 
                'vente' => 'vente'
            ],
            'required' => true
        ])
        ->field('reference_id', 'number', ['required' => true])
        ->field('description', 'textarea', ['required' => true])
        ->field('amount', 'text', ['required' => true])
        ->field('currency', 'text', ['required' => true])
        ->field('exchange_rate_used', 'text', ['required' => true])
        ->field('date', 'date', ['required' => true])
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
            'type' => 'string|required',
            'reference_id' => 'integer|required',
            'description' => 'string|required',
            'amount' => 'string|required',
            'currency' => 'string|required',
            'exchange_rate_used' => 'string|required',
            'date' => 'date|required',
            'created_by' => 'integer|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $transaction = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('type', 'select', [
            'options' => [
                'achat_local' => 'achat_local', 
                'traitement' => 'traitement',
                'transport' => 'transport', 
                'vente' => 'vente'
            ],
            'required' => true
        ])
        ->field('reference_id', 'number', [
                        'required' => true,
                        'value' => $transaction->reference_id
                    ])
        ->field('description', 'textarea', [
                        'required' => true,
                        'value' => $transaction->description
                    ])
        ->field('amount', 'text', [
                        'required' => true,
                        'value' => $transaction->amount
                    ])
        ->field('currency', 'text', [
                        'required' => true,
                        'value' => $transaction->currency
                    ])
        ->field('exchange_rate_used', 'text', [
                        'required' => true,
                        'value' => $transaction->exchange_rate_used
                    ])
        ->field('date', 'date', [
                        'required' => true,
                        'value' => $transaction->date
                    ])
        ->field('created_by', 'select', [
                        'options' => User::pluck('name', 'id'),
                        'required' => true 
                        
                        ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'transaction' => $transaction,
            'form' => $form,
            'resource' => static::getResourceData($transaction),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $transaction = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'type' => 'string|required',
            'reference_id' => 'integer|required',
            'description' => 'string|required',
            'amount' => 'string|required',
            'currency' => 'string|required',
            'exchange_rate_used' => 'string|required',
            'date' => 'date|required',
            'created_by' => 'integer|required',
            
        ]);
    
        $transaction->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $transaction = static::$model::findOrFail($id);
        $transaction->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}