<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Badge } from '@/components/ui/badge'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { CalendarDays, Scale, BadgeDollarSign, Package, User, Clock, Edit } from 'lucide-vue-next'

const props = defineProps({
  goldsale: Object,
  resource: Object,
})

function formatDate(value) {
  if (!value) return 'Non défini'
  return new Date(value).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function formatCurrency(value, currency = 'XOF') {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: currency
  }).format(value)
}

function getStatusBadgeVariant(status) {
  return status === 'paid' ? 'success' : 'warning'
}
</script>

<template>
  <Head :title="`Détails Vente #${goldsale.invoice_number}`" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 w-full">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gold-600">Détails de la Vente</h1>
          <p class="text-sm md:text-base text-muted-foreground">Facture #{{ goldsale.invoice_number }}</p>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
          <Link :href="resource.routes.edit.replace(':id', goldsale.id)" class="flex-1 sm:flex-none">
            <Button variant="default" class="w-full sm:w-auto bg-gold-600 hover:bg-gold-700 gap-2">
              <Edit class="w-4 h-4" />
              Modifier
            </Button>
          </Link>
          <Link :href="resource.routes.index" class="flex-1 sm:flex-none">
            <Button variant="outline" class="w-full sm:w-auto border-gold-300 gap-2">
              Retour aux ventes
            </Button>
          </Link>
        </div>
      </div>

      <Card class="border-gold-100 w-full max-w-6xl mx-auto">
        <CardHeader class="pb-3">
          <CardTitle class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
              <span class="text-xl md:text-2xl font-semibold text-gold-600">Vente à {{ goldsale.buyer_name }}</span>
              <Badge :variant="getStatusBadgeVariant(goldsale.payment_status)" class="text-sm md:text-base">
                {{ goldsale.payment_status === 'paid' ? 'Payé' : 'En attente' }}
              </Badge>
            </div>
            <div class="text-sm text-gray-500 flex items-center gap-2">
              <Clock class="w-4 h-4" />
              <span>{{ formatDate(goldsale.sale_date) }}</span>
            </div>
          </CardTitle>
        </CardHeader>

        <CardContent class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 p-6">
          <!-- Section Détails de l'Or -->
          <div class="space-y-4 p-4 bg-gold-50/50 dark:bg-gold-900/10 rounded-lg">
            <div class="flex items-center gap-3 text-gold-600">
              <Scale class="w-6 h-6" />
              <h3 class="font-medium text-lg">Détails de l'Or</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Expédition</h4>
                <p class="text-base font-semibold">{{ goldsale.shipment?.shipment_code || 'Non spécifié' }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Poids vendu</h4>
                  <p class="text-base font-semibold">{{ goldsale.weight_sold }} g</p>
                </div>

                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Prix au gramme</h4>
                  <p class="text-base font-semibold">{{ formatCurrency(goldsale.price_per_gram, goldsale.currency) }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Section Détails de la Transaction -->
          <div class="space-y-4 p-4 bg-gold-50/50 dark:bg-gold-900/10 rounded-lg">
            <div class="flex items-center gap-3 text-gold-600">
              <BadgeDollarSign class="w-6 h-6" />
              <h3 class="font-medium text-lg">Détails de la Transaction</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Acheteur</h4>
                <p class="text-base font-semibold">{{ goldsale.buyer_name }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Devise</h4>
                  <p class="text-base font-semibold">{{ goldsale.currency }}</p>
                </div>

                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Facture</h4>
                  <p class="text-base font-semibold font-mono">{{ goldsale.invoice_number }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Section Récapitulatif -->
          <div class="space-y-4 p-4 bg-gold-50/50 dark:bg-gold-900/10 rounded-lg md:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-3 text-gold-600">
              <Package class="w-6 h-6" />
              <h3 class="font-medium text-lg">Récapitulatif Financier</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Montant total</h4>
                <p class="text-2xl md:text-3xl font-bold text-gold-600">
                  {{ formatCurrency(goldsale.total_price, goldsale.currency) }}
                </p>
              </div>
              
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Statut</h4>
                  <Badge :variant="getStatusBadgeVariant(goldsale.payment_status)" class="text-sm">
                    {{ goldsale.payment_status === 'paid' ? 'Payé' : 'En attente' }}
                  </Badge>
                </div>
                
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Méthode</h4>
                  <p class="text-base font-semibold">{{ goldsale.payment_method || 'Non spécifié' }}</p>
                </div>
              </div>
            </div>
          </div>
        </CardContent>

        <CardFooter class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-t border-gold-100 p-4 sm:p-6">
          <div class="text-sm text-gray-500 flex items-center gap-2">
            <User class="w-4 h-4" />
            <span>
              Créé le {{ formatDate(goldsale.created_at) }} 
              <span v-if="goldsale.creator">par {{ goldsale.creator.name }}</span>
            </span>
          </div>
          <div class="text-sm text-gray-500 flex items-center gap-2" v-if="goldsale.updated_at !== goldsale.created_at">
            <Clock class="w-4 h-4" />
            <span>Dernière modification le {{ formatDate(goldsale.updated_at) }}</span>
          </div>
        </CardFooter>
      </Card>
    </div>
  </AppLayout>
</template>

<style>
@layer utilities {
  .text-gold-600 {
    color: hsl(42, 94%, 55%);
  }
  .bg-gold-50 {
    background-color: hsl(42, 90%, 96%);
  }
  .border-gold-100 {
    border-color: hsl(42, 90%, 90%);
  }
  .bg-gold-600 {
    background-color: hsl(42, 94%, 55%);
  }
  .hover\:bg-gold-700:hover {
    background-color: hsl(42, 94%, 45%);
  }
  .dark .border-gold-800 {
    border-color: hsl(42, 50%, 30%);
  }
  .dark .bg-gold-900\/10 {
    background-color: hsl(42, 60%, 10%, 0.1);
  }
  .bg-gold-50\/50 {
    background-color: hsl(42, 90%, 96%, 0.5);
  }
}
</style>