function deleteImage(id) {

    if (confirm('Are you sure you want to delete?')) {
        $.ajax({
            url: base_url + 'Admin/deleteGallery',
            type: 'POST',
            dataType: 'html',
            data: { 'id': id },
            success: function(data) {
                $('#image_delete_' + id).hide();
            }

        });
    }




}

function deleteRoomTypeImage(id) {

    if (confirm('Are you sure you want to delete?')) {
        $.ajax({
            url: base_url + 'Admin/deleteRoomTypeImage',
            type: 'POST',
            dataType: 'html',
            data: { 'id': id },
            success: function(data) {
                $('#image_delete_' + id).hide();
            }

        });
    }

}