export default {
    data() {
        return { //lege für das Projekt gebrauchte Attribute
            articles: [], //speichert alle Infos von jedem Artikel
            search: '', //speichert den gesuchten Wert
            netxtId: 5,
            currentPage: 1,
            pageSize: 5,
            visibleTodos: []
        }
    },
    mounted() { //hole Daten aus der Datenbank mit Webservice
        let xhr = new XMLHttpRequest();
        xhr.open('get', '/api/articles');
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    this.$data.articles = JSON.parse(xhr.responseText);
                    this.beforePage()
                }
                if (xhr.status == 404) {
                    console.log('File or resource not found');
                }
            }
        }
        xhr.send();
    },
    /* die Methode muss in "computed: ..." angelegt anstatt in "methods: ..."
    die Gründe warum ist das so muss ich nochmal nachschauen*/

    computed: {
        filteredArticles() { //die Methode wird aufgerufen jedes Mal in search bar was geändert wird
            if (this.search.length >= 3) {
                let allArticles = this.visibleTodos.filter(article => article.ab_name.toLowerCase().includes(this.search.toLowerCase()))
                let fiveArticles = allArticles.slice(0, 5)
                return fiveArticles //gebe nur 5 ersten Artikels zurück
            } else
                return this.visibleTodos
        }
    },
    template: `
        <div class="container">
        <div class="rightside">
            <div id="app">
                <input type="text" v-model="search" placeholder="search article" style="width: 99%; height: 20px">
                <button @click="beforePage"><</button>
                <button @click="afterPage">></button>
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
                    <tr class="shop-item" v-for="article in filteredArticles">
                        <td><img class="artikelImg" v-bind:src="'/articelpictures/'+article.id+'.jpg'" alt="no picture"
                                 width="150" height="100"></td>
                        <td class="artikelId">{{ article.id }}</td>
                        <td class="artikelName">{{ article.ab_name }}</td>
                        <td class="artikelPrice">{{ article.ab_price }}</td>
                        <td class="artikelDescription">{{ article.ab_description }}</td>
                        <td class="artikelCreatorId">{{ article.ab_creator_id }}</td>
                        <td class="artikelDate">{{ article.ab_createdate }}</td>
                        <td>
                            <button class="shop-item-button" type="button" onclick="addToCartClicked">+</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    `,
    methods: {
        beforePage(){
            if(this.currentPage == 1){
                this.visibleTodos = this.articles.slice(0,5)
                return
            }
            this.currentPage--
            this.visibleTodos = this.articles.slice(this.currentPage*this.pageSize,(this.currentPage*this.pageSize)+this.pageSize)

        },
        afterPage(){

            this.visibleTodos = this.articles.slice(this.currentPage*this.pageSize,(this.currentPage*this.pageSize)+this.pageSize)
            this.currentPage++
        }/*,
        showAll(){
            debugger
            this.visibleTodos = this.articles
        }*/
    }
}
