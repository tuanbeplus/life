<?php
$health_check_trigger_minimised_cookie_name = 'widget_is_minimised';
$cssClassArr = '';
$isMin = $_COOKIE[$health_check_trigger_minimised_cookie_name] ?? '0';
if ($isMin == '1') {
  $cssClassArr .= ' -is-min';
}
$landingPage = isLandingPage();
if ($landingPage) {
  $cssClassArr .= ' -'.$landingPage;
}
?>
<div
  class="health-check-trigger -faded<?= $cssClassArr ?>"
  data-health-check-trigger-minimised-cookie-name="<?= $health_check_trigger_minimised_cookie_name ?>"
>
  <div class="-pos">
    <div class="-bg">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class="-content">
      <div class="-close">
        <svg
          width="1em"
          height="1em"
          viewBox="0 0 20 20"
          version="1.1"
        >
          <path
            d="M0.5,3.5L3.5,0.5L10,7L16.5,0.5L19.5,3.5L13,10L19.5,16.5L16.5,19.5L10,13L3.5,19.5L0.5,16.5L7,10L0.5,3.5Z"
            fill="currentColor"
          />
        </svg>
      </div>
      <?php if (is_single() || basename(get_page_template()) === 'resources.php'): ?>
        <div class="-text">
          <h2>Take our 2 minute health check</h2>
        </div>
        <a class="language" href="#health-check">Start now</a>

      <?php elseif (isLandingPage('arabic')): ?>
        <div class="-text">
          <h2>تحقق من أهليتك في 2 دقائق فقط</h2>
        </div>
        <a class="language" href="#health-check-arabic">ابدأ الفحص الصحي</a>

      <?php elseif (isLandingPage('vietnamese')): ?>
        <div class="-text">
          <h2>Kiểm tra tính đủ điều kiện của bạn chỉ trong 2 phút</h2>
        </div>
        <a class="language" href="#health-check-vietnamese">Bắt đầu kiểm tra sức khỏe</a>

      <?php elseif (isLandingPage('chinese')): ?>
        <div class="-text">
          <h2>只需 2 分钟即可检查您的资格</h2>
        </div>
        <a class="language -margin-bottom" href="#health-check-chinese-simplified">开始健康检查</a>
        <div class="-text">
          <h2>只需 2 分鐘即可檢查您的資格</h2>
        </div>
        <a class="language" href="#health-check-chinese-traditional">開始健康檢查</a>

      <?php else: ?>
        <div class="-text">
          <h2>Check your eligibilty in only 2 minutes</h2>
        </div>
        <a class="language" href="#health-check">Start health check</a>
      <?php endif ?>
    </div>
  </div>
</div>