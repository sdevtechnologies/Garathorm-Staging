
$(document).ready(function(){
    

   

    $('#copyLink').click(function() {
        
    
            var clipboardData = $('#url').val();
    
            navigator.clipboard.writeText(clipboardData)
                .then(function() {
                    Swal.fire({
                        title: "URL copied to clipboard!",
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
        
    });
    $('#copyDescription').click(function() {
        
    
        var clipboardData = $('#description').val();

        navigator.clipboard.writeText(clipboardData)
            .then(function() {
                Swal.fire({
                    title: "Description copied to clipboard!",
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
    
    });

    $('.btn-paste').click(function(){
        var container = $(this).closest('.pasteContainer');
        var inputDiv = container.find('.inputDiv');
        var textBox = inputDiv.find('input');
        navigator.clipboard.readText()
        .then(text => {
            if (textBox.length>0){
                textBox.val(text);
            }else{
                textBox = inputDiv.find('textarea');
                textBox.val(text);
            }
        })
        .catch(err => {
          console.error('Failed to read clipboard contents: ', err);
        
        });

        
        
    })




});