<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue';
import Badge from './ui/badge/Badge.vue';

const { props } = usePage()

let localRate = ref({ rate_per_gram: 0 }); 

localRate.value = props.localRate.rate_per_gram


withDefaults(
  defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
    resources:Object,
  }>(),
  {
    breadcrumbs: () => [],
  },
);


</script>

<template>
    <header
        class="flex  justify-between h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div>
            <Badge>
               Taux Locale : {{ localRate }} F CFA
            </Badge>
        </div>
    </header>
</template>
