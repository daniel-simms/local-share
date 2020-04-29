<div class="content">
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3">
                <h4>Register</h4>
                <div class="box">
                    <form action="<?=URL?>user/register" method="post">

                        <div class="input-field">
                            <input id="username" type="text" class="validate" name="username" required value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>"">
                            <label for="username">Username</label>
                        </div>

                        <div class="input-field">
                            <input id="firstname" type="text" class="validate" name="firstname" required value="<?php if(isset($_POST['firstname'])){echo $_POST['firstname'];} ?>">
                            <label for="firstname">First Name</label>
                        </div>

                        <div class="input-field">
                            <input id="lastname" type="text" class="validate" name="lastname" required value="<?php if(isset($_POST['lastname'])){echo $_POST['lastname'];} ?>">
                            <label for="lastname">Last Name</label>
                        </div>

                        <div class="input-field">
                            <input id="email" type="email" class="validate" name="email" required value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                            <label for="email">Email</label>
                            <?php if(isset($error_email)){ ?>
                                <span class="helper-text" style="color:#F44336"><?=$error_email?></span>
                            <?php } ?>
                        </div>

                        <div class="input-field">
                            <input id="password" type="password"  pattern=".{6,}" title="Password must be 6 characters" class="validate" name="password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="input-field">
                            <input id="confirm-password" type="password" class="validate" oninput="check(this)" required>
                            <label for="confirm-password">Confirm Password</label>
                        </div>

                        <button class="btn waves-effect waves-light" type="submit" name="register">Register</button>
                        <p>Already have an account? Login <a href="<?=URL?>user/login">here.</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>


