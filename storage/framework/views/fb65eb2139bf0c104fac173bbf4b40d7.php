
<?php $__env->startSection('page_title','Dashboard'); ?>
<?php $__env->startSection('dashboard_select','active'); ?>
<?php $__env->startSection('container'); ?>


<div class="row">
    <h1>Dashboard</h1>
</div>

<div class="container mt-5" style="background-color: white; padding-top:20px;padding-bottom:20px;">
    <div class="widget meta-boxes mt-5">

        <h5 class="mb-3 mt-0" style="color:#1F64A0;font-weight:normal;cursor:all-scroll;"><i class="fa-solid fa-rotate"></i> Commands To Clear Caching</h5>

        <div class="widget-body">
            <table class="table table-bordered vertical-middle table-hover">
                <colgroup>
                    <col width="70%">
                    <col width="30%">
                </colgroup>
                <tbody>
                    <tr>
                        <td>
                            Clear CMS caching: database caching, static blocks... Run this command when you don't see
                            the changes after updating data.
                        </td>
                        <td>
                            <button class="btn btn-danger btn-block btn-clear-cache w-75" onclick="clearCache()">
                                Clear all CMS Cache
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Clear compiled views to make views up to date.
                        </td>
                        <td>
                            <button class="btn btn-warning btn-block btn-clear-cache w-75" onclick="deleteCompiledViews()">
                                Refresh Compiled Views
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            You might need to refresh the config caching when you change something on production
                            environment.
                        </td>
                        <td>
                            <button class="btn btn-outline-success" id="clearConfigCacheButton">
                                Clear Config Cache
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Clear cache routing.
                        </td>
                        <td>
                            <button class="btn btn-outline-success" onclick="clearRoutingCache()">
                                Clear Route Cache
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Clear system log files
                        </td>
                        <td>
                            <button class="btn btn-outline-success" id="clearLogButton">
                                Clear Log
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://kit.fontawesome.com/1826195d5a.js" crossorigin="anonymous"></script>
<!-- toast js start -->
<script>
    function showToast(message) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right', // Set the position of the toast notification
            timeOut: 3000, // Duration in milliseconds
            extendedTimeOut: 1000 // Duration for closing animation
        };

        toastr.success(message);
    }
</script>



<!-- toast js ends -->



<script>
    function deleteCompiledViews() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make an AJAX request to the DELETE route to delete compiled views.
        $.ajax({
            url: '/delete-compiled-views',
            method: 'POST',
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                // Handle the success response (optional).
                showToast(response.message);

            },
            error: function(xhr) {
                // Handle the error response (optional).
                console.error('An error occurred while deleting compiled views.');
            }
        });
    }
</script>

<script>
    function clearCache() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make an AJAX request to the route for clearing the cache.
        $.ajax({
            url: '/clear-cache',
            method: 'POST',
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                // Handle the success response.
                showToast(response.message);
            },
            error: function(xhr) {
                // Handle the error response (optional).
                console.error('An error occurred while clearing the cache.');
            }
        });
    }
</script>

<script>
    document.getElementById('clearConfigCacheButton').addEventListener('click', function() {
        axios.post('/clear-config-cache')
            .then(function(response) {
                // Show a toast notification on success
                showToast(response.data.message);
            })
            .catch(function(error) {
                console.error(error);
            });
    });
</script>
<script>
    function clearRoutingCache() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make an AJAX request to the route for clearing the routing cache.
        $.ajax({
            url: '/clear-routing-cache',
            method: 'POST',
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                // Handle the success response.
                showToast(response.message);
            },
            error: function(xhr) {
                // Handle the error response (optional).
                console.error('An error occurred while clearing the routing cache.');
            }
        });
    }
</script>

<script>
    document.getElementById('clearLogButton').addEventListener('click', function() {
        // Send an Ajax request to the route that triggers the controller method
        fetch('<?php echo e(route("clear.log")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show a toast notification on success
                    showToast('Log cleared successfully.');
                } else {
                    // Show a toast notification on failure
                    showToast('Failed to clear log file. Please check the server logs.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show a toast notification on error
                showToast('An error occurred while clearing the log.');
            });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ecom2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>