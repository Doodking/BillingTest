<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->

    <title>Payment</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>
<body>
<div id="app">

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-3">
                        <div class="card-header">Billing and <a href="http://localhost:8000/" style="text-decoration: none; color: red;">Register order</a></div>
                        <div class="card-body">
                            <div class="col-md-8 order-md-1">
                                <form>

                                    <div class="row">
                                        <div class="col-4">
                                            <h4 class="mb-3">Payment</h4>
                                        </div>
                                        <div class="col-2">
                                            <input id="find" type="text" placeholder="find order by his id"/>

                                            <script>
                                                $('#find').keyup(function(){
                                                    let id = $('#find').val();
                                                    if(id == ''){
                                                        $('.order').empty();
                                                        payment.get()
                                                    }else {
                                                        let length = $(`.order`)[0].children.length;
                                                        let arrayOfCheckedBoxes = [];
                                                        for (let item of $(`.order`)[0].children) {
                                                            arrayOfCheckedBoxes.push(item.children[0].children[0].children[0].defaultValue);
                                                        }
                                                        if (!arrayOfCheckedBoxes.includes(id)) {
                                                            $('.order').empty();
                                                            $('.order').append(
                                                                `<h5>Order with that id doesn't exist</h5>`
                                                            );
                                                        } else {
                                                            $.ajax({
                                                                method: 'GET',
                                                                url: `/register/${id}`,
                                                                data: false,
                                                                cache: false,
                                                                processData: false,
                                                                contentType: 'application/json',
                                                                beforeSend: function () {

                                                                },
                                                                success: function (result) {
                                                                    $('.order').empty();
                                                                    if (Array.isArray(result)) {
                                                                        payment.get()
                                                                    } else {
                                                                        $('.order').append(
                                                                            `<div class="form-check">
                                                                       <input class="form-check-input" type="checkbox" value="${result.id}"  id="${result.id}">
                                                                       <label class="form-check-label" for="defaultCheck1">
                                                                         <h5>${result.sum}$ => ${result.porpose} (${result.id} id of order)</h5>
                                                                       </label>
                                                                     </div>`
                                                                        );
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" value=""  id="selectAll">
                                        <label class="form-check-label" for="defaultCheck1">
                                            SELECT ALL
                                        </label>
                                    </div>
                                    <div class="order">
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name on card</label>
                                            <input type="text" class="form-control" name="nameOf" id="name" placeholder="IVAN IVANOV" value="" required="">
                                            <small class="text-muted">Full name as displayed on card</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="number">Credit card number</label>
                                            <input type="text" class="form-control" id="number" name="cardNumber" placeholder="**** **** **** ****" required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="expiration">Expiration</label>
                                            <input type="text" class="form-control" id="expiration" placeholder="08/2024" required="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="cvv">CVV</label>
                                            <input type="text" class="form-control" id="cvv" placeholder="***" required="">
                                        </div>
                                    </div>
                                    <hr class="mb-4">
                                    <button class="btn btn-primary btn-lg btn-block" type="button" onclick="payment.delete()">PAY</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>
</body>


<script src="{{ asset('js/payment.js') }}"></script>


</html>
