var register = {
    ajaxMethod: 'POST',

    add: function() {
        let formData = new FormData();

        formData.append('sum', $('#sum').val());
        formData.append('porpose', $('#porpose').val());
        let json = JSON.stringify({sum : +$('#sum').val(), porpose : $('#porpose').val()})

        console.log(json)

        //let data = JSON.stringify({});

        $.ajax({
            url: '/register',
            type: this.ajaxMethod,
            data: json,
            cache: false,
            processData: false,
            contentType: 'application/json',
            beforeSend: function(){

            },
            success: function(result){
                let hash = result.paymentId;
                console.log('/payment/paymentId=' + hash);
                window.location = '/payment/paymentId=' + hash;
            }
        });
    },

};

