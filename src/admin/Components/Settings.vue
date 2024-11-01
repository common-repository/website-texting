<template>
    <div class="leadsms-settings w-[70%] my-8 p-4 bg-white" v-if="store.licenseChecked">
        <div class="grid grid-cols-2 gap-4 py-4">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800 md:text-4xl">LEAD<span class="text-brand-blue">sms</span>
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <div class="max-w-2xl mx-auto">
                    <aside class="w-64" aria-label="Sidebar">
                        <div class="py-4 overflow-y-auto rounded bg-gray-50">
                            <ul class="space-y-2">
                                <li>
                                    <NavLink path="/activation" text="License & Activation"></NavLink>
                                </li>
                                <li>
                                    <NavLink path="/visibility" text="Visibility Options" :disabled="!store.licenseInfo.valid"></NavLink>
                                </li>
                                <li>
                                    <NavLink path="/appearance" text="Appearance" :disabled="!store.licenseInfo.valid"></NavLink>
                                </li>
                                <li>
                                    <NavLink path="/instructions" text="Instructions"></NavLink>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
            <div class="col-span-2 leadsms-settings-content">
                <router-view></router-view>
            </div>
        </div>
        <div class="pr-4 pb-3 text-right" v-if="currRoute != 'activation' && currRoute != 'instructions'">
            <button @click="saveOptions()" class="min-w-[120px] rounded-md bg-brand-orange p-2 px-4 text-white hover:bg-brand-dark-orange">
                <LoadingIcon v-if="store.loading" />
                <span v-if="store.loading">Saving changes</span>
                <span v-else>Save Changes</span>
            </button>
        </div>
    </div>
</template>
  
<script setup>
import NavLink from './Common/NavLink.vue';
import LoadingIcon from './Common/LoadingIcon.vue';
import { useStore } from './../store';
import { useRouter } from 'vue-router';
import { reactive, computed } from 'vue';

const store = useStore();
const router = useRouter()

store.getLicenseInfo(() => {
    store.getOptions();
});

const currRoute = computed(() => {
    let currentPathObject = router.currentRoute.value; 
    return currentPathObject.name;
});

const saveOptions = () => {
    store.saveOptions();
}
</script>