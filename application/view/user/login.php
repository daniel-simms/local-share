<div class="content">
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3">
                <h4>Login</h4>
                <div class="box">
                    <form action="<?=URL?>user/login" method="post">
                        <div class="input-field">
                            <input id="email" type="email" class="validate" name="email" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-field">
                            <input id="password" type="password" class="validate" name="password" required>
                            <label for="password">Password</label>
                            <?php if(isset($error)){ ?>
                                <span class="helper-text" style="color:#F44336">Incorrect Email or Password.</span>
                            <?php } ?>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="login">Login</button>
                        <p>Don't have an account? Register <a href="<?=URL?>user/register">here.</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>


