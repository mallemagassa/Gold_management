<script setup>
import { ref, computed, watch } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Button from '@/components/ui/button/Button.vue'
import { toast } from 'vue-sonner'
import Select from '@/components/ui/select/Select.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import { SelectTrigger, SelectValue, SelectContent } from '@/components/ui/select'
import { CalendarDays, Scale, BadgeDollarSign } from 'lucide-vue-next'

const props = defineProps({
  form: Object,
  resource: Object
})

// Initialisation du formulaire avec les valeurs par défaut
const form = useForm({
  shipment_id: '',
  buyer_name: '',
  weight_sold: '',
  price_per_gram: '',
  total_price: '',
  currency: 'XOF',
  sale_date: new Date().toISOString().split('T')[0],
  payment_status: 'pending',
  invoice_number: '',
  created_by: ''
})

// Extraction des options pour les selects
const shipmentOptions = computed(() => props.form.shipment_id?.options?.options || {})
const paymentStatusOptions = computed(() => ({
  pending: 'En attente',
  paid: 'Payé'
}))
const createdByOptions = computed(() => props.form.created_by?.options?.options || {})

// Calcul automatique du prix total
const totalPrice = computed(() => {
  try {
    const weight = parseFloat(String(form.weight_sold).replace(',', '.') || 0)
    const price = parseFloat(String(form.price_per_gram).replace(/[^0-9.]/g, '') || 0)
    return (weight * price).toLocaleString('fr-FR') + ' ' + form.currency
  } catch {
    return '0 ' + form.currency
  }
})

// Watch pour mettre à jour le total automatiquement
watch(() => [form.weight_sold, form.price_per_gram, form.currency], () => {
  if (form.weight_sold && form.price_per_gram) {
    try {
      const weight = parseFloat(String(form.weight_sold).replace(',', '.'))
      const price = parseFloat(String(form.price_per_gram).replace(/[^0-9.]/g, ''))
      form.total_price = (weight * price).toFixed(2)
    } catch {
      form.total_price = '0'
    }
  }
})

function submitForm() {
  form.post(props.resource.routes.store, {
    onSuccess: () => {
      toast.success('Vente d\'or enregistrée avec succès')
    },
    onError: () => {
      toast.error('Erreur lors de l\'enregistrement')
    }
  })
}
</script>

