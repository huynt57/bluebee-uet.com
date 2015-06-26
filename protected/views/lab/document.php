<div class="l-submain">
    <div class="l-submain-h i-cf">
        <div class="g-cols">
            <?php $this->renderPartial("partial/bar_left", array('category_father' => $category_father, 'subject_type' => $subject_type)) ?>

            <div class="three-fourths">
     
                <div class="g-cols" style="margin-top: 10px;">
                    <?php $this->renderPartial('listdocument') ?>
                    <?php $this->renderPartial('bar_right', array('subject_info' => $subject_info)) ?>
                </div>
                <!--cmt facebook-->
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/uiMorphingButton_fixed.js"></script>
<script>
    (function() {
        var docElem = window.document.documentElement, didScroll, scrollPosition;

        // trick to prevent scrolling when opening/closing button
        function noScrollFn() {
            window.scrollTo(scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0);
        }

        function noScroll() {
            window.removeEventListener('scroll', scrollHandler);
            window.addEventListener('scroll', noScrollFn);
        }

        function scrollFn() {
            window.addEventListener('scroll', scrollHandler);
        }

        function canScroll() {
            window.removeEventListener('scroll', noScrollFn);
            scrollFn();
        }

        function scrollHandler() {
            if (!didScroll) {
                didScroll = true;
                setTimeout(function() {
                    scrollPage();
                }, 60);
            }
        }
        ;

        function scrollPage() {
            scrollPosition = {x: window.pageXOffset || docElem.scrollLeft, y: window.pageYOffset || docElem.scrollTop};
            didScroll = false;
        }
        ;

        scrollFn();

        var UIBtnn = new UIMorphingButton(document.querySelector('.morph-button'), {
            closeEl: '.icon-close',
            onBeforeOpen: function() {
                // don't allow to scroll
                noScroll();
            },
            onAfterOpen: function() {
                // can scroll again
                canScroll();
            },
            onBeforeClose: function() {
                // don't allow to scroll
                noScroll();
            },
            onAfterClose: function() {
                // can scroll again
                canScroll();
            }
        });

        document.getElementById('terms').addEventListener('change', function() {
            UIBtnn.toggle();
        });
    })();
</script>