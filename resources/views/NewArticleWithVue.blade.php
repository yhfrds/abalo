<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Abalo new article - M2-9 : Artikeleingabe</title>
{{--    <link rel="stylesheet" href="{{asset('css/newArticleStyle.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/newArticleStyle.css')}}">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@3"></script>
</head>
<body>
<p>Heyy, you are in the site of refactored NewArticle</p>
<section id="article">
    <div id="divArticleForm" class="article__div">
        <form action="articles" method="post" id="articleForm" @submit.prevent="processForm" class="article__form">
            <div id="title"><h2 id="h2Titel">Artikel Einfügen</h2></div>
            <div id="setArticle" class="input-edit">
                <p id="pArticle">Artikel:</p>
                <input id="name" type="text" name="name" placeholder="Bitte geben Sie die Artikel name ein."
                       v-model="articlename" @blur="validateName">
                <div id="divErrorMsgArticle" class="error__div">
                    <span id="name-error error-text" v-if="errors.name" class="error__div__span--active">Name is empty</span>
                </div>
            </div>
            <div id="setPrice" class="input-edit">
                <p id="pPrice">Preis:</p>
                <input id="price" type="text" name="price" placeholder="Bitte geben Sie die Preis ein."
                       v-model="articleprice" @blur="validatePrice">
                <div id="divErrorMsg" class="error__div">
                    <span id="price-error error-text" v-if="errors.price" class="error__div__span--active">Price can't be lower than 0</span>
                </div>

            </div>
            <div id="setDescription" class="input-edit">
                <p id="pPrice">Beschreibung:</p>
                <input id="description" type="text" name="description" placeholder="Beschreiben Sie Ihr Wunschartikeln."
                       v-model="articledescription" @blur="validateDescription">
                <div id="divErrorMsgDescription" class="error__div">
                    <span id="description-error error-text" v-if="errors.description" class="error__div__span--active">Description is empty</span>
                </div>
            </div>
            <div id="setSubmit" class="input-edit">
                <input id="submit" class="submit__btn" type="submit" name="submit" value="Speichern">
            </div>
        </form>
    </div>
</section>

<script type="module">
    let formularApp = Vue.createApp({
        data() {
            return {
                articlename: "",
                articleprice: 0,
                articledescription: "",
                errors: {
                    name: false,
                    price: false,
                    description: false
                }
            }
        },
        methods: {
            processForm: function () {
                console.log({name: this.articlename, price: this.articleprice, description: this.articledescription})
                debugger

                if((!this.errors.name&&!this.errors.name&&!this.errors.name)){
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200) {
                                console.log(xhr.responseText);
                            }
                            if (xhr.status == 404) {
                                console.log('File or resource not found');
                            }
                        }
                    }
                    let toSend = {
                        ab_name: this.articlename ,
                        ab_price: this.articleprice,
                        ab_description: this.articledescription
                    }
                    const jsonString = JSON.stringify(toSend);
                    xhr.open('post', '/api/articles', true);
                    xhr.setRequestHeader("Content-Type", "application/json");
                    xhr.send(jsonString);
                    alert("Succesfully saved")
                }else{
                    console.log({name: this.errors.name, price: this.errors.price, description: this.errors.description})
                    alert("Can't save in database. some entries might be empty or unacceptable")
                }
            },
            validateName: function () {
                const checkedName = this.articlename.trim()
                if (checkedName === "") this.errors.name = true
                else
                    this.errors.name = false;
            },
            validatePrice: function () {
                const checkedPrice = this.articleprice
                if (checkedPrice < 0) this.errors.price = true;
                else
                    this.errors.price = false;
            },
            validateDescription: function () {
                const checkedDescription = this.articledescription.trim()
                if (checkedDescription==="") this.errors.description = true;
                else
                    this.errors.description = false;
            },

        }
    })
    formularApp.mount('#article')
</script>
</body>
</html>
