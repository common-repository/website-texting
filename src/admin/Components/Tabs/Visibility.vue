<template>
    <div :class="{'disabled': !store.licenseInfo.valid || store.loading }">
        <div class="mb-6 text-center">
        </div>
        <form action="#">
            <div class="mb-6">
                <p><strong>Determines where on your site the text widget is displayed.</strong></p>
                <p class="mb-4"><strong>For best results, we recommend leaving at the default.</strong></p>
                <div class="flex">
                    <label for="show-in-all-pages" class="flex items-center cursor-pointer">
                        <div class="pr-2 w-[300px]">Always show LEADsms widget on every page</div>
                        <!-- toggle -->
                        <div class="relative">
                            <input id="show-in-all-pages" v-model="store.options.visibility.inAllPages" type="checkbox" class="hidden" />
                            <!-- path -->
                            <div class="toggle-path bg-gray-200 w-9 h-5 rounded-full shadow-inner"></div>
                            <!-- crcle -->
                            <div class="toggle-circle absolute w-3.5 h-3.5 bg-white rounded-full shadow inset-y-0 left-0">
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div v-if="!store.options.visibility.inAllPages">
                <div class="mb-6">
                    <div class="flex">
                        <label for="show-in-home-only" class="flex items-center cursor-pointer">
                            <div class="px-2 w-[280px]">Show on Home Page</div>
                            <!-- toggle -->
                            <div class="relative">
                                <input id="show-in-home-only" v-model="store.options.visibility.homepageOnly" type="checkbox"
                                    class="hidden" />
                                <!-- path -->
                                <div class="toggle-path bg-gray-200 w-9 h-5 rounded-full shadow-inner"></div>
                                <!-- crcle -->
                                <div
                                    class="toggle-circle absolute w-3.5 h-3.5 bg-white rounded-full shadow inset-y-0 left-0">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex">
                        <label for="show-in-pages-only" class="flex items-center cursor-pointer">
                            <div class="px-2 w-[280px]">Show on Pages</div>
                            <!-- toggle -->
                            <div class="relative">
                                <input id="show-in-pages-only" v-model="store.options.visibility.pagesOnly" type="checkbox"
                                    class="hidden" />
                                <!-- path -->
                                <div class="toggle-path bg-gray-200 w-9 h-5 rounded-full shadow-inner"></div>
                                <!-- crcle -->
                                <div
                                    class="toggle-circle absolute w-3.5 h-3.5 bg-white rounded-full shadow inset-y-0 left-0">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex">
                        <label for="show-in-posts-only" class="flex items-center cursor-pointer">
                            <div class="px-2 w-[280px]">Show on Posts</div>
                            <!-- toggle -->
                            <div class="relative">
                                <input id="show-in-posts-only" v-model="store.options.visibility.postsOnly" type="checkbox"
                                    class="hidden" />
                                <!-- path -->
                                <div class="toggle-path bg-gray-200 w-9 h-5 rounded-full shadow-inner"></div>
                                <!-- crcle -->
                                <div
                                    class="toggle-circle absolute w-3.5 h-3.5 bg-white rounded-full shadow inset-y-0 left-0">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import { reactive } from 'vue';
import { useStore } from '../../store';

const store = useStore();

const state = reactive({
    visibility: {
        inAllPages: true,
        homepageOnly: false,
        pagesOnly: false,
        postsOnly: false
    }
});


</script>