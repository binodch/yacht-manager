/* Script goes here */

jQuery(document).ready(function ($) {

    $('.key-file-edit').on('click', function (e) {
        e.preventDefault();
        $('#yacht-key-file-uploaded').val('no');
        if ($('.key-upload-wrap').hasClass('wrap-hide')) {
            $('.key-upload-wrap').removeClass('wrap-hide');
        }
        $('.key-uploaded').addClass('wrap-hide');
    });
    
    $('#yacht-manager-save-btn').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let companyUri = $('#yacht-company-uri').val();
        let keyId = $('#yacht-key-id').val();
        let keyFileInDir = $('#yacht-key-file-uploaded').val();
        let privateKeyFile = '';
        let loadingLoader = $('.yacht-loading-loader'); // Ensure this exists
        let formInputs = $('#yacht-manager-form input, #yacht-manager-form button'); // Select all inputs and button

        // Disable inputs and button, add blur effect
        formInputs.prop('disabled', true).addClass('blurred');

        // Check if file is required
        if (keyFileInDir === 'no') {
            privateKeyFile = $('#yacht-private-key-upload')[0].files[0]; // Get uploaded file
            if (!privateKeyFile) {
                alert('All fields are required, including the private key file.');
                console.log('All fields are required, including the private key file.');
                formInputs.prop('disabled', false).removeClass('blurred'); // Restore inputs
                return;
            }
            
            // Validate file format (only .pem allowed)
            let fileName = privateKeyFile.name;
            let fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileExtension !== 'pem') {
                alert('Invalid file type. Please upload a .pem file.');
                console.log('Invalid file type. Only .pem files are allowed.');
                formInputs.prop('disabled', false).removeClass('blurred'); // Restore inputs
                return;
            }
        }

        // Validate text fields
        if (companyUri.trim() === '' || keyId.trim() === '') {
            alert('All fields are required');
            console.log('All fields are required');
            formInputs.prop('disabled', false).removeClass('blurred'); // Restore inputs
            return;
        }

        // Append form data
        formData.append('action', 'admin_setting_input');
        formData.append('company_uri', companyUri);
        formData.append('key_id', keyId);
        formData.append('key_file_in_dir', keyFileInDir);
        formData.append('nonce', ajax_object.ajax_nonce);

        // Append file if uploaded
        if (privateKeyFile) {
            formData.append('private_key_file', privateKeyFile);
        }

        // Show loader
        loadingLoader.show();
        $('.yacht-loader-wrap').show();
        $('.yacht-dialog-wrap').show();
        if( $('.yacht-connection-response') ) {
            $('.yacht-connection-response').remove();
        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (response) {
                $('.yacht-loader-wrap').hide();
                $('.yacht-dialog-wrap').hide();
                
                if (response.success) {
                    $('.yacht-loading-dialog').append('<div class="yacht-connection-response yacht-response-success">API connection successful</div>');
                    console.log('Settings saved successfully.');
                } else {
                    console.log(response.data.message || 'Error saving settings.');
                    $('.yacht-loading-dialog').append('<div class="yacht-connection-response yacht-response-failure">Connection Status Fail</div>');
                }
            },
            error: function () {
                console.log('An error occurred while saving.');
                $('.yacht-loading-dialog').append('<div class="yacht-connection-response yacht-response-failure">Connection Status Fail</div>');
            },
            complete: function () {
                formInputs.prop('disabled', false).removeClass('blurred');
                jQuery(document).ready(function ($) {
                    setTimeout(function () {
                        $('.yacht-connection-response').fadeOut(500);
                    }, 2000);
                });
                
            }
        });
    });

});
