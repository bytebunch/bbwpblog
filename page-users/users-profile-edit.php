<div class="user_profile_edit">
    <form action="" method="post">
    <h3 class="entry_title">Account Detail</h2>
        <!--<p>
            <label for="profile_image" id="">Profile Image</label>
            <input type="text" name="first_name" id="first_name" />
        </p>-->
        <div class="row">
          <div class="col-md-5">
            <strong>Username:</strong><br>
            <small>You can't edit your username. <a href="#">Contact us</a></small>
          </div>
          <div class="col-md-5">
            <input type="text" name="" id="" value="<?php echo $user_profile_data->data->user_login; ?>" disabled="disabled">
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label for="fname"><strong>First Name: </strong><spam class="forum_star">*</spam></label>
            <br />
            <small>Length must be between 3 characters and 20 characters.</small>
          </div>
          <div class="col-md-5">
            <input type="text" name="fname" id="fname" class="required" required="required" pattern=".{3,20}" title="3 min and 20 max characters" value="<?php echo get_user_meta($user_profile_data->ID,'first_name',true); ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label for="lname"><strong>Last Name:</strong></label>
            <br />
            <small>Length must be between 3 characters and 20 characters.</small>
          </div>
          <div class="col-md-5">
            <input type="text" name="lname" id="lname" value="<?php echo get_user_meta($user_profile_data->ID,'last_name',true); ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label for="email"><strong>Email address:</strong><spam class="forum_star">*</spam></label>
            <br />
            <small>Your contact email address.</small>
          </div>
          <div class="col-md-5">
            <input type="email" name="email" id="email" class="required" required="required" value="<?php echo $user_profile_data->data->user_email; ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label for="display_name"><strong>Display Name: </strong><spam class="forum_star">*</spam></label>
            <br />
            <small>This is your public display name. It should me min 3 and max 20 chars long.</small>
          </div>
          <div class="col-md-5">
            <input type="text" class="required" required="required" pattern=".{3,20}" title="3 min and 20 max characters" name="display_name" id="display_name" value="<?php echo $user_profile_data->data->display_name; ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label for="gender"><strong>Gender:</strong></label>
          </div>
          <div class="col-md-5">
            <select name="gender" id="gender">
               <option value="Male" <?php if(get_user_meta($user_profile_data->ID,'gender',true) == 'Male'){ echo 'selected="selected"';} ?>>Male</option>
               <option value="Female" <?php if(get_user_meta($user_profile_data->ID,'gender',true) == 'Female'){ echo 'selected="selected"';} ?>>Female</option>
           </select>
          </div>
        </div>
        <input type="submit" value="Submit" />
    </form>
</div>
