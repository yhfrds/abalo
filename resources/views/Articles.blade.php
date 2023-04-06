<?php if (!empty($hasil)) echo $hasil
?>
    <!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Articles Homeseite</title>
    {{--vergiss nicht rel="stylesheet"--}}
    {{--    <link rel="stylesheet" href="{{asset('css/homestyle.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/homestyle.css')}}">
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
<div class="cart-items hidden" id="shopping-cart">
    <h2>Warenkorb</h2>
</div>
<div class="container">
    <div class="rightside">
        <div id="app">
            <p id="whichUser">Angemeldet als:
                <span v-if="(userId>1 && userId <= 4)">Visitor</span>
                <span v-if="userId==1 ||(userId > 4)">Seller</span>
                @{{ userId }}</p>
            <button @click="saveUserIdInLocalStorage(1)">Admin+Seller 1</button>
            <button @click="saveUserIdInLocalStorage(5)">Seller 5</button>
            <button @click="saveUserIdInLocalStorage(6)">Seller 6</button>
            <button @click="saveUserIdInLocalStorage(7)">Seller 7</button>
            <button @click="saveUserIdInLocalStorage(2)">Visitor 2</button>
            <button @click="saveUserIdInLocalStorage(3)">Visitor 3</button>
            <button @click="saveUserIdInLocalStorage(4)">Visitor 4</button>
            <br>

            <br>
            <input type="text" v-model="search" placeholder="search article">
            <table>
                <thead>
                <tr>
                    <th>Bild</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Preis</th>
                    <th>Beschreibung</th>
                    <th>CreatorID</th>
                    <th>Datum</th>
                </tr>
                </thead>
                <tbody>
                <!-- Hier ist alles eigentlich fast gleich wie alten Blade Datei.
                               Es gibt bestimmt einige Änderungen und Funktionsaufrufe in Attributen-->
                <template v-for="(article,index) in filteredArticles">
                    {{--                    <template v-if="index<5">--}}
                    <tr class="shop-item">
                        <td><img class="artikelImg" v-bind:src="`/articelpictures/${article.id}.jpg`" alt="no picture"
                                 width="150" height="100"></td>
                        <td class="artikelId" id="article.id">@{{article.id}}</td>
                        <td class="artikelName">
                            @{{article.ab_name}}
                            <br>
                            <button v-if="userId == article.ab_creator_id"
                                    @click="artikelAngebotAnbieten(article.id, article.ab_name)">Artikel jetzt als
                                Angebot anbieten
                            </button>
                            <button v-if="userId != article.ab_creator_id" @click="favorite(article.id,article.ab_name)"
                                    style="background-color: mediumseagreen">Interessiert
                            </button>
                        </td>
                        <td class="artikelPrice">@{{article.ab_price}}</td>
                        <td class="artikelDescription">@{{article.ab_description}}</td>
                        <td class="artikelCreatorId">@{{article.ab_creator_id}}</td>
                        <td class="artikelDate">@{{article.ab_createdate}}</td>
                        <td>
                            <button class="shop-item-button" type="button">+</button>
                        </td>
                    </tr>
                    {{--                    </template>--}}
                </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="cookie" id="consent_pop_up">
    <p>By using this site you agree to our <a href="#">Terms and conditions</a>.
        Please <a id="accept" href="#">Accept</a> these before using our site.
    </p>
    <button id="acceptcookie">Accept Cookies</button>
    <button id="denycookie">Deny Cookies</button>
</div>
<script src="public/js/warenkorb.js"></script>
<script type="module">
    let conn = new WebSocket('ws://localhost:8085/chat');
    conn.onmessage = function(e) {
        let datas = e.data.split(',');
        //Targeted users : datas[1]
        let rawTargetedUsers = datas[1].split('|');
        var targetedUsers = rawTargetedUsers.filter(e => e !== '')

        let loggedInUser = document.getElementById('whichUser').innerText.split(' ').pop()

        if(targetedUsers.includes(loggedInUser)){
            alert(datas[2]);
        }
        //Message : datas[2]
        //ID of article that is on sale : datas[3]
    };
    let myapp = Vue.createApp({
        data() {
            return { //lege für das Projekt gebrauchte Attribute
                articles: [], //speichert alle Infos von jedem Artikel
                search: '', //speichert den gesuchten Wert
                userId: '',
                interesse: {
                    interesse1: [],
                    interesse5:[]
                }
            }
        },
        mounted() { //hole Daten aus der Datenbank mit Webservice
            let xhr = new XMLHttpRequest();
            xhr.open('get', '/api/articles');
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                        this.$data.articles = JSON.parse(xhr.responseText);
                    }
                    if (xhr.status == 404) {
                        console.log('File or resource not found');
                    }
                }
            }
            xhr.send();
        },
        /* die Methode muss in "computed: ..." angelegt anstatt in "methods: ..."
        die Gründe warum ist das so muss ich nochmal nachschauen
         */
        computed: {
            filteredArticles() { //die Methode wird aufgerufen jedes Mal in search bar was geändert wird
                if (this.search.length >= 3) {
                    let allArticles = this.articles.filter(article => article.ab_name.toLowerCase().includes(this.search.toLowerCase()))
                    let fiveArticles = allArticles.slice(0, 5)
                    return fiveArticles //gebe nur 5 ersten Artikels zurück
                } else
                    return this.articles
            }
        },
        methods: {
            saveUserIdInLocalStorage(id) {
                localStorage.setItem('userid', id)
                this.$data.userId = id
            },
            artikelAngebotAnbieten(artikelid, artikelname) {

                axios.get('/api/artikelInAngebot?artikelid=' + artikelid + '&artikelname=' + artikelname + '&userid=' + this.userId)
                    .then(response => {
                        console.log(response)
                        alert(artikelname + " ist jetzt im Angebot")
                    }).catch(reason => {
                    alert("An error occured when making the angebot")
                })
            },
            favorite(artikelId, artikelName) {
                debugger
                axios.post(
                    '/api/likingArticle',
                    {
                        artikelId: artikelId,
                        artikelName: artikelName,
                        userId: this.$data.userId
                    }
                ).then(response => {
                    console.log(response)
                    // alert(response)
                    alert(artikelName + " is liked in database")
                }).catch(err => {
                    console.log(err, err.response)
                    alert("An error occured when making the angebot")
                })
                /*if(this.userId == 1){
                    this.$data.interesse.interesse1.push(artikelId)
                    console.log(this.interesse.interesse1)
                }
                else if (artikelId==5){
                    console.log(interesse5)
                }*/


            }
        }
    }).mount('#app')

    import navbar from './js/navigationsmenu.js'

    let navi = new navbar;
    navi.showMenu();
</script>
<script src="{{asset('/js/warenkorb.js')}}"></script>
<!--<script src="{{asset('/js/navigationsmenu.js')}}"></script>-->
<script src="{{asset('/js/cookiecheck.js')}}"></script>
{{--<script src="{{asset('/js/warenkorb.js')}}"></script>--}}
</body>
</html>
