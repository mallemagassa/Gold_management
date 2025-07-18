<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Button from '@/components/ui/button/Button.vue'
import { toast } from 'vue-sonner'
import Select from '@/components/ui/select/Select.vue'
import SelectItem from '@/components/ui/select/SelectItem.vue'
import { SelectTrigger, SelectValue, SelectContent } from '@/components/ui/select'
import { Scale, BadgeDollarSign, User, Receipt, Plus, Trash2 } from 'lucide-vue-next'
import { Check, Pencil, X } from 'lucide-vue-next'

const { props: pageProps } = usePage()
const localRate = ref(pageProps?.localRate?.rate_per_gram || 0)

const props = defineProps({
  localgoldpurchase: Object,
  form: Object,
  resource: Object,
  baremeOptions: Array,
  localRateOptions: Object
})

// Gestion des erreurs améliorée
const getError = (field, index = null) => {
  if (index !== null && field.startsWith('items')) {
    const fieldName = field.split('.')[2]
    return form.errors[`items.${index}.${fieldName}`] || 
           form.errors[`items.${index}`]?.[fieldName]
  }
  return form.errors[field]
}

const hasError = (field, index = null) => {
  return !!getError(field, index)
}

const generateId = () => Math.random().toString(36).substring(2, 9)

const initialItem = () => ({
  id: generateId(),
  weight_grams_min: '',
  weight_grams_max: '',
  densite: '',
  bareme_designation_carat_id: '',
  carat_display: '0.00K',
  purity_estimated: '',
  price_per_gram_local: '',
  total_price: '',
  local_rate: localRate.value,
  editingRate: false
})

const items = ref([])

onMounted(() => {
  if (props.localgoldpurchase?.items?.length) {
    items.value = props.localgoldpurchase.items.map(item => {
      const carat = props.baremeOptions.find(b => b.id === item.bareme_designation_carat_id)
      return {
        ...item,
        id: item.id || generateId(),
        editingRate: false,
        carat_display: carat ? `${carat.carat}K` : '0.00K'
      }
    })
    if (items.value[0]?.local_rate) {
      localRate.value = items.value[0].local_rate
    }
  } else {
    items.value = [initialItem()]
  }
})

const addItem = () => {
  items.value.push(initialItem())
}

const removeItem = (index) => {
  if (items.value.length > 1) {
    items.value.splice(index, 1)
  }
}

const form = useForm({
  supplier_id: props.localgoldpurchase?.supplier_id || '',
  purchase_date: props.localgoldpurchase?.purchase_date || new Date().toISOString().split('T')[0],
  payment_status: props.localgoldpurchase?.payment_status || 'pending',
  agent_id: props.localgoldpurchase?.agent_id || '',
  receipt_reference: props.localgoldpurchase?.receipt_reference || '',
  items: items.value
})

const cleanNumber = (value) => {
  if (!value) return 0
  return parseFloat(value.toString().replace(',', '.')) || 0
}

const calculateItemValues = (item, index) => {
  const poidsAir = cleanNumber(item.weight_grams_max)
  const poidsEau = cleanNumber(item.weight_grams_min)
  const difference = poidsAir - poidsEau
  
  if (poidsAir > 0 && poidsEau > 0 && difference > 0) {
    items.value[index].densite = (poidsAir / difference).toFixed(2)
  } else {
    items.value[index].densite = '0.00'
  }

  const densiteValue = parseFloat(items.value[index].densite)
  const selectedCarat = props.baremeOptions.find(b => 
    densiteValue >= b.density_min && densiteValue <= b.density_max
  )

  if (selectedCarat) {
    items.value[index].bareme_designation_carat_id = selectedCarat.id
    items.value[index].carat_display = `${selectedCarat.carat}K`
    items.value[index].purity_estimated = ((selectedCarat.carat * 100) / 24).toFixed(2)
    
    const rate = cleanNumber(item.local_rate)
    const poids = cleanNumber(item.weight_grams_max)
    
    if (rate > 0 && poids > 0) {
      items.value[index].price_per_gram_local = (rate * (selectedCarat.carat / 24)).toFixed(2)
      items.value[index].total_price = (poids * rate).toFixed(2)
    } else {
      items.value[index].price_per_gram_local = '0.00'
      items.value[index].total_price = '0.00'
    }
  } else {
    items.value[index].bareme_designation_carat_id = ''
    items.value[index].carat_display = '0.00K'
    items.value[index].purity_estimated = '0.00'
    items.value[index].price_per_gram_local = '0.00'
    items.value[index].total_price = '0.00'
  }
}

