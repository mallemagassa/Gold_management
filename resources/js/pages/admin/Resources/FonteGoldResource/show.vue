<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Badge } from '@/components/ui/badge'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { Scale, BadgeDollarSign, Calendar } from 'lucide-vue-next'

const props = defineProps({
  fontegold: Object,
  resource: Object,
})

function formatDate(value) {
  if (!value) return 'Non défini'
  return new Date(value).toLocaleDateString('fr-FR')
}

function formatCurrency(value) {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'XOF',
    minimumFractionDigits: 0
  }).format(value || 0)
}

const purete = computed(() => {
  if (props.fontegold.bareme_designation_carat?.carat) {
    return ((props.fontegold.bareme_designation_carat.carat * 100) / 24).toFixed(2)
  }
  return props.fontegold.purity_estimated || '0.00'
})

const caratDisplay = computed(() => {
  return props.fontegold.bareme_designation_carat?.carat 
    ? `${props.fontegold.bareme_designation_carat.carat}K` 
    : '--'
})
</script>

<template>
  <Head :title="`Détails Fonte #${fontegold.id}`" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 w-full">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gold-600">Détails de la Fonte</h1>
          <p class="text-sm text-muted-foreground">Date: {{ formatDate(fontegold.fonte_date) }}</p>
        </div>
        <div class="flex gap-2">
          <Link :href="resource.routes.edit.replace(':id', fontegold.id)">
            <Button variant="default" class="bg-gold-600 hover:bg-gold-700">
              Modifier
            </Button>
          </Link>
          <Link :href="resource.routes.index">
            <Button variant="outline" class="border-gold-300">
              Retour aux fontes
            </Button>
          </Link>
        </div>
      </div>

      <Card class="border-gold-100">
        <CardHeader>
          <CardTitle class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="text-xl font-semibold text-gold-600">Fonte d'or</span>
            </div>
            <div class="text-sm text-gray-500 flex items-center gap-2">
              <Calendar class="w-4 h-4" />
              <span>{{ formatDate(fontegold.fonte_date) }}</span>
            </div>
          </CardTitle>
        </CardHeader>

        <CardContent class="grid gap-8 md:grid-cols-2">
          <!-- Section Détails de l'Or -->
          <div class="space-y-4 p-4 bg-gold-50 rounded-lg">
            <div class="flex items-center gap-3 text-gold-600">
              <Scale class="w-6 h-6" />
              <h3 class="font-medium text-lg">Détails de l'Or</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Poids à l'air</h4>
                  <p class="text-base font-semibold">{{ fontegold.weight_grams_max }} g</p>
                </div>
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Poids à l'eau</h4>
                  <p class="text-base font-semibold">{{ fontegold.weight_grams_min }} g</p>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Densité</h4>
                  <p class="text-base font-semibold">{{ fontegold.densite }}</p>
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
          <div class="space-y-4 p-4 bg-gold-50 rounded-lg">
            <div class="flex items-center gap-3 text-gold-600">
              <BadgeDollarSign class="w-6 h-6" />
              <h3 class="font-medium text-lg">Détails Financiers</h3>
            </div>
            
            <div class="space-y-4 pl-9">
              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Prix/gramme</h4>
                  <p class="text-base font-semibold">{{ formatCurrency(fontegold.price_per_gram_local) }}</p>
                </div>
                <div class="space-y-1">
                  <h4 class="text-sm font-medium text-gray-500">Taux local</h4>
                  <p class="text-base font-semibold">
                    {{ formatCurrency(fontegold.local_rate?.rate_per_gram) }}/g
                  </p>
                </div>
              </div>

              <div class="space-y-1">
                <h4 class="text-sm font-medium text-gray-500">Montant total</h4>
                <p class="text-2xl font-bold text-gold-600">
                  {{ formatCurrency(fontegold.total_price) }}
                </p>
                <p class="text-sm text-muted-foreground">
                  {{ fontegold.weight_grams_max }}g × {{ formatCurrency(fontegold.local_rate?.rate_per_gram) }}
                </p>
              </div>
            </div>
          </div>
        </CardContent>

        <CardFooter class="flex justify-between border-t border-gold-100 p-4">
          <div class="text-sm text-gray-500">
            Enregistré le {{ formatDate(fontegold.created_at) }}
          </div>
          <div class="text-sm text-gray-500" v-if="fontegold.updated_at !== fontegold.created_at">
            Modifié le {{ formatDate(fontegold.updated_at) }}
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