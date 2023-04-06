export default{
    data() {
        return {
            count: 1
        }
    },
    template: "<p>{{count}}</p><br><button @click='increment'>Increment</button><button @click='decrement'>Decrement</button>",
    methods:{
        increment() {
            this.count++
        },
        decrement() {
            this.count--
        }
    }
}
