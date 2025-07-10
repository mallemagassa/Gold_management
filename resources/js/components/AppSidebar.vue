<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()

const panel = computed(() => props.panel ?? 'admin')
const resources = computed(() => props.resources ?? [])

// const mainNavItems: NavItem[] = [
//     {
//         title: 'Dashboard',
//         href: '/admin',
//         icon: LayoutGrid,
//     },
// ];


const mainNavItems = computed<NavItem[]>(() => {
  const items = [
    {
        title: 'Tableau De Board',
        href: '/admin',
        icon: LayoutGrid,
    },
  ]

  for (const [group, resources] of Object.entries(props.resources ?? {})) {
    if (Array.isArray(resources)) {
      items.push({
        title: group,
        icon: Folder,
        children: resources.map((r: any) => ({
          title: r.label,
          href: `/${panel.value}/${r.routeName}`,
          icon: Folder,
        }))
      })
    } else {
      // fallback for non-grouped
      items.push({
        title: resources.label,
        href: `/${panel.value}/${resources.routeName}`,
        icon: Folder,
      })
    }
  }

  return items
})

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('admin.dashboard')">
                            <h3>Gold Management</h3>
                            <!-- <AppLogo /> -->
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
