function deleteImage(id) {

    var csrfName = $('.csrf_update_gallery').attr('name'); // Value specified in $config['csrf_token_name']
    var csrfHash = $('.csrf_update_gallery').val(); // CSRF hash


    if (confirm('Are you sure you want to delete?')) {
        var dataJson = { [csrfName]: csrfHash, id: id };
        $.ajax({
            url: base_url + 'Admin/deleteGallery',
            type: 'POST',
            dataType: 'html',
           
            data: dataJson, 
            success: function(data) {
                $('#image_delete_' + id).hide();
                location.reload();
            }

        });
    }




}

function deleteRoomTypeImage(id) {


    var csrfName = $('.csrf_update_room_type').attr('name'); // Value specified in $config['csrf_token_name']
    var csrfHash = $('.csrf_update_room_type').val(); // CSRF hash

    if (confirm('Are you sure you want to delete?')) {
        var dataJson = { [csrfName]: csrfHash, id: id };
        $.ajax({
            url: base_url + 'Admin/deleteRoomTypeImage',
            type: 'POST',
            
            dataType: 'html',
            data: dataJson, 
            success: function(data) {
                $('#image_delete_' + id).hide();
                location.reload();
            }

        });
    }

}