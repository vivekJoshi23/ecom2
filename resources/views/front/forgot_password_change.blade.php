@extends('front/layout')
@section('page_title', 'Change Password')
@section('container')

<!-- Cart view section -->
<section id="aa-myaccount">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-myaccount-area">
          <div class="row">

            <div class="col-md-6">
              <div class="aa-myaccount-register">
                <h4>Change Password</h4>
                <form class="aa-login-form" id="frmUpdatePassword">
                  @csrf

                  <label for="">Password<span>*</span></label>
                  <input type="password" placeholder="Password" name="password" required>
                  <div id="password_error" class="field_error"></div>

                  <button type="submit" class="aa-browse-btn" id="btnUpdatePassword">Update Password</button>
                </form>
              </div>
              <div id="thank_you_msg" class="field_error"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / Cart view section -->

@endsection

@section('scripts')
<script>
  jQuery('#frmUpdatePassword').submit(function(e) {
    e.preventDefault();
    jQuery('#thank_you_msg').html("Please wait...");

    // Include CSRF token in the request headers
    var formData = jQuery(this).serialize();
    formData += '&_token=' + jQuery('meta[name="csrf-token"]').attr('content');

    jQuery.ajax({
      url: '/forgot_password_change_process',
      data: formData,
      type: 'post',
      success: function(result) {
        console.log(result);
        jQuery('#frmUpdatePassword')[0].reset();
        jQuery('#thank_you_msg').html(result.msg);
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        jQuery('#thank_you_msg').html("An error occurred. Please try again later.");
      }
    });
  });
</script>
@endsection