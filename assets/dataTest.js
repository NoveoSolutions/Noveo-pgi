function test(){
   let result = $.ajax({
        type: 'GET',
        url: '/api/clients',
        
        dataType: "json",
        success: function (response) {
            console.log(response)
        }
    })
    return result
} 
test();
console.log(test());


    