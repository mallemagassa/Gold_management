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
import { Scale, BadgeDollarSign } from 'lucide-vue-next'

const props = defineProps({
  form: Object,
  resource: Object,
  baremeOptions: Array
})

const localRateOptions = computed(() => props.form.local_rate_id?.options?.options || {})
const caratOptions = computed(() => props.form.bareme_designation_carat_id?.options?.options || {})

const form = useForm({
  weight_grams_min: '',
  weight_grams_max: '',
  densite: '',
  bareme_designation_carat_id: '',
  purity_estimated: '',
  price_per_gram_local: '',
  total_price: '',
  fonte_date: new Date().toISOString().split('T')[0],
  local_rate_id: ''
})

const cleanNumber = (value) => parseFloat(value?.toString().replace(',', '.')) || 0

// Calculs automatiques
const densite = computed(() => {
  if (form.weight_grams_max && form.weight_grams_min) {
    const poidsAir = cleanNumber(form.weight_grams_max)
    const poidsEau = cleanNumber(form.weight_grams_min)
    const difference = poidsAir - poidsEau
    return difference > 0 ? (poidsAir / difference).toFixed(2) : '0.00'
  }
  return '0.00'
})

const selectedCarat = computed(() => {
  if (!props.baremeOptions || densite.value === '0.00') return null
  const densiteValue = parseFloat(densite.value)
  return props.baremeOptions.find(item => 
    densiteValue >= item.density_min && densiteValue <= item.density_max
  )
})

const purete = computed(() => {
  if (selectedCarat.value) {
    return ((selectedCarat.value.carat * 100) / 24).toFixed(2)
  }
  return '0.00'
})

const pricePerGram = computed(() => {
  if (form.local_rate_id && selectedCarat.value) {
    const rate = cleanNumber(localRateOptions.value[form.local_rate_id])
    return (rate * (selectedCarat.value.carat / 24)).toFixed(2)
  }
  return '0.00'
})

const montantTotal = computed(() => {
  if (form.weight_grams_max && form.local_rate_id) {
    const poidsAir = cleanNumber(form.weight_grams_max)
    const rate = cleanNumber(localRateOptions.value[form.local_rate_id])
    return (poidsAir * rate).toFixed(2)
  }
  return '0.00'
})

// Mise à jour des champs
watch(densite, (newVal) => form.densite = newVal)
watch(selectedCarat, (newVal) => {
  if (newVal) form.bareme_designation_carat_id = newVal.id
})
watch(purete, (newVal) => form.purity_estimated = newVal)
watch(pricePerGram, (newVal) => form.price_per_gram_local = newVal)
watch(montantTotal, (newVal) => form.total_price = newVal)

function submitForm() {
  form.post(props.resource.routes.store, {
    onSuccess: () => toast.success('Fonte enregistrée avec succès'),
    onError: () => toast.error('Erreur lors de l\'enregistrement')
  })
}
</script>

<template>
  <Head :title="`Nouvelle Fonte d'Or`" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 max-w-4xl mx-auto">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gold-600">Nouvelle Fonte d'Or</h1>
          <p class="text-sm text-muted-foreground">Enregistrez une nouvelle fonte</p>
        </div>
        <Link :href="resource.routes.index">
          <Button variant="outline" class="border-gold-300">Retour aux fontes</Button>
        </Link>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gold-100 p-6">
        <form @submit.prevent="submitForm" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Section Détails de l'Or -->
            <div class="space-y-4">
              <h2 class="font-semibold text-lg flex items-center gap-2 text-gold-600">
                <Scale class="w-5 h-5" /> Détails de l'Or
              </h2>
              
              <div class="space-y-3">
                <div>
                  <label class="block text-sm font-medium mb-1">Poids à l'air (g)</label>
                  <Input v-model="form.weight_grams_max" type="number" required step="0.01" min="0" />
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1">Poids à l'eau (g)</label>
                  <Input v-model="form.weight_grams_min" type="number" required step="0.01" min="0" />
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1">Densité (calculée)</label>
                  <Input v-model="form.densite" type="text" readonly class="bg-gray-100" />
                </div>
              </div>
            </div>

            <!-- Section Détails Financiers -->
            <div class="space-y-4">
              <h2 class="font-semibold text-lg flex items-center gap-2 text-gold-600">
                <BadgeDollarSign class="w-5 h-5" /> Détails Financiers
              </h2>
              
              <div class="space-y-3">
                <div>
                  <label class="block text-sm font-medium mb-1">Taux Local Pur</label>
                  <Select v-model="form.local_rate_id" required>
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Sélectionnez un taux" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem v-for="(rate, id) in localRateOptions" :key="id" :value="id">
                        {{ rate }} XOF/g
                      </SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1">Date de fonte</label>
                  <Input v-model="form.fonte_date" type="date" required />
                </div>
              </div>
            </div>
          </div>

          <!-- Section Récapitulatif -->
          <div class="bg-gold-50 rounded-lg p-4 border border-gold-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium mb-1">Carats</label>
                <div class="text-2xl font-bold text-gold-600">
                  {{ selectedCarat?.carat || '--' }}K
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Pureté estimée</label>
                <div class="text-2xl font-bold text-gold-600">
                  {{ purete }}%
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Prix au gramme</label>
                <div class="text-2xl font-bold text-gold-600">
                  {{ pricePerGram }} XOF
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gold-50 rounded-lg p-4 border border-gold-200">
            <div class="flex justify-between items-center">
              <div>
                <label class="block text-sm font-medium mb-1">Montant total</label>
                <div class="text-2xl font-bold text-gold-600">
                  {{ montantTotal }} XOF
                </div>
              </div>
              <Button type="submit" class="bg-gold-600 hover:bg-gold-700" :disabled="form.processing">
                Enregistrer la fonte
              </Button>
            </div>
          </div>
        </form>
      </div>
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
</style>