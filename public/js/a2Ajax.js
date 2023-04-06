setInterval(function () {
    let message = document.querySelector(".message");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/abalo/public/static/message.json");
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let data = JSON.parse(this.response)
            message.innerHTML = '<h1>' + data.message + '</h1>';
            console.log("working");
        } else {
            message.innerHTML = xhr.statusText;
        }
    }
    xhr.send();
},3000);