<template>
  <Head title="Nouvelle Vente d'Or" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 max-w-4xl mx-auto">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gold-600">Nouvelle Vente d'Or</h1>
          <p class="text-sm text-muted-foreground">Enregistrez une nouvelle transaction de vente d'or</p>
        </div>
        <Link :href="resource.routes.index">
          <Button variant="outline" class="border-gold-300">
            Retour aux ventes
          </Button>
        </Link>
      </div>

      <div class="bg-white dark:bg-card rounded-xl shadow-sm border border-gold-100 p-6">
        <form @submit.prevent="submitForm" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Section Détails de l'Or -->
            <div class="space-y-4">
              <h2 class="font-semibold text-lg flex items-center gap-2 text-gold-600">
                <Scale class="w-5 h-5" /> Détails de l'Or
              </h2>
              
              <div class="space-y-3">
                <!-- Sélecteur d'expédition -->
                <div>
                  <label class="block text-sm font-medium mb-1">Expédition</label>
                  <Select v-model="form.shipment_id" required>
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Sélectionnez une expédition" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem
                        v-for="(name, id) in shipmentOptions"
                        :key="id"
                        :value="id"
                      >
                        {{ name }}
                      </SelectItem>
                    </SelectContent>
                  </Select>
                  <span v-if="form.errors.shipment_id" class="text-sm text-red-600">
                    {{ form.errors.shipment_id }}
                  </span>
                </div>

                <!-- Poids vendu -->
                <div>
                  <label class="block text-sm font-medium mb-1">Poids vendu (g)</label>
                  <Input 
                    v-model="form.weight_sold" 
                    type="text" 
                    required 
                    @input="form.weight_sold = form.weight_sold.replace(/[^0-9,.]/g, '')"
                  />
                  <span v-if="form.errors.weight_sold" class="text-sm text-red-600">
                    {{ form.errors.weight_sold }}
                  </span>
                </div>

                <!-- Prix au gramme -->
                <div>
                  <label class="block text-sm font-medium mb-1">Prix au gramme</label>
                  <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm">{{ form.currency }}</span>
                    <Input 
                      v-model="form.price_per_gram" 
                      type="text" 
                      class="pl-12" 
                      required 
                      @input="form.price_per_gram = form.price_per_gram.replace(/[^0-9]/g, '')"
                    />
                  </div>
                  <span v-if="form.errors.price_per_gram" class="text-sm text-red-600">
                    {{ form.errors.price_per_gram }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Section Détails de la Transaction -->
            <div class="space-y-4">
              <h2 class="font-semibold text-lg flex items-center gap-2 text-gold-600">
                <BadgeDollarSign class="w-5 h-5" /> Détails de la Transaction
              </h2>
              
              <div class="space-y-3">
                <!-- Nom de l'acheteur -->
                <div>
                  <label class="block text-sm font-medium mb-1">Acheteur</label>
                  <Input v-model="form.buyer_name" required />
                  <span v-if="form.errors.buyer_name" class="text-sm text-red-600">
                    {{ form.errors.buyer_name }}
                  </span>
                </div>

                <!-- Date de vente -->
                <div>
                  <label class="block text-sm font-medium mb-1">Date de vente</label>
                  <Input v-model="form.sale_date" type="date" required />
                  <span v-if="form.errors.sale_date" class="text-sm text-red-600">
                    {{ form.errors.sale_date }}
                  </span>
                </div>

                <!-- Statut de paiement -->
                <div>
                  <label class="block text-sm font-medium mb-1">Statut de paiement</label>
                  <Select v-model="form.payment_status" required>
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Statut" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="pending">En attente</SelectItem>
                      <SelectItem value="paid">Payé</SelectItem>
                    </SelectContent>
                  </Select>
                  <span v-if="form.errors.payment_status" class="text-sm text-red-600">
                    {{ form.errors.payment_status }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Section Récapitulatif -->
          <div class="bg-gold-50 dark:bg-gold-900/20 rounded-lg p-4 border border-gold-200 dark:border-gold-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Montant total -->
              <div>
                <label class="block text-sm font-medium mb-1">Montant total</label>
                <div class="text-2xl font-bold text-gold-600">
                  {{ totalPrice }}
                </div>
                <input type="hidden" v-model="form.total_price" />
              </div>
              
              <!-- Devise -->
              <div>
                <label class="block text-sm font-medium mb-1">Devise</label>
                <Select v-model="form.currency">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Devise" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="XOF">XOF</SelectItem>
                    <SelectItem value="USD">USD</SelectItem>
                    <SelectItem value="EUR">EUR</SelectItem>
                  </SelectContent>
                </Select>
                <span v-if="form.errors.currency" class="text-sm text-red-600">
                  {{ form.errors.currency }}
                </span>
              </div>
              
              <!-- Numéro de facture -->
              <div>
                <label class="block text-sm font-medium mb-1">Numéro de facture</label>
                <Input v-model="form.invoice_number" required />
                <span v-if="form.errors.invoice_number" class="text-sm text-red-600">
                  {{ form.errors.invoice_number }}
                </span>
              </div>
            </div>
          </div>

          <!-- Boutons d'action -->
          <div class="flex justify-end gap-3 pt-4">
            <Link :href="resource.routes.index">
              <Button variant="outline" type="button">
                Annuler
              </Button>
            </Link>
            <Button type="submit" class="bg-gold-600 hover:bg-gold-700" :disabled="form.processing">
              Enregistrer la vente
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<style>
/* Couleurs personnalisées pour le thème or */
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
  .dark .bg-gold-900\/20 {
    background-color: hsl(42, 60%, 10%, 0.2);
  }
}
</style>