<div class="content">
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3">
                <h4>Feed <a href="<?=URL?>preferences" id="pref-settings"><i class="small material-icons right">settings</i></a></h4>
                <div class="box">
                    <div class='preloader-wrapper small active' id="x"><div class='spinner-layer spinner-green-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div>
                </div>
                <script>
                    $( document ).ready(function() {
                        var x = document.getElementById("x");

                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(generateFeed);
                        } else { 
                            x.innerHTML = "Geolocation is not supported by this browser.";
                        }

                        function generateFeed(pos){
                            var target = "<?=URL?>" + "feed/index";
                            var lat = pos.coords.latitude.toFixed(6);
                            var lon = pos.coords.longitude.toFixed(6);
                            Cookies.set('lat', lat);
                            Cookies.set('lon', lon);
                            window.location.replace(target + '/' + lat + '/' + lon);
                        }
                    });
                </script>



            </div>
        </div>
    </div> 
</div>