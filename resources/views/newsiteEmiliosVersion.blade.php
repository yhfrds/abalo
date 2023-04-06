<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Articles Homeseite</title>
    <link rel="stylesheet" href="{{asset('css/homestyle.css')}}">
</head>

<body>
<div id="app"></div>

<div class="cart-items hidden" id="shopping-cart">
    <h2>Warenkorb</h2>
</div>
<div class="cookie" id="consent_pop_up">
    <p>By using this site you agree to our <a href="#">Terms and conditions</a>.
        Please <a id="accept" href="#">Accept</a> these before using our site.
    </p>
    <button id="acceptcookie">Accept Cookies</button>
    <button id="denycookie">Deny Cookies</button>
</div>s

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/navigationsmenu.js') }}" defer></script>
<script src="{{asset('/js/cookiecheck.js')}}"></script>
<script src="{{asset('/js/warenkorb.js')}}"></script>
</body>
</html>
