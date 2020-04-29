<div class="content">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l8 offset-l2">
                

                <p id="demo" style="display:none"></p>


                    <h4>Post</h4>

                    <form action="<?=URL?>feed/index/<?=$lat?>/<?=$lon?>/" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <input id="feed" type="text" class="validate" name="post" required>
                            <label for="feed">What's happening?</label>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Image</span>
                                    <input type="file" id="post_image" name="post_image">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <div class="radio-buttons">
                                <label>
                                <input class="with-gap" value="1"  name="tags" type="radio" required />
                                <span>Crime</span>
                                </label>

                                <label>
                                <input class="with-gap" value="2" name="tags" type="radio"  />
                                <span>Lost & Found</span>
                                </label>

                                <label>
                                <input class="with-gap" value="3" name="tags" type="radio"  />
                                <span>Events</span>
                                </label>

                                <label>
                                <input class="with-gap" value="4" name="tags" type="radio"  />
                                <span>Offers</span>
                                </label>

                                <label>
                                <input class="with-gap" value="5"  name="tags" type="radio"  />
                                <span>Traffic</span>
                                </label>

                                <label>
                                <input class="with-gap" value="6"  name="tags" type="radio"  />
                                <span>Other</span>
                                </label>
                            </div>

                            <button class="btn waves-effect waves-light" type="submit" name="post_submit"><i class="small material-icons">send</i></button>
                        </div>
                        
                        <div class="clear"></div>
                    </form>


                    
                    <div class="box border-box">

                    <h4>Feed <small>+ <?=$rad?> Miles</small><a href="<?=URL?>preferences" id="pref-settings"><i class="small material-icons right">settings</i><span class="settings right">Adjust Radius</span></a></h4>
                    
                    <!-- MaxLat <?=$maxLat?><br>
                    MinLat <?=$minLat?><br>
                    MaxLon <?=$maxLon?><br>
                    MinLon <?=$minLon?> -->


                    <form action="<?=URL?>feed/index/<?=$lat?>/<?=$lon?>/" method="post">
                            <div class="input-field">
                                <input id="search" type="text" class="validate" name="search" required>
                                <label for="search">Search <small>eg crime, events...</small></label>
                                <button class="btn waves-effect waves-light" type="submit" name="search_submit"><i class="small material-icons">search</i></button>
                            </div>
                            
                            <div class="clear"></div>
                        </form>


              
                <?php if(isset($feedItems) && $feedItems != false) { 
                    if(isset($_POST['search']) && $_POST['search'] != '') {
                ?>
                        <p>Search results within <?=$rad?> Miles for <b id='b-search'><?=$_POST['search']?></b><small><a href="<?=URL?>">Reset</a></small>
                    <?php } ?>
                

                        <ul class="collection" id="posts">
                            <? foreach ($feedItems as $feedItem): ?>
                                <li class="collection-item avatar" id="post">
                                    <img class="circle responsive-img" src="<?=URL?>public/<?=$feedItem->image?>" alt="">
                                    <span class="title">
                                        <a href="#"><?= $feedItem->username?></a>
                                        <small><?= number_format($feedItem->D,1) ?> Miles</small>
                                        <?php if($feedItem->user_id == $_SESSION['user_session']->id){ ?>
                                            <small>
                                                <a href="<?=URL?>feed/deletePost/<?=$feedItem->id?>"><i class="material-icons tiny delete-icon" id="<?=$feedItem->id?>">delete</i></a>
                                            </small>
                                        <?php } ?>
                                    </span>
                                    <p><?= $feedItem->content ?> 
                                    <?php if($feedItem->name != null) { ?>
                                        <span class="tags">#<?= $feedItem->name ?></span>
                                    <?php } ?><br>
                                    <?php if($feedItem->post_image != null) { ?>
                                        <img class="responsive-img post-img" src="<?=URL?>public/<?=$feedItem->post_image?>" alt="">
                                    <?php } ?>
                                    <?php $feedReplies = $this->model->getFeedReplies($feedItem->id); ?>
                                    <a href="#!" class="reply-count" id="<?=$feedItem->id?>"><?php echo ($feedReplies != false ? count((array)$feedReplies) : "0"); ?> Replies</a>
                                    </p>
                                    <a href="#!" class="secondary-content"><i class="material-icons">favorite_border</i><?= $feedItem->loves?></a>
                                </li>

                                        
                                        
                                            <div class="replies" id="replies-<?=$feedItem->id?>">
                                                <?php if($feedReplies != false){ ?>
                                                <?php for($i=0; $i<count((array)$feedReplies); $i++){ ?>
                                                    
                                                    <li class="collection-item collection-reply avatar" id="post">
                                                    
                                                        <img class="circle reply-img responsive-img" src="<?=URL?>public/<?=$feedReplies[$i]->image?>" alt="">
                                                        <span class="title">
                                                            <a href="#"><?= $feedReplies[$i]->username?></a>
                                                            <?php if($feedReplies[$i]->user_id == $_SESSION['user_session']->id){ ?>
                                                                <small>
                                                                    <a href="<?=URL?>feed/deleteReply/<?=$feedReplies[$i]->id?>"><i class="material-icons tiny delete-icon" id="<?=$feedReplies[$i]->id?>">delete</i></a>
                                                                </small>
                                                            <?php } ?>
                                                        </span>
                                                        <p><?= $feedReplies[$i]->content ?><br>
                                                        </p>
                                                        <a href="#!" class="secondary-content"><i class="material-icons">favorite_border</i><?= $feedReplies[$i]->loves?></a>
                                                        <i class="material-icons reply-icons tiny">reply</i>
                                                    </li>
                                                <?php } ?>
                                                <?php } ?>
                                                <li class="collection-item" id="post">
                                                    <form action="<?=URL?>feed/index/<?=$lat?>/<?=$lon?>/<?=$feedItem->id?>" method="post">
                                                        <div class="input-field">
                                                            <input id="feed" type="text" class="validate" name="reply_text" required>
                                                            <input id="lat" type="text" name="lat" class="hidden">
                                                            <input id="lon" type="text" name="lon" class="hidden">
                                                            <input id="reply-" type="text" name="lon" class="hidden">
                                                            <label for="reply_text">Reply</label>
                                                            <button class="btn waves-effect waves-light" type="submit" name="reply_submit">Reply</button>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </form>
                                                </li>
                                                <span></span>
                                            </div>
                                       

                                    

                            <? endforeach ?>
                        </ul>



                    </div>
                <?php } else { ?>
                        <p class="center">0 search results, please try again.</p>
                <?php } ?>

                





                
                
                







               




            </div>
        </div>
    </div> 
</div>


