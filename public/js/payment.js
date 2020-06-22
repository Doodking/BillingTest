

var payment = {
    //ajaxMethod: 'GET',

    get: function() {

        $.ajax({
            method: 'GET',
            url: '/register',
            data: false,
            cache: false,
            processData: false,
            contentType: 'application/json',
            beforeSend: function(){

            },
            success: function(result){
                if(result.length === 0){
                    location.replace('http://localhost:8000/');
                }
                for(let i = 0; i < result.length; i++){
                    $('.order').append(
                        `
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                   <input class="form-check-input" type="checkbox" value="${result[i].id}"  id="${result[i].id}">
                                   <label class="form-check-label" for="defaultCheck1">
                                        <h5>${result[i].sum}$ => ${result[i].porpose} (${result[i].id} id of order)</h5>
                                   </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="col-1">
                                    <a type="button" onclick="payment.deleteById(${result[i].id})">
                                         <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                             <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                         </svg>
                                    </a>
                                </div>
                            </div>
                        </div>`
                    );
                }
            }
        });
    },
    delete: function() {

        let length = $(`.order`)[0].children.length;
        let count = 0;
        let arrayOfCheckedBoxes = [];
        for (let item of $(`.order`)[0].children) {
            if(item.children[0].children[0].children[0].checked) {
                count++;
                arrayOfCheckedBoxes.push(item.children[0].children[0].children[0].defaultValue);
            }
        }
        if(count === 0){
            alert('You didn\'t select any order');
        }else{
            let json = JSON.stringify({name : $('#name').val(), number : $('#number').val(), expiration: $('#expiration').val(), cvv: $('#cvv').val(), array: arrayOfCheckedBoxes})
            console.log(json)
            $.ajax({
                method: 'DELETE',
                url: '/register',
                data: json,
                cache: false,
                processData: false,
                contentType: 'application/json',
                statusCode: {
                    408: function () { // выполнить функцию если код ответа HTTP 404
                        alert("Data of your card is invalid");
                    },
                },
                beforeSend: function(){

                },
                success: function(result){
                    $(`.order`).empty();

                    payment.get()
                }
            });
        }
    },
    deleteById: function(id) {
        console.log(id)

        // let length = $(`.order`)[0].children.length;
        // let arrayOfCheckedBoxes = [];
        // for(let i = 1; i <= length; i++) {
        //     arrayOfCheckedBoxes.push(+$(`#${i}`).val());
        // }
        // let maxId = Math.max(...arrayOfCheckedBoxes);

        // if(id > maxId){
        //     alert('Order')
        // }

        $.ajax({
            method: 'DELETE',
            url: `/register/${id}`,
            data: false,
            cache: false,
            processData: false,
            contentType: 'application/json',
            beforeSend: function(){

            },
            success: function(result){
                console.log(result)
                $(`.order`).empty();

                payment.get()
            }
        });
    },


};

$('#selectAll').on('click', function(){
    let length = $(`.order`)[0].children.length;
    let arrayOfCheckedBoxes = [];
    for (let item of $(`.order`)[0].children) {
        if(item.children[0].children[0].children[0].checked === false) {
            item.children[0].children[0].children[0].checked = true;
        }else{
            item.children[0].children[0].children[0].checked = false;
        }
    }
});

payment.get();

