document.addEventListener('DOMContentLoaded', function (){
    if ( document.querySelectorAll('.resource-video-list.splide').length>0 ){
        document.querySelectorAll('.resource-video-list.splide').forEach(function (item){
            let videoSlider = new Splide(item, {
                perPage: 1,
                type: 'loop',
                pagination: false,
                video: {
                    loop: true,
                },
                breakpoints: {
                    781: {
                        arrows: true,
                    },
                }
            });

            videoSlider.mount();
        });
    }
});

/* --------------------------------------
*    Load More
*  -------------------------------------- */
document.addEventListener("DOMContentLoaded", function () {
    if ( document.querySelectorAll('.nphm-resources-list-wrap .resource-item').length>0 ) {
        var contents = document.querySelectorAll(".nphm-resources-list-wrap .resource-item");
        var loadMoreButton = document.getElementById("loadMore");

        contents.forEach(function (content, index) {
            if ( window.innerWidth < 768 ) {
                if (index < 3) {
                    content.style.display = "block";
                }
            } else {
                if (index < 4) {
                    content.style.display = "block";
                }
            }
        });

        if( loadMoreButton ) {
            loadMoreButton.addEventListener("click", function (e) {
                e.preventDefault();

                var hiddenContents = Array.from(contents).filter(function (content) {
                    return window.getComputedStyle(content).display === "none";
                });

                if ( window.innerWidth < 768 ) {
                    hiddenContents.slice(0, 3).forEach(function (content, index) {
                        content.style.display = "block";
                        content.style.maxHeight = content.scrollHeight + "px";
                    });
                } else {
                    hiddenContents.slice(0, 6).forEach(function (content, index) {
                        content.style.display = "block";
                        content.style.maxHeight = content.scrollHeight + "px";
                    });
                }

                var remainingContents = Array.from(contents).filter(function (content) {
                    return window.getComputedStyle(content).display === "none";
                });

                if (remainingContents.length === 0) {
                    loadMoreButton.textContent = "No Content";
                    loadMoreButton.classList.add("noContent");
                }
            });
        }
    }
});
