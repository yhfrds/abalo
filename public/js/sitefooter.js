export default {
    template: `
        <div style='height: 50px;background-color: mediumseagreen; position: fixed; bottom: 0; width: 100vw'>
        <div style="display: flex; justify-content: center">
            <a href="#"v-on:click="goToImp('Impressum')" style="margin: 5px">Impressum</a>
            <a href="#" v-on:click="goToImp('Sitebody')" style="margin: 5px">Articles</a>
<!--            <a href="/newsite" v-on:click="goToImp('Sitebody')" style="margin: 5px">Articles</a>-->
        </div>

        </div>`,
    methods: {
        goToImp(item) {
            // console.log("Item",item)
            this.$emit('changeBody',item)

        }

    }
}
