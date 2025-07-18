<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import { Link } from '@inertiajs/vue3'


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tableau de Bord',
    href: '/dashboard',
  },
];

const props = defineProps({
  recentSales: Object,
  recentPurchasesLocal: Object,
})

console.log(props.recentPurchasesLocal);



const stats = [
  { title: 'Stock Total d’Or', value: '89,2 g', trend: 'up' },
  { title: 'Avg Purchase Price', value: '32,400 XOF/g', trend: 'stable' },
  { title: 'Ventes Mensuelles', value: '108,9 g', trend: 'up' },
];

function formatDate(dateString: string): string {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  }).format(date)
}

</script>

<template>
  <Head title="Tableau de Bord" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <h1 class="text-2xl font-bold">Yiriwa Gold</h1>

      <!-- Widgets de statistiques -->
      <div class="grid gap-4 md:grid-cols-3">
        <div 
          v-for="(stat, index) in stats" 
          :key="index"
          class="rounded-xl border bg-card p-6 shadow-sm"
        >
          <h3 class="text-sm font-medium text-muted-foreground">{{ stat.title }}</h3>
          <p class="mt-2 text-2xl font-bold">{{ stat.value }}</p>
          <div class="mt-2 flex items-center text-sm">
            <span 
              :class="{
                'text-green-500': stat.trend === 'up',
                'text-yellow-500': stat.trend === 'stable',
                'text-red-500': stat.trend === 'down'
              }"
            >
              {{ stat.trend === 'up' ? '↑' : stat.trend === 'stable' ? '→' : '↓' }}
              {{ stat.trend === 'up' ? 'Up' : stat.trend === 'stable' ? 'Stable' : 'Down' }}
            </span>
          </div>
        </div>
      </div>

      <!-- Section Purchases -->
      <div class="rounded-xl border bg-card p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold">Achats récentes</h2>
          <Button variant="outline" as-child>
            <Link :href="route('admin.local-gold-purchase-resource.index')">
              Voir Tout
            </Link>
          </Button>

        </div>

        <div class="mb-6">
          <h3 class="text-lg font-medium mb-2">Achats Locaux</h3>
          <div class="flex flex-wrap gap-2">
            <Button variant="outline">Traitement</Button>
            <Button variant="outline">Expéditions</Button>
            <Button variant="outline">Ventes</Button>
            <Button variant="outline">Données de marché</Button>
          </div>
        </div>

        <h3 class="text-lg font-medium mb-4">Achats Récentes</h3>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Fournisseur</TableHead>
              <TableHead>Poids à l'air (g)</TableHead>
              <TableHead>Poids à l'eau (g)</TableHead>
              <TableHead>Date d'Achat</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="(purchase, index) in recentPurchasesLocal" :key="index">
              <TableCell>{{ purchase.supplier.name }}</TableCell>
              <TableCell>{{ purchase.weight_grams_max }}</TableCell>
              <TableCell>{{ purchase.weight_grams_min }}</TableCell>
              <TableCell>{{ formatDate(purchase.purchase_date) }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <!-- Section Sales -->
      <div class="rounded-xl border bg-card p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold">Ventes récentes</h2>
          <Button variant="outline" as-child>
            <Link :href="route('admin.gold-sale-resource.index')">
              Voir Tout
            </Link>
          </Button>
        </div>
        
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Acheteur</TableHead>
              <TableHead>poids (g)</TableHead>
              <TableHead>Date Ventes</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="(sale, index) in recentSales" :key="index">
              <TableCell>{{ sale.buyer_name }}</TableCell>
              <TableCell>{{ sale.weight_sold }} g</TableCell>
              <TableCell>{{ formatDate(sale.sale_date) }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </AppLayout>
</template>