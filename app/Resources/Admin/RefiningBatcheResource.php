<?php

namespace App\Resources\Admin;

use App\Models\RefiningBatche;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\User;
use App\Models\GoldInventory;

class RefiningBatcheResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = RefiningBatche::class;
    protected static string $panel = 'admin';
    public static string $label = 'Refining Batche';

    
    public static function responsibleOptions(): array
    {
        return User::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function inventoryOptions(): array
    {
        return GoldInventory::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('batch_code', 'Batch Code')
        ->column('total_weight_input', 'Total Weight Input')
        ->column('estimated_loss', 'Estimated Loss')
        ->column('refined_weight_output', 'Refined Weight Output')
        ->column('refined_purity', 'Refined Purity')
        ->column('refining_date', 'Refining Date')
        ->column('responsible.name', 'Responsible')
        ->column('status', 'Status')
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
        ->field('batch_code', 'text', ['required' => true])
        ->field('total_weight_input', 'text', ['required' => true])
        ->field('estimated_loss', 'text', ['required' => true])
        ->field('refined_weight_output', 'text', ['required' => true])
        ->field('refined_purity', 'text', ['required' => true])
        ->field('refining_date', 'date', ['required' => true])
        ->field('responsible_id', 'select', [
                        'options' => \App\Models\User::pluck('name', 'id'),
                        'required' => true
                    ])
        ->field('status', 'select', [
            'options' => [
                'pending' => 'pending',
                'processed' => 'processed'
            ],
            'required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'batch_code' => 'string|required',
            'total_weight_input' => 'string|required',
            'estimated_loss' => 'string|required',
            'refined_weight_output' => 'string|required',
            'refined_purity' => 'string|required',
            'refining_date' => 'date|required',
            'responsible_id' => 'required|exists:users,id',
            'status' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $refiningbatche = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('batch_code', 'text', [
                        'required' => true,
                        'value' => $refiningbatche->batch_code
                    ])
        ->field('total_weight_input', 'text', [
                        'required' => true,
                        'value' => $refiningbatche->total_weight_input
                    ])
        ->field('estimated_loss', 'text', [
                        'required' => true,
                        'value' => $refiningbatche->estimated_loss
                    ])
        ->field('refined_weight_output', 'text', [
                        'required' => true,
                        'value' => $refiningbatche->refined_weight_output
                    ])
        ->field('refined_purity', 'text', [
                        'required' => true,
                        'value' => $refiningbatche->refined_purity
                    ])
        ->field('refining_date', 'date', [
                        'required' => true,
                        'value' => $refiningbatche->refining_date
                    ])
        ->field('responsible_id', 'select', [
                        'options' => \App\Models\User::pluck('name', 'id'),
                        'value' => $refiningbatche->responsible_id,
                        'required' => true
                    ])
        ->field('status', 'select', [
            'options' => [
                'pending' => 'pending',
                'processed' => 'processed'
                    ],
                    'required' => true,])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'refiningbatche' => $refiningbatche,
            'form' => $form,
            'resource' => static::getResourceData($refiningbatche),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $refiningbatche = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'batch_code' => 'string|required',
            'total_weight_input' => 'string|required',
            'estimated_loss' => 'string|required',
            'refined_weight_output' => 'string|required',
            'refined_purity' => 'string|required',
            'refining_date' => 'date|required',
            'responsible_id' => 'required|exists:users,id',
            'status' => 'string|required',
            
        ]);
    
        $refiningbatche->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $refiningbatche = static::$model::findOrFail($id);
        $refiningbatche->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}