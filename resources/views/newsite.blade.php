<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Articles Homeseite</title>
    {{--vergiss nicht rel="stylesheet"--}}
    <link rel="stylesheet" href="{{asset('css/homestyle.css')}}">
    <script src="https://unpkg.com/vue@3"></script>
</head>

<body>
{{--ANLEGEN DER KOMPONENTEN--}}
<div id="root-app" >
    <siteheader></siteheader>
    <component v-bind:is="cmp"></component>
    <sitefooter @change-body="showSitebodyOrImpressum"></sitefooter>
</div>

<div class="cart-items hidden" id="shopping-cart">
    <h2>Warenkorb</h2>
</div>
<div class="cookie" id="consent_pop_up">
    <p>By using this site you agree to our <a href="#">Terms and conditions</a>.
        Please <a id="accept" href="#">Accept</a> these before using our site.
    </p>
    <button id="acceptcookie">Accept Cookies</button>
    <button id="denycookie">Deny Cookies</button>

</div>

{{--SKRIPT FÜR DAS VUE JS--}}
<script type="module">
    import Siteheader from './js/siteheader.js'
    import Sitebody from './js/sitebody.js'
    import Sitefooter from './js/sitefooter.js'
    import Impressum from './js/impressum.js'
    //deklariere RootApp

    let myapp = Vue.createApp({
        data(){
            return{
                cmp: 'sitebody'
            }
        },
        components: {
            'siteheader': Siteheader,
            'sitebody': Sitebody,
            'sitefooter': Sitefooter,
            'impressum' : Impressum
        },
        methods:{
            showSitebodyOrImpressum: function (item){
                if(item == 'Impressum')
                    this.cmp = 'impressum'
                else{
                    navi.showMenu()
                    this.cmp = 'sitebody'

                }
            }
        },
        async mounted() {



            console.log("Starting Connection to Websocket Server");

            this.connection = new WebSocket('ws://localhost:8089/chat');

            this.connection.onopen =  () => {
                console.log('Web Socket connected');
                this.connectedStatus = 'In Kürze verbessern wir Abalo für Sie! Nach einer kurzen Pause sind wir wieder für Sie da! Versprochen.';
            }

            this.connection.onmessage = (e) => {
                //let response = JSON.parse(e.data);
                console.log('Connected', e.data);
                this.soldMsg = e.data;
            }

        }
    })
    myapp.mount('#root-app')
    import navbar from './js/navigationsmenu.js'

    let navi = new navbar()
    navi.showMenu()
</script>

{{--<script src="{{asset('/js/navigationsmenu.js')}}"></script>--}}

<script src="{{asset('/js/cookiecheck.js')}}"></script>
<script async src="{{asset('/js/warenkorb.js')}}"></script>
</body>
</html>

