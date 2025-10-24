<?php
$right_side_fixed_panel_for_health_checks = (get_field('right_side_fixed_panel_for_health_checks') === 'en_only');
$cssClass = [];
if ($right_side_fixed_panel_for_health_checks) {
    $cssClass[] = '-en-only';
}
if (isLandingPage('arabic')) {
    $cssClass[] = '-rtl';
}
?>
<div
    id="health-check-cta"
    class="<?= implode(' ', $cssClass) ?>"
>
    <div class="full">
        <div class="inner">
            <?php if (is_single() || basename(get_page_template()) === 'resources.php'): ?>
                <h3 class="wt-bold" style="margin-bottom: 4px">
                    Take our free<br />
                    health check<br />
                </h3>
                <p style="margin: 0 0 10px">It only takes 3 minutes</p>
                <a class="language" href="#health-check">Take the health check</a>
            <?php else: ?>
                <?php if (isLandingPage('arabic')): ?>
                    <h3 class="wt-bold" style="font-size: 38px;line-height: 1.4;">
                        تحقّق من <br>أهليتك اليوم
                    </h3>
                <?php elseif (isLandingPage('vietnamese')): ?>
                    <h3 class="wt-bold" style="font-size: 19px;line-height: 1.4;">
                        Kiểm tra điều kiện sức khỏe của bạn
                    </h3>
                <?php else: ?>
                    <h3 class="wt-bold" style="margin-bottom: 4px">
                        Check your<br/>
                        eligibility today<br />
                    </h3>
                    <p style="margin: 0 0 10px">It only takes 2 minutes</p>
                <?php endif ?>
                <?php if (isLandingPage('chinese')): ?>
                    <!-- /learn-about-life/for-chinese-communities -->
                    <a class="language" href="#health-check">Take the health check</a>
                    <a class="language" href="#health-check-chinese-simplified">进行健康检查 (简体中文版)</a>
                    <a class="language" href="#health-check-chinese-traditional">進行健康檢查 (繁體中文版)</a>
                <?php elseif (isLandingPage('arabic')): ?>
                    <!-- /learn-about-life/for-arabic-communities -->
                    <!-- <a class="language" href="#health-check-arabic" style="font-size: 22px">اعمل الفحص الصحي</a> -->
                    <p
                        style="font-size: 18px;line-height: 1.6;"
                    >يستغرق إجراء الفحص <br>الصحي دقيقتين فقط</p>
                    <a 
                        class="language"
                        href="#health-check-arabic"
                        style="font-size: 22px; line-height: 1.4;margin-top:12px"
                    >اعمل الفحص الصحي</a>
                <?php elseif (isLandingPage('vietnamese')): ?>
                    <!-- /learn-about-life/for-vietnamese-communities -->
                    <p
                        style="font-size: 13px;line-height: 1.6;margin-top: 0"
                    >Chỉ mất có 2 phút để làm cuộc kiểm tra sức khỏe</p>
                    <a
                        class="language"
                        href="#health-check-vietnamese"
                        style="font-size: 16px;line-height: 1.4;margin-top: 15px;"
                    >Hãy làm cuộc kiểm tra sức khỏe</a>
                <?php else: ?>
                    <!-- default -->
                    <a class="language" href="#health-check">Take the health check</a>
                    <?php if ( ! $right_side_fixed_panel_for_health_checks): ?>
                        <a class="language" href="#health-check-chinese-simplified">做这项健康检查</a>
                        <a class="language" href="#health-check-chinese-traditional">做這項健康檢查</a>
                        <a class="language" href="#health-check-arabic">اعمل الفحص الصحي</a>
                        <a class="language" href="#health-check-vietnamese">Hãy làm cuộc kiểm tra sức khỏe</a>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
    <div class="mini">
        <div class="inner">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
</div>
<!-- /#health-check-cta -->
