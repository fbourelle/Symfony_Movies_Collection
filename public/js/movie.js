function searchInMovie(){

    $('#search_field').on('keyup', function(){
        let ky = $('#search_field').val();
        console.log(ky);

    });
}

$(function(){searchInMovie()});
