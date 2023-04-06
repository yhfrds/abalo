<template>
    <div>
        <site-header-component></site-header-component>
        <div id="app">
            <div class="container">
                <div class="rightside">
                    <component v-bind:is="cmp"></component>
                    <button v-on:click="goToImp('Impressum')">Impressum</button>
                    <button v-on:click="goToImp('SiteBodyComponent')">Articles</button>
                </div>
            </div>
        </div>
        <site-footer-component></site-footer-component>
    </div>
</template>

<script>
import SiteHeaderComponent from "./components/articles/SiteHeaderComponent";
import SiteBodyComponent from "./components/articles/SiteBodyComponent";
import SiteFooterComponent from "./components/articles/SiteFooterComponent";
import Impressum from "./components/articles/Impressum";
import navbar from './js/navigationsmenu.js'

export default {
    components: {
        'SiteHeaderComponent': SiteHeaderComponent,
        'SiteBodyComponent': SiteBodyComponent,
        'SiteFooterComponent': SiteFooterComponent,
        'Impressum': Impressum
    },

    data() {
      return {
          cmp: 'SiteBodyComponent'
      }
    },

    methods: {
        goToImp(item) {
            this.cmp= item
        }
    }


}
</script>
