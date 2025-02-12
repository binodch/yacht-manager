/* Script goes here */

jQuery(document).ready(function ($) {
    $('#yacht-manager-save-btn').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let companyUri = $('#yacht-company-uri').val();
        let keyId = $('#yacht-key-id').val();
        let privateKeyFile = $('#yacht-private-key-upload')[0].files[0]; // Get uploaded file

        if ((companyUri.trim() == '') || (keyId.trim() == '') || !privateKeyFile) {
            alert('All fields are required');
            return;
        }

        // Append text inputs
        formData.append('action', 'admin_setting_input');
        formData.append('company_uri', companyUri);
        formData.append('key_id', keyId);
        formData.append('nonce', ajax_object.ajax_nonce);

        // Append file if uploaded
        if (privateKeyFile) {
            formData.append('private_key_file', privateKeyFile);
        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false, // Important: prevent jQuery from processing data
            contentType: false, // Important: prevent jQuery from setting content-type
            success: function (response) {
                if (response.success) {
                    console.log(response.data.message);
                    alert('Settings saved successfully');
                } else {
                    console.log('Failure: ', response.data);
                    alert('Error saving settings');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error: ', error);
                alert('An error occurred while saving.');
            }
        });
    });
});