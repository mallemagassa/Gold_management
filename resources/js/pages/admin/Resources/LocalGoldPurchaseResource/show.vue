<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Badge } from '@/components/ui/badge'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { 
  Scale, BadgeDollarSign, User, Receipt, Calendar, Printer, 
  ChevronDown, ChevronUp, Package, CircleDollarSign, Gem, Percent
} from 'lucide-vue-next'
import { computed, ref } from "vue";

const props = defineProps({
  localgoldpurchase: Object,
  resource: Object,
  baremeOptions: Array
})

const showItemsDetails = ref(true)

function formatDate(value) {
  if (!value) return 'Non défini'
  return new Date(value).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

function formatDateTime(value) {
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

function formatNumber(value, decimals = 2) {
  if (!value) return '0'
  return new Intl.NumberFormat('fr-FR', {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals
  }).format(value)
}

function getStatusBadgeVariant(status) {
  return status === 'paid' ? 'success' : 'warning'
}

// Calculs pour l'achat principal
const puretePrincipale = computed(() => {
  if (props.localgoldpurchase.bareme_designation_carat?.carat) {
    return ((props.localgoldpurchase.bareme_designation_carat.carat * 100) / 24).toFixed(2)
  }
  return props.localgoldpurchase.purity_estimated || '0.00'
})

const caratDisplayPrincipal = computed(() => {
  return props.localgoldpurchase.bareme_designation_carat?.carat 
    ? `${props.localgoldpurchase.bareme_designation_carat.carat}K` 
    : '--'
})

// Calcul du total des items
const totalItems = computed(() => {
  return props.localgoldpurchase.items?.reduce((sum, item) => {
    return sum + (parseFloat(item.total_price) || 0)
  }, 0)
})

// Calcul du poids total
const totalWeight = computed(() => {
  return props.localgoldpurchase.items?.reduce((sum, item) => {
    return sum + (parseFloat(item.weight_grams_max) || 0)
  }, 0)
})

const printInvoice = () => {
  const printContent = document.getElementById('printable-content').innerHTML;
  const originalContent = document.body.innerHTML;
  
  document.body.innerHTML = printContent;
  window.print();
  document.body.innerHTML = originalContent;
  window.location.reload();
};
</script>

<template>
  <Head :title="`Facture Achat #${localgoldpurchase.receipt_reference}`" />

  <AppLayout>
    <div id="printable-content" class="flex flex-col gap-6 p-4 w-full print:p-0">
      
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 print:hidden">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gold-600">Facture d'Achat</h1>
          <p class="text-sm md:text-base text-muted-foreground">
            Référence: {{ localgoldpurchase.receipt_reference }} | 
            Date: {{ formatDate(localgoldpurchase.purchase_date) }}
          </p>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
          <Button 
            variant="outline" 
            class="border-gold-300"
            @click="printInvoice"
          >
            <Printer class="w-4 h-4 mr-2" />
            Imprimer
          </Button>
          <Link 
            :href="resource.routes.edit.replace(':id', localgoldpurchase.id)" 
            class="flex-1 sm:flex-none"
          >
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

      <Card class="border-gold-100 w-full max-w-6xl mx-auto print:border-0 print:shadow-none">
        <!-- En-tête de la facture -->
        <CardHeader class="pb-3 print:pb-1">
          <div class="flex flex-col md:flex-row justify-between gap-6">
            <div>
              <h2 class="text-xl font-bold text-gold-600">YIRIMA GOLD</h2>
              <p class="text-sm text-gray-500">123 Rue de l'Or, Quartier des Bijoutiers</p>
              <p class="text-sm text-gray-500">Tél: +223 92 68 32 69</p>
              <p class="text-sm text-gray-500">Email: yiriwagold@doucsoft.com</p>
            </div>
            
            <div class="text-right">
              <h2 class="text-xl font-bold text-gold-600">FACTURE D'ACHAT</h2>
              <p class="text-sm text-gray-500">N°: {{ localgoldpurchase.receipt_reference }}</p>
              <p class="text-sm text-gray-500">Date: {{ formatDate(localgoldpurchase.purchase_date) }}</p>
              <Badge 
                :variant="getStatusBadgeVariant(localgoldpurchase.payment_status)" 
                class="mt-2 text-sm md:text-base"
              >
                {{ localgoldpurchase.payment_status === 'paid' ? 'PAYÉ' : 'EN ATTENTE' }}
              </Badge>
            </div>
          </div>
        </CardHeader>

        <CardContent class="grid gap-6 p-6 print:p-4">
          <!-- Informations fournisseur -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 p-4 rounded-lg">
              <h3 class="font-semibold text-gold-600 mb-2">FOURNISSEUR</h3>
              <p class="font-medium">{{ localgoldpurchase.supplier?.name || 'Non spécifié' }}</p>
              <p class="text-sm text-gray-500 mt-1">Réf: {{ localgoldpurchase.supplier?.reference || '--' }}</p>
            </div>
            
            <div class="border border-gray-200 p-4 rounded-lg">
              <h3 class="font-semibold text-gold-600 mb-2">AGENT</h3>
              <p class="font-medium">{{ localgoldpurchase.agent?.name || 'Non spécifié' }}</p>
              <p class="text-sm text-gray-500 mt-1">Date: {{ formatDateTime(localgoldpurchase.created_at) }}</p>
            </div>
          </div>

          <!-- Tableau des articles -->
          <div class="border border-gray-200 rounded-lg overflow-hidden">
            <Table>
              <TableHeader class="bg-gold-50">
                <TableRow>
                  <TableHead class="w-[100px]">Article</TableHead>
                  <TableHead>Carat</TableHead>
                  <TableHead class="text-right">Poids (g)</TableHead>
                  <TableHead class="text-right">Densité</TableHead>
                  <TableHead class="text-right">Pureté</TableHead>
                  <TableHead class="text-right">Taux (XOF/g)</TableHead>
                  <TableHead class="text-right">Prix/g</TableHead>
                  <TableHead class="text-right">Total</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow 
                  v-for="(item, index) in localgoldpurchase.items" 
                  :key="item.id"
                  :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                >
                  <TableCell class="font-medium">OR {{ index + 1 }}</TableCell>
                  <TableCell>
                    {{ baremeOptions.find(b => b.id === item.bareme_designation_carat_id)?.carat || '--' }}K
                  </TableCell>
                  <TableCell class="text-right">{{ formatNumber(item.weight_grams_max) }}</TableCell>
                  <TableCell class="text-right">{{ formatNumber(item.densite) }}</TableCell>
                  <TableCell class="text-right">
                    {{ ((baremeOptions.find(b => b.id === item.bareme_designation_carat_id))?.carat * 100 / 24 || 0).toFixed(2) }}%
                  </TableCell>
                  <TableCell class="text-right">{{ formatCurrency(item.local_rate) }}</TableCell>
                  <TableCell class="text-right">{{ formatCurrency(item.price_per_gram_local) }}</TableCell>
                  <TableCell class="text-right font-semibold text-gold-600">
                    {{ formatCurrency(item.total_price) }}
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

          <!-- Totaux -->
          <div class="flex justify-end">
            <div class="w-full md:w-1/3 space-y-2">
              <div class="flex justify-between border-b pb-2">
                <span class="font-medium">Poids total:</span>
                <span class="font-medium">{{ formatNumber(totalWeight) }} g</span>
              </div>
              <div class="flex justify-between border-b pb-2">
                <span class="font-medium">Montant total:</span>
                <span class="font-bold text-lg text-gold-600">{{ formatCurrency(totalItems) }}</span>
              </div>
            </div>
          </div>

          <!-- Notes -->
          <div class="border-t border-gray-200 pt-4 mt-4">
            <h3 class="font-semibold text-gold-600 mb-2">NOTES</h3>
            <p class="text-sm text-gray-500">
              Paiement: {{ localgoldpurchase.payment_status === 'paid' ? 'Effectué' : 'À régler' }} | 
              Référence: {{ localgoldpurchase.receipt_reference }}
            </p>
          </div>
        </CardContent>

        <CardFooter class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-t border-gold-100 p-4 sm:p-6 print:hidden">
          <div class="text-sm text-gray-500">
            Enregistré le {{ formatDateTime(localgoldpurchase.created_at) }}
          </div>
          <div class="text-sm text-gray-500" v-if="localgoldpurchase.updated_at !== localgoldpurchase.created_at">
            Dernière modification le {{ formatDateTime(localgoldpurchase.updated_at) }}
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
}

@media print {
  @page {
    size: A4;
    margin: 1cm;
  }
  body {
    font-size: 12pt;
  }
  .print-hidden {
    display: none;
  }
}
</style>