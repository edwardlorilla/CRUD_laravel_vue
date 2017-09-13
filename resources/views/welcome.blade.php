<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
        <meta name="_token" content="{{ csrf_token() }}"/>
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div id="app" class="content">

            </div>
        </div>
        <script src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>


<div class="main-wrapper">
    <div class="header"><h1>Vue Shopping Cart</h1></div>
    <div id="vue">
        <cart :cart="cart" :cart-sub-total="cartSubTotal" :tax="tax" :cart-total="cartTotal" :checkout-bool="checkoutBool"></cart>
        <products :cart="cart" :cart-sub-total="cartSubTotal" :tax="tax" :cart-total="cartTotal" :products-data="productsData"></products>
        <checkout-area v-if="checkoutBool" :cart="cart" :tax="tax" :cart-sub-total="cartSubTotal" :cart-total="cartTotal" :products-data="productsData" :total-with-tax="totalWithTax"></checkout-area>
    </div>
</div>
