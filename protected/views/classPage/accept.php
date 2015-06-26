<script type="text/javascript">
    $(document).ready(function() {
            setTimeout(function() {
                location.href = '<?php echo $link ?>'
            }, 3000);
    });
</script>
<!-- MAIN -->
<div class="l-submain" style="height: 100%; padding-top: 10px">
    <div class="l-submain-h i-cf">
        <div class="l-content">
            <div class="l-content-h i-widgets">
                <div id="alert" style="position: absolute; z-index: 99; width: 100%; top: -55px; display: none; text-align: center">

                </div>
                <div class="g-cols" style="margin-top: 10%; margin-bottom: 0">
                    <div class="two-thirds">
                        <div id="alert" style=" text-align: center">
                            <div class="g-form-row-field"> 
                                <div id="success" class="g-alert type_success">
                                    <div class="g-alert-body" style="text-align: center">
                                        <p><b><?php echo $message ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- /MAIN -->