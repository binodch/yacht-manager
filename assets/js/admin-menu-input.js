/* Script goes here */

jQuery(document).ready(function ($) {

    $('#yacht-manager-save-btn').on('click', function (e) {
        e.preventDefault();
        let companyUrl = $('#yacht-company-url').val();
        let keyId = $('#yacht-key-id').val();
        let privateKey = $('#yacht-private-key').val();

        if( (companyUrl.trim()=='') || (keyId.trim()=='') || (privateKey.trim()=='') ) {
            alert('All fields are required');

        } else {
            $.post(ajax_object.ajax_url, {
                action: 'admin_setting_input',
                company_url: companyUrl,
                key_id: keyId,
                private_key: privateKey,
                nonce: ajax_object.ajax_nonce
            }, function (response) {
                if( response.success ) {
                    console.log(response.data.message);
                } else {
                    console.log('failure');
                }
            });
        }
    });

});