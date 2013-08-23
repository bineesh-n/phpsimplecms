<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
    <head>
        <title>NSS | GEC Palakkad </title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="/nss/content/css/header-content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/content/css/footer-content.css" type="text/css" />
        <script src="/nss/scripts//jquery.min.js"></script>
        <script src="/nss/scripts/content.js"></script>
        
        <link rel="stylesheet" href="/../nss/css/basic.css" type="text/css" />
	<link rel="stylesheet" href="/../nss/css/galleriffic-5.css" type="text/css" />
	<link rel="stylesheet" href="/../nss/css/black.css" type="text/css" />	
	<script type="text/javascript" src="/../nss/scripts/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="/../nss/scripts/jquery.history.js"></script>
	<script type="text/javascript" src="/../nss/scripts/jquery.galleriffic.js"></script>
	<script type="text/javascript" src="/../nss/scripts/jquery.opacityrollover.js"></script>
	<script type="text/javascript">
		document.write('<style>.noscript { display: none; }</style>');
	</script>
    </head>
    <body>
        <div id="page">
<?php

 include_once '/../content/header.php';
 include_once 'gallery.php';
?>
            <div id="age">
                <div id="container">
    <div class="navigation-container">
	<div id="thumbs" class="navigation">
		<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
					
			<ul class="thumbs noscript">
                            <?php
                            if(array_key_exists('gid', $_GET)){
                                $re = gallery::getPicturesOnGalleryId($_GET['gid']);
                                imagesGallery($re);
                            }
                            else {
                                $re = gallery::listGallery();
                                imagesGallery($re);
                            }
                            ?>
                        </ul>
                <a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
                </div>
    </div>
	<div class="content">
					<div class="slideshow-container">
						<div id="controls" class="controls"></div>
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container">
						<div class="photo-index"></div>
					</div>
				</div>
				<!-- End Gallery Html Containers -->
				<div style="clear: both;"></div>
			</div>
            </div>
        <script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li, div.navigation a.pageLink').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 10,
					preloadAhead:              10,
					enableTopPager:            false,
					enableBottomPager:         false,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             true,
					autoStart:                 false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);

						// Update the photo index display
						this.$captionContainer.find('div.photo-index')
							.html('Photo '+ (nextIndex+1) +' of '+ this.data.length);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						var prevPageLink = this.find('a.prev').css('visibility', 'hidden');
						var nextPageLink = this.find('a.next').css('visibility', 'hidden');
						
						// Show appropriate next / prev page links
						if (this.displayedPage > 0)
							prevPageLink.css('visibility', 'visible');

						var lastPage = this.getNumPages() - 1;
						if (this.displayedPage < lastPage)
							nextPageLink.css('visibility', 'visible');

						this.fadeTo('fast', 1.0);
					}
				});

				/**************** Event handlers for custom next / prev page links **********************/

				gallery.find('a.prev').click(function(e) {
					gallery.previousPage();
					e.preventDefault();
				});

				gallery.find('a.next').click(function(e) {
					gallery.nextPage();
					e.preventDefault();
				});

				/****************************************************************************************/

				/**** Functions to support integration of galleriffic with the jquery.history plugin ****/

				// PageLoad function
				// This function is called when:
				// 1. after calling $.historyInit();
				// 2. after calling $.historyLoad();
				// 3. after pushing "Go Back" button of a browser
				function pageload(hash) {
					// alert("pageload: " + hash);
					// hash doesn't contain the first # character.
					if(hash) {
						$.galleriffic.gotoImage(hash);
					} else {
						gallery.gotoIndex(0);
					}
				}

				// Initialize history plugin.
				// The callback is called at once by present location.hash. 
				$.historyInit(pageload, "advanced.html");

				// set onlick event for buttons using the jQuery 1.3 live method
				$("a[rel='history']").live('click', function(e) {
					if (e.button != 0) return true;

					var hash = this.href;
					hash = hash.replace(/^.*#/, '');

					// moves to a new page. 
					// pageload is called at once. 
					// hash don't contain "#", "?"
					$.historyLoad(hash);

					return false;
				});

				/****************************************************************************************/
			});
		</script>

            
            <?php
include_once '/../content/footer.php';
?>
</div>
<?php
function imagesGallery($re) {
    while($result = mysql_fetch_array($re)){
                            ?>
				<li>
                                    <a class="thumb" name="leaf" href="images/<?php echo $result['URL']; ?>" title="<?php echo $result['TITLE'] ?>">
                                    <img src="images/thumbnails/<?php
                                                                    if(file_exists('images/thumbnails/'.$result['URL'])) {
                                                                    echo $result['URL'];
                                                                    }else{ echo 'default.jpg'; } ?>" alt="<?php echo $result['TITLE']; ?>" />
                                    </a>
                                    <div class="caption">
                                        <div class="image-title"><?php echo $result['TITLE']; ?></div>
                                        <div class="image-desc"><?php echo $result['DESCRIPTION']; ?></div>
                                        <div class="download">
                                        <a href="images/<?php echo $result['URL']; ?>">Download Original</a>
                                        </div>
                                    </div>
				</li>
                            <?php
    }
}
?>
        </div>
    </body>
</html>