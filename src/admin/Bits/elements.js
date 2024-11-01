import { createApp } from 'vue';
import { createPinia } from 'pinia';

const pinia = createPinia();
const app = createApp({});

app.use(pinia);

export default app;
