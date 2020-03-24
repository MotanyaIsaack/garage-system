require('./bootstrap');

function ajaxGet (url) {
    return $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'GET',
        url:url
    });
}

function ajaxPost (url,data) {
    return $.ajax({
        url:'url',
        type:'POST',
        data:data
    })
}

