
/*Function that performs ajax get requests*/
function ajaxGet(url) {
    return $.ajax({
        url:url,
        type:'GET',
        dataType:'JSON'
    });
}

/*Function that deals with normal ajax requests*/
function ajaxPost(url,data) {
    return $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function (res) {
            let message = res.msg;
            if (res.ok){
                alertify.notify(message,'success','2');
            }else{
                if (typeof message == 'object'){
                    for(const property in message){
                        alertify.notify(`${message[property]}`,'error','2')
                    }
                }else{
                    alertify.notify(message,'error','2');
                }

            }
        },
        error:function () {
            alertify.notify('Could not process your request at this time','error','2');
        }
    });
}



/*Function that returns form data*/
const form_data = function (event,datatable) {
    const _this = event.target;
    const tr = $(_this).closest('tr');
    const rowIndex = datatable.row(tr).index();
    return datatable.rows(rowIndex).data()[0];
};

/*Function that fills form fields edit data*/
const fill_form_with_edit_data = function (event,datatable,form,action) {
    action.val('edit');
    const rowData = form_data(event,datatable);
    Object.keys(rowData).forEach(fieldName => {
        form.find(`input#${fieldName}`).val(rowData[fieldName]);
    });
};

/*Function that validates and checks if form fields are empty or null*/
const validate_form_fields = function (data) {
    let exists_error = false;
    for (const field_name in data){
        if(`${data[field_name]}` == null || `${data[field_name]}` === ''){
            alertify.notify('Please fill the ' +`${field_name}`+ ' field','error','3');
            exists_error = true;
        }
    }
    return exists_error;
};


