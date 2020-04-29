<div class="content">
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3">
                <h4>Preferences</h4>
                <div class="box">
                    <form action="<?=URL?>preferences/" method="post">

                        <p class="range-field">
                            <label for="radius">Radius</label>
                            <input type="range" name="radius" id="test5" value="<?=$pref->radius?>" min="1" max="25" />
                        </p>

                        <button class="btn waves-effect waves-light" type="submit" name="update">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>


