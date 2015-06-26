<div class="rounded1 color_alternate">
    <h6>Hoạt động gần đây</h6>
</div>
<div class="w-blog imgpos_attop meta_all">
    <div class="w-blog-h">

        <?php foreach ($user_activity as $user_activity_info) : ?>
            <div class="w-blog-list">
                <div class="w-blog-entry">
                    <div class="w-blog-entry-h">

                        <div class="w-blog-entry-body">
                            <div class="w-blog-entry-meta">
                                <div class="w-blog-entry-meta-date">
                                    <i class="icon-time"></i>
                                    <span class="w-blog-entry-meta-date-month"><?php echo $user_activity_info->post_date ?></span>

                                </div>

                                <div class="w-blog-entry-meta-comments">
                                    <i class="icon-comments"></i>
                                    <a class="w-blog-entry-meta-comments-h" href="javascript:void(0);">13 comments</a>
                                </div>
                            </div>

                            <div class="w-blog-entry-short">
                                <p><?php echo $user_activity_info->post_content ?></p>
                            </div>

                            <a href="blog-post.html">
                                <button class="g-btn type_primary size_small"><span><i class="icon-star-empty"></i>Read more</span></button> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        <div class="w-blog-pagination">
            <div class="g-pagination">
                <a href="javascript:void(0);" class="g-pagination-item to_prev">Prev</a>
                <a href="javascript:void(0);" class="g-pagination-item">1</a>
                <a href="javascript:void(0);" class="g-pagination-item active">2</a>
                <a href="javascript:void(0);" class="g-pagination-item">3</a>
                <a href="javascript:void(0);" class="g-pagination-item">4</a>
                <a href="javascript:void(0);" class="g-pagination-item">5</a>
                <a href="javascript:void(0);" class="g-pagination-item to_next">Next</a>
            </div>
        </div>
    </div>
</div>
