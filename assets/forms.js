if(new URL(window.location.href).searchParams.get("page") == "requestlogic_plugin"){
    jQuery(document).ready(function($) {
        var modal = document.getElementById("myModal");

        var img = document.getElementById("wp_gif");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        $(document).click(function(event) {
            if (!$(event.target).is("#img01, #wp_gif")) {
                modal.style.display = "none";
            }
        });
    });
}