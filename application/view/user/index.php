<div class="content">
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3">
                <h4>User Page</h4>

                <div class="box">
                    <form action="<?=URL?>user" method="post" enctype="multipart/form-data">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" name="user_image" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="image_upload">Upload</button>
                    </form>
                </div>

                <div class="box">
                    <form action="<?=URL?>user" method="post">
                        <h6 class="h6-form">Username</h6>

                        <div class="input-field">
                            <input id="username" type="text" class="validate" name="username" required value="<?php if(isset($_SESSION['user_session']->username{print_r($_SESSION['user_session']->username)})) ?>">
                            <label for="username">Username</label>
                            <?php if(isset($error_username)){ ?>
                                <span class="helper-text" style="color:#F44336"><?=$error_username?></span>
                            <?php } ?>
                        </div>

                        <div class="input-field">
                            <input id="password_username" type="password" class="validate" name="password_username" required>
                            <label for="password_username">Password</label>
                            <?php if(isset($error_password_username)){ ?>
                                <span class="helper-text" style="color:#F44336"><?php print_r($error_password_username) ?></span>
                            <?php } ?>
                        </div>
                        
                        <button class="btn waves-effect waves-light" type="submit" name="username_change">Update Username</button>
                    </form>
                </div>

                <div class="box">
                    <form action="<?=URL?>user" method="post">
                        <h6 class="h6-form">Email</h6>
                        <div class="input-field">
                            <input id="email" type="email" class="validate" name="email" required value="<?php if(isset($_SESSION['user_session']->email{print_r($_SESSION['user_session']->email)})) ?>">
                            <label for="email">Email</label>
                            <?php if(isset($error_email)){ ?>
                                <span class="helper-text" style="color:#F44336"><?=$error_email?></span>
                            <?php } ?>
                        </div>
                        <div class="input-field">
                            <input id="password_email" type="password" class="validate" name="password_email" required>
                            <label for="password_email">Password</label>
                            <?php if(isset($error_password_email)){ ?>
                                <span class="helper-text" style="color:#F44336"><?php print_r($error_password_email) ?></span>
                            <?php } ?>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="email_change">Update Email</button>
                    </form>
                </div>



                
                <div class="box" id="user-details">
                    <form action="<?=URL?>user" method="post">
                        <h6 class="h6-form">User Details</h6>
                        <div class="input-field">
                            <input id="firstname" type="text" class="validate" name="firstname" required value="<?php if(isset($_SESSION['user_session']->firstname{print_r($_SESSION['user_session']->firstname)})) ?>">
                            <label for="firstname">First Name</label>
                        </div>

                        <div class="input-field">
                            <input id="lastname" type="text" class="validate" name="lastname" required value="<?php if(isset($_SESSION['user_session']->lastname{print_r($_SESSION['user_session']->lastname)})) ?>">
                            <label for="lastname">Last Name</label>
                        </div>

                        <div class="input-field">
                            <input id="password_details" type="password" class="validate" name="password_datails" required>
                            <label for="password_details">Password</label>
                            <?php if(isset($error_password_details)){ ?>
                                <span class="helper-text" style="color:#F44336"><?php print_r($error_password_details) ?></span>
                            <?php } ?>
                        </div>

                        <button class="btn waves-effect waves-light" type="submit" name="details_change">Update User Details</button>
                    </form>
                </div>

                <div class="box">
                    <h6 class="h6-form">Password</h6>
                    <form action="<?=URL?>user" method="post">
                        <div class="input-field">
                            <input id="current-password" type="password" class="validate" name="current_password" required>
                            <label for="current-password">Current Password</label>
                            <?php if(isset($error_password_current_password)){ ?>
                                <span class="helper-text" style="color:#F44336"><?php print_r($error_password_current_password) ?></span>
                            <?php } ?>
                        </div>

                        <div class="input-field">
                            <input id="new-password" type="password" class="validate" name="new_password" required>
                            <label for="new-password">New Password</label>
                        </div>

                        <div class="input-field">
                            <input id="confirm-new-password" type="password" class="validate" name="confirm_new_password" required>
                            <label for="confirm-new-password">Confirm New Password</label>
                        </div>

                        <button class="btn waves-effect waves-light" type="submit" name="password_change">Update Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div> 
</div>


