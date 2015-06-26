<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.w-map-h').gMap({
            controls: {
                panControl: false,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false
            },
            address: "Đại học Quốc Gia Hà Nội - Xuân Thủy, 144 Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Vietnam",
            zoom: 15,
            markers: [
                {
                    address: "Đại học Quốc Gia Hà Nội - Xuân Thủy, 144 Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Vietnam",
                    html: "Trụ sở của chúng tôi",
                    popup: true
                }
            ]
        });
    });
</script>
<div class="l-submain type_fullwidth">
    <div class="l-submain-h g-html i-cf">
        <div class="w-map">
            <div class="w-map-h" style="height: 300px;">
            </div>
        </div>
    </div>
</div>
<div class="l-submain">
    <div class="l-submain-h g-html i-cf">
        <div class="g-cols">
            <div class="one-third">
                <div class="wpb_text_column ">
                    <div class="wpb_wrapper">
                        <h3>Thông tin liên lạc</h3>
                    </div>
                </div>
                <div class="w-contacts">
                    <div class="w-contacts-h">
                        <div class="w-contacts-list">
                            <div class="w-contacts-item for_address">
                                <i class="fa fa-map-marker"></i>
                                <span class="w-contacts-item-name">Địa chỉ:</span>
                                <span class="w-contacts-item-value">144, Xuân Thủy, Cầu Giấy, Hà Nội</span>
                            </div>
                            <div class="w-contacts-item for_phone">
                                <i class="fa fa-phone"></i>
                                <span class="w-contacts-item-name">Điện Thoại:</span>
                                <span class="w-contacts-item-value">+123456789</span>
                            </div>
                            <div class="w-contacts-item for_email">
                                <i class="fa fa-envelope"></i>
                                <span class="w-contacts-item-name">Email:</span>
                                <span class="w-contacts-item-value"><a href="mailto:admin@bluebee.com">info@example.com</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-hr">
                    <span class="g-hr-h">
                        <i class="fa fa-star"></i>
                    </span>
                </div>
                <div class="wpb_text_column ">
                    <div class="wpb_wrapper">
                        <h4>Mạng xã hội</h4>
                    </div>
                </div>
                <div class="w-socials size_big">
                    <div class="w-socials-h">
                        <div class="w-socials-list">
                            <div class="w-socials-item facebook">
                                <a class="w-socials-item-link" target="_blank" href="">
                                    <i class="icon-facebook"></i>
                                </a>
                                <div class="w-socials-item-popup">
                                    <div class="w-socials-item-popup-h">
                                        <span class="w-socials-item-popup-text">Facebook</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-socials-item twitter">
                                <a class="w-socials-item-link" target="_blank" href="javascript:void(0);">
                                    <i class="icon-twitter"></i>
                                </a>
                                <div class="w-socials-item-popup">
                                    <div class="w-socials-item-popup-h">
                                        <span class="w-socials-item-popup-text">Twitter</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-socials-item gplus">
                                <a class="w-socials-item-link" target="_blank" href="javascript:void(0);">
                                    <i class="icon-google-plus"></i>
                                </a>
                                <div class="w-socials-item-popup">
                                    <div class="w-socials-item-popup-h">
                                        <span class="w-socials-item-popup-text">Google</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="two-thirds">
                <div class="wpb_text_column ">
                    <div class="wpb_wrapper">
                        <h3>Giữ liên lạc với chúng tôi</h3>
                    </div>
                </div>
                <div class="wpb_text_column ">
                    <div class="wpb_wrapper">
                        <p>Thêm gì đó vào đây</p>
                    </div>
                </div>
                <form class="g-form" action="" method="post">
                    <input type="hidden" name="action" value="contact">
                    <div class="g-form-group">
                        <div class="g-form-group-rows">
                            <div class="g-form-row">
                                <div class="g-form-row-label">
                                    <label class="g-form-row-label-h" for="contact_name">Tên của bạn *</label>
                                </div>
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <input type="text" name="contact_name" id="contact_name" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-label">
                                    <label class="g-form-row-label-h" for="contact_email">Email *</label>
                                </div>
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <input type="text" name="contact_email" id="contact_email" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-label">
                                    <label class="g-form-row-label-h" for="input1x3">Tin nhắn của bạn *</label>
                                </div>
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <textarea name="contact_message" id="contact_message" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-field">
                                    <button class="g-btn type_primary">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>