import './bootstrap';
import { createApp } from "vue";
import CurrentDateTime from "./components/CurrentDateTime.vue";

// Create Vue application
createApp({})
    .component("current-date-time", CurrentDateTime) // Register component
    .mount("#app"); // Mount Vue app