watch(() => items.value.map(item => ({
  weight_grams_max: item.weight_grams_max,
  weight_grams_min: item.weight_grams_min,
  local_rate: item.local_rate
})), () => {
  items.value.forEach((item, index) => {
    calculateItemValues(item, index)
  })
}, { deep: true, immediate: true })

const supplierOptions = computed(() => props.form.supplier_id?.options?.options || {})
const agentOptions = computed(() => props.form.agent_id?.options?.options || {})

function submitForm() {
  form.items = items.value
  
  form.put(props.resource.routes.update.replace('{id}', props.localgoldpurchase.id), {
    onSuccess: () => {
      toast.success('Achat mis à jour avec succès')
    },
    onError: () => {
      toast.error('Veuillez corriger les erreurs dans le formulaire')
      setTimeout(() => {
        const firstError = document.querySelector('.border-red-500, .text-red-500')
        if (firstError) {
          firstError.scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
      }, 100)
    }
  })
}

const toggleEditRate = (index, cancel = false) => {
  if (items.value[index].editingRate && cancel) {
    items.value[index].local_rate = localRate.value
  }
  
  items.value[index].editingRate = !items.value[index].editingRate
  
  if (!items.value[index].editingRate && !cancel) {
    calculateItemValues(items.value[index], index)
  }
}

const getCaratDisplay = (item) => {
  const found = props.baremeOptions.find(b => b.id === item.bareme_designation_carat_id)
  return found ? `${found.carat}K` : '0.00K'
}

const getSelectValue = (id) => {
  if (id === 'true') return true
  if (id === 'false') return false
  if (!isNaN(id)) return Number(id)
  return id
}
</script>

<template>
  <Head :title="`Modifier Achat d'Or Local`" />

  <AppLayout>
    <div class="flex flex-col gap-6 p-4 w-full max-w-[100vw]">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-4">
        <div>
          <h1 class="text-2xl font-bold text-gold-600">
            Modifier Achat d'Or Local
          </h1>
          <p class="text-sm text-muted-foreground">
            Modifier une transaction d'achat
          </p>
        </div>
        <Link :href="resource.routes.index" class="w-full md:w-auto">
          <Button variant="outline" class="border-gold-300 w-full md:w-auto">
            Retour aux achats
          </Button>
        </Link>
      </div>

      <div class="bg-white dark:bg-card rounded-xl shadow-sm border border-gold-100 p-4 md:p-6 w-full">
        <form @submit.prevent="submitForm" class="space-y-6 w-full">
          <!-- Section Informations de base -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 w-full">
            <!-- Fournisseur -->
            <div class="space-y-1">
              <label class="block text-sm font-medium mb-1">Fournisseur</label>
              <Select 
                v-model="form.supplier_id" 
                required
                :class="{ 'border-red-500': hasError('supplier_id') }"
              >
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Sélectionnez un fournisseur" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem
                    v-for="(name, id) in supplierOptions"
                    :key="id"
                    :value="getSelectValue(id)"
                  >
                    {{ name }}
                  </SelectItem>
                </SelectContent>
              </Select>
              <p v-if="hasError('supplier_id')" class="text-red-500 text-xs mt-1">
                {{ getError('supplier_id') }}
              </p>
            </div>

            <!-- Date d'achat -->
            <div class="space-y-1">
              <label class="block text-sm font-medium mb-1">Date d'achat</label>
              <Input 
                v-model="form.purchase_date" 
                type="date" 
                required 
                class="w-full"
                :class="{ 'border-red-500': hasError('purchase_date') }"
              />
              <p v-if="hasError('purchase_date')" class="text-red-500 text-xs mt-1">
                {{ getError('purchase_date') }}
              </p>
            </div>

            <!-- Statut de paiement -->
            <div class="space-y-1">
              <label class="block text-sm font-medium mb-1">Statut de paiement</label>
              <Select 
                v-model="form.payment_status" 
                required
                :class="{ 'border-red-500': hasError('payment_status') }"
              >
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Statut" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="pending">En attente</SelectItem>
                  <SelectItem value="paid">Payé</SelectItem>
                </SelectContent>
              </Select>
              <p v-if="hasError('payment_status')" class="text-red-500 text-xs mt-1">
                {{ getError('payment_status') }}
              </p>
            </div>

            <!-- Agent -->
            <div class="space-y-1">
              <label class="block text-sm font-medium mb-1">Agent</label>
              <Select 
                v-model="form.agent_id" 
                required
                :class="{ 'border-red-500': hasError('agent_id') }"
              >
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Sélectionnez un agent" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem
                    v-for="(name, id) in agentOptions"
                    :key="id"
                    :value="getSelectValue(id)"
                  >
                    {{ name }}
                  </SelectItem>
                </SelectContent>
              </Select>
              <p v-if="hasError('agent_id')" class="text-red-500 text-xs mt-1">
                {{ getError('agent_id') }}
              </p>
            </div>

            <!-- Référence reçu -->
            <div class="md:col-span-2 space-y-1">
              <label class="block text-sm font-medium mb-1">Référence reçu</label>
              <Input 
                v-model="form.receipt_reference" 
                required 
                class="w-full"
                :class="{ 'border-red-500': hasError('receipt_reference') }"
              />
              <p v-if="hasError('receipt_reference')" class="text-red-500 text-xs mt-1">
                {{ getError('receipt_reference') }}
              </p>
            </div>
          </div>

          <!-- Section Items -->
          <div class="space-y-4 w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
              <h2 class="font-semibold text-lg flex items-center gap-2 text-gold-600">
                <Scale class="w-5 h-5" /> Articles d'Or
              </h2>
              <Button 
                type="button" 
                @click="addItem" 
                variant="outline" 
                class="border-gold-300 w-full md:w-auto"
              >
                <Plus class="w-4 h-4 mr-2" /> Ajouter un article
              </Button>
            </div>

            <!-- Message d'erreur global pour les items -->
            <div v-if="hasError('items')" class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-md">
              {{ getError('items') }}
            </div>

            <!-- Liste des items -->
            <div 
              v-for="(item, index) in items" 
              :key="item.id" 
              class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 relative w-full"
              :class="{ 'border-red-500': hasError('items', index) }"
            >
              <!-- Bouton de suppression -->
              <button 
                v-if="items.length > 1"
                type="button" 
                @click="removeItem(index)"
                class="absolute top-2 right-2 text-red-500 hover:text-red-700"
              >
                <Trash2 class="w-4 h-4" />
              </button>

              <!-- Message d'erreur pour l'item -->
              <div v-if="hasError('items', index)" class="text-red-500 text-xs mt-1 mb-2">
                {{ getError('items', index) }}
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 w-full">
                <!-- Poids à l'air -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Poids à l'air (g)</label>
                  <Input 
                    v-model="item.weight_grams_max" 
                    type="number" 
                    required 
                    step="0.01"
                    min="0"
                    class="w-full"
                    :class="{ 'border-red-500': hasError('items.weight_grams_max', index) }"
                    placeholder="Mettez le Poids à l'air (g)"
                  />
                  <p v-if="hasError('items.weight_grams_max', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.weight_grams_max', index) }}
                  </p>
                </div>

                <!-- Poids à l'eau -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Poids à l'eau (g)</label>
                  <Input 
                    v-model="item.weight_grams_min" 
                    type="number" 
                    required 
                    step="0.01"
                    min="0"
                    class="w-full"
                    :class="{ 'border-red-500': hasError('items.weight_grams_min', index) }"
                    placeholder="Mettez le Poids à l'eau (g)"
                  />
                  <p v-if="hasError('items.weight_grams_min', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.weight_grams_min', index) }}
                  </p>
                </div>

                <!-- Densité -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Densité</label>
                  <Input 
                    v-model="item.densite" 
                    type="text" 
                    readonly
                    class="bg-gray-100 w-full"
                    :class="{ 'border-red-500': hasError('items.densite', index) }"
                    placeholder="Affichage Densité (calculée)"
                  />
                  <p v-if="hasError('items.densite', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.densite', index) }}
                  </p>
                </div>

                <!-- Taux Local -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Taux Local Pur</label>
                  <div class="flex items-center gap-2">
                    <Button 
                      type="button" 
                      @click="toggleEditRate(index)"
                      variant="outline" 
                      size="sm"
                      class="whitespace-nowrap p-1"
                    >
                      <template v-if="item.editingRate">
                        <Check class="w-4 h-4 text-green-500" />
                      </template>
                      <template v-else>
                        <Pencil class="w-4 h-4" />
                      </template>
                    </Button>
                    <Button 
                      v-if="item.editingRate"
                      type="button" 
                      @click="toggleEditRate(index, true)"
                      variant="outline" 
                      size="sm"
                      class="whitespace-nowrap p-1 text-red-500 hover:text-red-700 border-red-300"
                    >
                      <X class="w-4 h-4" />
                    </Button>
                    <Input 
                      :modelValue="item.local_rate" 
                      @update:modelValue="val => { item.local_rate = val }"
                      :type="item.editingRate ? 'number' : 'text'" 
                      :readonly="!item.editingRate"
                      :class="['w-full', item.editingRate ? 'bg-white' : 'bg-gray-100', hasError('items.local_rate', index) ? 'border-red-500' : '']"
                      placeholder="Taux local (Base)"
                      step="0.01"
                    />
                  </div>
                  <p v-if="hasError('items.local_rate', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.local_rate', index) }}
                  </p>
                </div>

                <!-- Carat -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Carat</label>
                  <Input 
                    v-model="item.carat_display"
                    type="text" 
                    readonly
                    class="bg-gray-100 w-full"
                    :class="{ 'border-red-500': hasError('items.bareme_designation_carat_id', index) }"
                    placeholder="Affichage Carat (calculé)"
                  />
                  <p v-if="hasError('items.bareme_designation_carat_id', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.bareme_designation_carat_id', index) }}
                  </p>
                </div>

                <!-- Pureté Estimée -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Pureté Estimée</label>
                  <Input 
                    v-model="item.purity_estimated" 
                    type="text" 
                    readonly
                    class="bg-gray-100 w-full"
                    :class="{ 'border-red-500': hasError('items.purity_estimated', index) }"
                    placeholder="Affichage Pureté Estimée (calculée)"
                  />
                  <p v-if="hasError('items.purity_estimated', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.purity_estimated', index) }}
                  </p>
                </div>

                <!-- Prix au Gramme -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Prix au Gramme(g)</label>
                  <Input 
                    v-model="item.price_per_gram_local" 
                    type="text" 
                    readonly
                    class="bg-gray-100 w-full"
                    :class="{ 'border-red-500': hasError('items.price_per_gram_local', index) }"
                    placeholder="Affichage Prix au Gramme (calculé)"
                  />
                  <p v-if="hasError('items.price_per_gram_local', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.price_per_gram_local', index) }}
                  </p>
                </div>

                <!-- Montant Total -->
                <div class="space-y-1">
                  <label class="block text-sm font-medium mb-1">Montant Total</label>
                  <Input 
                    v-model="item.total_price" 
                    type="text" 
                    readonly
                    class="bg-gray-100 w-full"
                    :class="{ 'border-red-500': hasError('items.total_price', index) }"
                    placeholder="Affichage Montant Total (calculé)"
                  />
                  <p v-if="hasError('items.total_price', index)" class="text-red-500 text-xs mt-1">
                    {{ getError('items.total_price', index) }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Boutons de soumission -->
          <div class="flex flex-col md:flex-row justify-end gap-3 pt-4 w-full">
            <Link :href="resource.routes.index" class="w-full md:w-auto">
              <Button variant="outline" type="button" class="w-full md:w-auto">
                Annuler
              </Button>
            </Link>
            <Button 
              type="submit" 
              class="bg-gold-600 hover:bg-gold-700 w-full md:w-auto" 
              :disabled="form.processing"
            >
              Mettre à jour l'achat
            </Button>
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
  .border-red-500 {
    border-color: #ef4444;
  }
}
</style>