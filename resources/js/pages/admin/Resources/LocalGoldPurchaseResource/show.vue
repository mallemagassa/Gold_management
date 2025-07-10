<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Badge } from '@/components/ui/badge'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { Scale, BadgeDollarSign, User, Receipt, Calendar, Gauge, Hash } from 'lucide-vue-next'
import { computed } from "vue";

const props = defineProps({
  localgoldpurchase: Object,
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
  if (!value) return '0 XOF'
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 2
  }).format(value)
}

function getStatusBadgeVariant(status) {
  return status === 'paid' ? 'success' : 'warning'
}

// Calcul de la pureté pour affichage
const purete = computed(() => {
  if (props.localgoldpurchase.bareme_designation_carat?.carat) {
    return ((props.localgoldpurchase.bareme_designation_carat.carat * 100) / 24).toFixed(2)
  }
  return props.localgoldpurchase.purity_estimated || '0.00'
})

// Formatage du carat
const caratDisplay = computed(() => {
  return props.localgoldpurchase.bareme_designation_carat?.carat 
    ? `${props.localgoldpurchase.bareme_designation_carat.carat}K` 
    : '--'
})
</script>

<template>
  <Head :title="`Détails Achat #${localgoldpurchase.receipt_reference}`" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 w-full">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gold-600">Détails de l'Achat</h1>
          <p class="text-sm md:text-base text-muted-foreground">Référence: {{ localgoldpurchase.receipt_reference }}</p>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
          <Link :href="resource.routes.edit.replace(':id', localgoldpurchase.id)" class="flex-1 sm:flex-none">
            <Button variant="default" class="w-full sm:w-auto bg-gold-600 hover:bg-gold-700">
              Modifier
            </Button>
          </Link>
          <Link :href="resource.routes.index" class="flex-1 sm:flex-none">
            <Button variant="outline" class="w-full sm:w-auto border-gold-300">
              Retour aux achats
            </Button>
          </Link>
        </div>
      </div>

      <Card class="border-gold-100 w-full max-w-6xl mx-auto">
        <CardHeader class="pb-3">
          <CardTitle class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
              <span class="text-xl md:text-2xl font-semibold text-gold-600">
                Achat de {{ localgoldpurchase.supplier?.name || 'Non spécifié' }}
              </span>
              <Badge :variant="getStatusBadgeVariant(localgoldpurchase.payment_status)" class="text-sm md:text-base">
                {{ localgoldpurchase.payment_status === 'paid' ? 'Payé' : 'En attente' }}
              </Badge>
            </div>
            <div class="text-sm text-gray-500 flex items-center gap-2">
              <Calendar class="w-4 h-4" />
              <span>{{ formatDate(localgoldpurchase.purchase_date) }}</span>
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
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Poids à l'air</h4>
                  <p class="text-base font-semibold">{{ localgoldpurchase.weight_grams_max }} g</p>
                </div>

                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Poids à l'eau</h4>
                  <p class="text-base font-semibold">{{ localgoldpurchase.weight_grams_min }} g</p>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Densité</h4>
                  <p class="text-base font-semibold">{{ localgoldpurchase.densite }}</p>
                </div>

                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Carats</h4>
                  <p class="text-base font-semibold">{{ caratDisplay }}</p>
                </div>
              </div>

              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Pureté estimée</h4>
                <p class="text-base font-semibold">{{ purete }}%</p>
              </div>
            </div>
          </div>

          <!-- Section Détails Financiers -->
          <div class="space-y-4 p-4 bg-gold-50/50 dark:bg-gold-900/10 rounded-lg">
            <div class="flex items-center gap-3 text-gold-600">
              <BadgeDollarSign class="w-6 h-6" />
              <h3 class="font-medium text-lg">Détails Financiers</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Prix/gramme</h4>
                  <p class="text-base font-semibold">{{ formatCurrency(localgoldpurchase.price_per_gram_local) }}</p>
                </div>

                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Taux local</h4>
                  <p class="text-base font-semibold">
                    {{ formatCurrency(localgoldpurchase.local_rate?.rate_per_gram) }}/g
                  </p>
                </div>
              </div>

              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Calcul prix/gramme</h4>
                <p class="text-sm text-muted-foreground">
                  Taux ({{ formatCurrency(localgoldpurchase.local_rate?.rate_per_gram) }}) 
                  × (Carat {{ caratDisplay }}/24)
                </p>
              </div>
            </div>
          </div>

          <!-- Section Récapitulatif -->
          <div class="space-y-4 p-4 bg-gold-50/50 dark:bg-gold-900/10 rounded-lg md:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-3 text-gold-600">
              <Receipt class="w-6 h-6" />
              <h3 class="font-medium text-lg">Récapitulatif</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Montant total</h4>
                <p class="text-2xl md:text-3xl font-bold text-gold-600">
                  {{ formatCurrency(localgoldpurchase.total_price) }}
                </p>
                <p class="text-sm text-muted-foreground">
                  {{ localgoldpurchase.weight_grams_max }}g × {{ formatCurrency(localgoldpurchase.local_rate?.rate_per_gram) }}
                </p>
              </div>
              
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Statut</h4>
                  <Badge :variant="getStatusBadgeVariant(localgoldpurchase.payment_status)" class="text-sm">
                    {{ localgoldpurchase.payment_status === 'paid' ? 'Payé' : 'En attente' }}
                  </Badge>
                </div>
                
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Agent</h4>
                  <p class="text-base font-semibold">{{ localgoldpurchase.agent?.name || 'Non spécifié' }}</p>
                </div>
              </div>

              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Référence</h4>
                <p class="text-base font-semibold font-mono">{{ localgoldpurchase.receipt_reference }}</p>
              </div>
            </div>
          </div>
        </CardContent>

        <CardFooter class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-t border-gold-100 p-4 sm:p-6">
          <div class="text-sm text-gray-500">
            Enregistré le {{ formatDate(localgoldpurchase.created_at) }}
          </div>
          <div class="text-sm text-gray-500" v-if="localgoldpurchase.updated_at !== localgoldpurchase.created_at">
            Dernière modification le {{ formatDate(localgoldpurchase.updated_at) }}
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