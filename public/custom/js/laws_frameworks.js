$(document).ready(function() {
    
    // Function to handle view mode
    $('#viewModeButton').click(function() {
       
        if ($("input[name='selectedIds[]']:checked").filter(':checked').length==1){
            location.href = $("input[name='selectedIds[]']:checked").data('url');
        }else if ($("input[name='selectedIds[]']:checked").filter(':checked').length>1){
            Swal.fire({
                title: "",
                text: "Please select only one to view.",
                confirmButtonColor: "#0d6efd",
                icon: "info"
            });
        }else{
            Swal.fire({
                title: "",
                text: "Please select to view.",
                confirmButtonColor: "#0d6efd",
                icon: "info"
            });
        }
        
    });

    // Function to handle deletion of selected items
    $('#deleteModeButton').click(function() {
        if ($("input[name='selectedIds[]']:checked").filter(':checked').length>0){
            Swal.fire({
                title: "Are you sure you want to delete selected item/s?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    var selectedIds = [];
                    $("input[name='selectedIds[]']:checked").each(function() {
                        selectedIds.push($(this).val());
                    });
                    $('#selectedIds').val(selectedIds.join(','));
                    $('#deleteSelectedForm').submit();
                }
            });
        }else{
            Swal.fire({
                title: "",
                text: "Please select item/s to delete.",
                confirmButtonColor: "#0d6efd",
                icon: "info"
              });
        }
        
    });

    $('#copySelectedItems').click(function() {
        if ($("input[name='selectedIds[]']:checked").length > 0) {
            var selectedItems = [];
            $("input[name='selectedIds[]']:checked").each(function() {
                var row = [];
                var link = $(this).closest('tr').find('td:eq(1)').find('a').attr('href');
                var title = $(this).closest('tr').find('td:eq(1)').text();
                var published = $(this).closest('tr').find('td:eq(7)').text();
                var description = $(this).closest('tr').find('td:eq(4)').text();
                var publisher = $(this).closest('tr').find('td:eq(6)').text();
                row.push(title + ' Published by ' + publisher + ' on ' + published);
                row.push(description);
                row.push('Click here to read the source article');
                row.push(link);
                selectedItems.push(row.join('\n'));


                /*$(this).closest('tr').find('td').each(function() {
                    if ($(this).find('a').length > 0) {
                        // Include title in one column and URL link in another column
                        link = $(this).find('a').attr('href');
                        row.push($(this).find('a').text().trim() + ' Published on ' +);
                        //row.push($(this).find('a').attr('href'));
                    } else {
                        row.push($(this).text().trim());
                    }
                });
                selectedItems.push(row.join('\t'));*/
            });
    
            var clipboardData = selectedItems.join('\n\n');
    
            navigator.clipboard.writeText(clipboardData)
                .then(function() {
                    Swal.fire({
                        title: "Selected items copied to clipboard!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(function(error) {
                    console.error('Error copying to clipboard: ', error);
                    Swal.fire({
                        title: "Error copying to clipboard",
                        text: "Please try again or copy manually.",
                        icon: "error",
                        confirmButtonColor: "#0d6efd"
                    });
                });
        } else {
            Swal.fire({
                title: "",
                text: "Please select item/s to copy.",
                confirmButtonColor: "#0d6efd",
                icon: "info"
            });
        }
    });
    


});
