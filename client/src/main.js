// import './assets/main.css'

import { createApp } from "vue";
import { createPinia } from "pinia";
import { markRaw } from "vue";
import Toastify from 'vue3-toastify'
import '../axios'

import App from "./App.vue";
import router from "./router";

const app = createApp(App)
const pinia = createPinia()
pinia.use(({store}) => {
    store.router = markRaw(router)
})
app.use(router)
app.use(Toastify)
app.use(pinia)
app.mount('#app')
