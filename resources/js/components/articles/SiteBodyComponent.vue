<template>
    <div class="arctilesBody">
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
            <tr class="shop-item" v-for="article in filteredArticles">
                <td><img class="artikelImg" v-bind:src="'/articelpictures/'+article.id+'.jpg'" alt="no picture"
                         width="150" height="100"></td>
                <td class="artikelId">{{article.id}}</td>
                <td class="artikelName">{{article.ab_name}}</td>
                <td class="artikelPrice">{{article.ab_price}}</td>
                <td class="artikelDescription">{{article.ab_description}}</td>
                <td class="artikelCreatorId">{{article.ab_creator_id}}</td>
                <td class="artikelDate">{{article.ab_createdate}}</td>
                <td>
                    <button class="shop-item-button" type="button">+</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'SiteBodyComposer',
    data: function () {
        return {
            articles: [],
            search: ''
        }
    },

    mounted() {
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

    computed: {
        filteredArticles() {
            if (this.search.length >= 3)
            {
                let allArticles = this.articles.filter(article => article.ab_name.toLowerCase().includes(this.search.toLowerCase()))
                let fiveArticles = allArticles.slice(0,5)
                return fiveArticles //gebe nur 5 ersten Artikels zurück
            }
            else {
                return this.articles
            }
        }
    },
}
</script>

