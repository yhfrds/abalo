require('./bootstrap');
// Require Vue
window.Vue = require('vue').default;
const axios = require('axios');
// Register Vue Components
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Initialize Vue
const app = new Vue({
    el: '#app',
});
Vue.createApp({
    data: function() {
        return {
            message: 'Beispiel'
        }
    }
}).mount('#app');
