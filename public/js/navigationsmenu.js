"use strict";
export default class navigationsmenu{
    constructor() {
        this.navi = ["Home", "Kategorien", "Verkaufen", "Unternehmen","newarticle"];
        this.unternehmen = ["Philosophie", "Karriere"];
    }
    showMenu(){
        var label = document.createElement("label");
        /*label.setAttribute("class","logo");
        label.innerText ="Firdaus&Carbonell";
        label.setAttribute('style',`height:100px; width:200px; font-size:30px; padding:30px;`);*/

        var ul1 = document.createElement("ul");
        ul1.setAttribute("id", "ul1");
        this.navi.forEach(value => {
            var li1 = document.createElement("li");

            var a1 = document.createElement("a");
            a1.setAttribute("href", '/'+value);
            a1.innerText = value;

            //appende child zu parent
            li1.appendChild(a1);
            ul1.appendChild(li1);

            if(value == "Unternehmen"){

                var ul2 = document.createElement("ul");

                this.unternehmen.forEach(erweiterung=>{
                    var li2 = document.createElement("li");
                    var a2 = document.createElement("a");
                    a2.setAttribute("href", '/'+erweiterung);
                    a2.innerText = erweiterung;

                    li2.appendChild(a2);
                    ul2.appendChild(li2);
                });

                li1.appendChild(ul2);
            }
        });
        //M5 A1: add new Link to refactored Artikeleingabe
        let li_artikelEingabe = document.createElement("li");

        let artikelEingabe = document.createElement("a");
        artikelEingabe.setAttribute("href", '/newarticlerefactor');
        artikelEingabe.innerText = "Artikeleingabe Refactoring";

        li_artikelEingabe.appendChild(artikelEingabe);
        ul1.appendChild(li_artikelEingabe);

        //variable für Sidebar
        var navsidebar = document.createElement("nav");
        navsidebar.setAttribute("class","navigation");
        navsidebar.append(label);
        navsidebar.appendChild(ul1);

        //ich setze hier ein Timeout, um zu warten bis alle skripte fertig durchgeführt
        setTimeout(function (){
            document.getElementsByClassName("container")[0].insertAdjacentElement('afterbegin',navsidebar);
        },50)

    }
}
/*var navi = new navigationsmenu();
navi.showMenu();*/






