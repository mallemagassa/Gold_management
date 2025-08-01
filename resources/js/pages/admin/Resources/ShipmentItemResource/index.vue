<!--- index.vue.stub -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import KizzaTable from '@/components/ui/data-table/KizzaTable.vue';
import type { ColumnDef } from '@tanstack/vue-table';
import { computed, h } from 'vue'
import { Checkbox } from '@/components/ui/checkbox'
import DropdownAction from '@/components/ui/data-table/DataTableDemoColumn.vue'
import Button from '@/components/ui/button/Button.vue';
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next'

interface ShipmentItem {
shipment_id: number;
  inventory_id: number;
  weight: string;
}

const props = defineProps({
  table: {
    type: Object as () => {
      records: {
        data: ShipmentItem[]
      }
      columns: ColumnDef<ShipmentItem>[]
    },
    required: true
  },
  resource: {
    type: Object as () => {
      label: string
      routes: {
        edit: string
        destroy: string
        index: string
        create: string
        show: string
      }
      relations?: Record<string, any>
    },
    required: true
  }
});

const formattedColumns = computed(() => {
  const defaultSelectColumn = {
    id: 'select',
    header: ({ table }) =>
      h(Checkbox, {
        modelValue: table.getIsAllPageRowsSelected() || 
          (table.getIsSomePageRowsSelected() && 'indeterminate'),
        'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
        ariaLabel: 'Select all',
      }),
    cell: ({ row }) =>
      h(Checkbox, {
        modelValue: row.getIsSelected(),
        'onUpdate:modelValue': value => row.toggleSelected(!!value),
        ariaLabel: 'Select row',
      }),
    enableSorting: false,
    enableHiding: false,
  };

  const dynamicColumns = Object.entries(props.table.columns).map(([key, label]) => {
      // Remplacer les underscores par des points pour l'accès aux données
      const originalKey = key.replace(/_/g, '.');
      const isRelation = originalKey.includes('.');
      
      return {
          accessorKey: key, // Utiliser la clé transformée (avec underscore)
          header: ({ column }) =>
              h(Button, {
                  variant: 'ghost',
                  onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
              }, () => [label, h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]),
          cell: ({ row }) => {
              if (isRelation) {
                  return row.original[key] || 'N/A';
              }
              return row.getValue(key);
          },
      };
  });

   const defaultActionsColumn = {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
    const payment = row.original
    return h(DropdownAction, {
        payment,
        routes: {
        edit: props.resource.routes.edit,
        destroy: props.resource.routes.destroy,
        index: props.resource.routes.index,
        show: props.resource.routes.show
        },
        onExpand: row.toggleExpanded
    })
    }

  }

  return [defaultSelectColumn, ...dynamicColumns, defaultActionsColumn];
});
</script>

<template>
  <Head :title="resource.label" />
  <AppLayout>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ resource.label }}</h1>
        <Link :href="resource.routes.create">
          <Button variant="default">
            Créer {{ resource.label }}
          </Button>
        </Link>
      </div>
      <KizzaTable 
        :data="table.records.data"
        :columns="formattedColumns"
        :routes="resource.routes"
      />
    </div>
  </AppLayout>
</template>