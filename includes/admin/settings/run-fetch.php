<?php
/*
* Run fetch
*/
function yacht_manager_run_fetch_page() {
    if (isset($_POST['run_fetch'])) {
        // Run the function when form is submitted
        yacht_manager_insert_update_yacht_post_type();
        yacht_manager_insert_update_yacht_post_type(true);
    
        // Display admin notice
        add_action('admin_notices', function() {
            echo '<div class="updated notice is-dismissible"><p>Fetch process has been completed.</p></div>';
        });
    } ?>
    <div class="wrap">
        <h2>Run Fetch</h2>
        <p>Here you can run the fetch process.</p>
        <form method="post" action="">
            <input type="submit" name="run_fetch" value="Run Fetch" class="button button-primary" />
        </form>
    </div>
<?php }