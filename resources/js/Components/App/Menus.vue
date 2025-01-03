<template>
    <nav class="mt-8 space-y-2">
        <div class="text-sm text-gray-500 dark:text-gray-400 px-4 mb-2">
            <span v-if="!compact">MENUS</span>
            <span v-else>
                <hr>
            </span>
        </div>
        <div v-for="(item, index) in menuItems" :key="item.id">
            <div class="w-full flex items-center justify-between">
                <Link
                    v-if="!item.children || !item.children.length"
                    :href="route(item.route)"
                    :class="isActive(item)"
                    class="menus w-full flex items-center">
                    <component :is="resolveIcon(item.icon)" class="w-5 h-5" />
                    <span v-if="!compact" class="ml-2">{{ item.name }}</span>
                </Link>

                <div
                    v-else
                    @click="toggleMenu(index)"
                    :class="isActive(item)"
                    class="menus cursor-pointer w-full flex items-center justify-between">
                    <div class="flex items-center">
                        <component :is="resolveIcon(item.icon)" class="w-5 h-5" />
                        <span v-if="!compact" class="ml-2">{{ item.name }}</span>
                    </div>
                    <div :class="compact ? 'flex flex-col items-center' : 'ml-auto'">
                        <LucideIcons.ChevronDown
                            v-if="!menuState[index]"
                            class="w-4 h-4 mt-1" />
                        <LucideIcons.ChevronUp v-else class="w-4 h-4 mt-1" />
                    </div>
                </div>
            </div>

            <div
                v-if="item.children && item.children.length && menuState[index]"
                class="mt-2" :class="compact ? '' : 'ml-6 space-y-1'">
                <Link
                    v-for="child in item.children"
                    :key="child.id"
                    :href="route(child.route)"
                    :class="isActive(child)"
                    class="submenu flex items-center">
                    <component :is="resolveIcon(child.icon)" class="w-5 h-5" />
                    <span v-if="!compact" class="ml-2">{{ child.name }}</span>
                </Link>
            </div>
        </div>
    </nav>
</template>
<script setup>
import { reactive, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import * as LucideIcons from 'lucide-vue-next';

const { props } = usePage();

const menuItems = buildMenuHierarchy(props.menus || []);

const menuState = reactive(Array(menuItems.length).fill(false));

const isActive = (item) =>
    route().current(item.route) ? 'active' : 'inactive';

function resolveIcon(iconName) {
    return LucideIcons[iconName] || LucideIcons.LayoutGrid;
}

function toggleMenu(index) {
    menuState[index] = !menuState[index];
}

function buildMenuHierarchy(menuItems) {
    const menuMap = {};
    menuItems.forEach((item) => (menuMap[item.id] = { ...item, children: [] }));

    const hierarchy = [];
    menuItems.forEach((item) => {
        if (item.parent_id) {
            menuMap[item.parent_id].children.push(menuMap[item.id]);
        } else {
            hierarchy.push(menuMap[item.id]);
        }
    });

    return hierarchy;
}

onMounted(() => {
    menuItems.forEach((item, index) => {
        if (item.children && item.children.length) {
            item.children.forEach((child) => {
                if (route().current(child.route)) {
                    menuState[index] = true;
                }
            });
        }
    });
});

defineProps({
    compact: Boolean,
});
</script>
