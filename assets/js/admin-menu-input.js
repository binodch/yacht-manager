/* Script goes here */

jQuery(document).ready(function ($) {
    
    $('#yacht-manager-save-btn').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let companyUri = $('#yacht-company-uri').val();
        let keyId = $('#yacht-key-id').val();
        let keyFileInDir = $('#yacht-key-file-uploaded').val();
        let privateKeyFile = '';
        
        // console.log(keyFileUploaded);
        
        if( keyFileInDir == 'no' ) {
            privateKeyFile = $('#yacht-private-key-upload')[0].files[0]; // Get uploaded file
            if( ! privateKeyFile ) {
                alert('All fields are required');
                return;
            }
        }

        // if( (keyFileInDir=='yes') && privateKeyFile )

        if ((companyUri.trim() == '') || (keyId.trim() == '')) {
            alert('All fields are required');
            return;
        }

        // Append text inputs
        formData.append('action', 'admin_setting_input');
        formData.append('company_uri', companyUri);
        formData.append('key_id', keyId);
        formData.append('key_file_in_dir', keyFileInDir);
        formData.append('nonce', ajax_object.ajax_nonce);

        // Append file if uploaded
        if (privateKeyFile) {
            formData.append('private_key_file', privateKeyFile);
        }

        $('.yacht-manager-content').hide();
        $('.yacht-loading').show();


        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false, // Important: prevent jQuery from processing data
            contentType: false, // Important: prevent jQuery from setting content-type
            success: function (response) {
                $('.yacht-manager-content').show();
                $('.yacht-loading').hide();
                if (response.success) {
                    console.log(response.data.message);
                } else {
                    console.log('Error saving settings');
                }
            },
            error: function (xhr, status, error) {
                $('.yacht-manager-content').show();
                $('.yacht-loading').hide();

                console.log('An error occurred while saving.');
            }
        });
    });
});