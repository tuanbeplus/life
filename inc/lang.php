<?php

$landingPageIds = [
  'chinese' => '1928',
  'arabic' => '1926',
  'vietnamese' => '1931',
  // 'english' => '7',
];

function isLandingPage($language = null) {
  global $landingPageIds;
  static $id;
  if ($id === null) {
    $id = get_the_ID();
  }
  return ($language === null)
    ? array_search($id, $landingPageIds)
    : $id == $landingPageIds[$language];
}

function healthCheckModalHref() {
  global $landingPageIds;
  switch (get_the_ID()) {
    case $landingPageIds['arabic']: return '#health-check-arabic';
    case $landingPageIds['vietnamese']: return '#health-check-vietnamese';
    default: return '#health-check';
  }
}



class LangOpt {
  public $label;
  public $url;
  public $value;
  public $landingPage;
  public function __construct($data)
  {
    $this->label = $data['label'];
    $this->url = $data['url'];
    $this->value = $data['value'];
    $this->landingPage = $data['landingPage'];
  }
}

class PageLang
{
  public $lang; /* 'en' | 'zh' | 'ar' | 'vi' */
  private $_langPrecise; /* zh-Hans | zh-Hant */
  public $opts;
  public $optI = 0; /* defaults to english */
  private $_healthCheckTriggerProps;

  public function __construct()
  {
    $this->lang = get_field('global_page_language') ?: 'en';
    $this->opts = array_map(function($opt) {
      return new LangOpt($opt);
    }, [
      [
        'label' => 'English',
        'url' => '/',
        'value' => 'en',
        'landingPage' => null,
      ],
      [
        'label' => '中文',
        'url' => '/learn-about-life/for-chinese-communities/',
        'value' => 'zh-CN',
        'landingPage' => 'chinese',
      ],
      [
        'label' => 'العربية',
        'url' => '/learn-about-life/for-arabic-communities/',
        'value' => 'ar',
        'landingPage' => 'arabic',
      ],
      [
        'label' => 'Tiếng Việt',
        'url' => '/learn-about-life/for-vietnamese-communities/',
        'value' => 'vi',
        'landingPage' => 'vietnamese',
      ],
    ]);
    if ($isLandingPage = isLandingPage()) {
      $this->optI = array_search($isLandingPage, array_column($this->opts, 'landingPage'));
    }
  }

  public function precise()
  {
    if ($this->_langPrecise === null) {
      $this->_langPrecise = 'todo';
    }
    return $this->_langPrecise;
  }

  public function selected()
  {
    return $this->opts[$this->optI];
  }

  public function healthCheckTriggerProps()
  {
    if ($this->_healthCheckTriggerProps === null) {
      $this->_healthCheckTriggerProps = $this->_getHealthCheckTriggerProps();
    }
    return $this->_healthCheckTriggerProps;
  }

  private function _getHealthCheckTriggerProps()
  {
    switch ($this->lang) {
      case 'en':
        if (is_single() || basename(get_page_template()) === 'resources.php') {
          return [[
            'takeTheHealthCheck' => 'Take our 2 minute health check',
            'startNow' => 'Start now',
          ]];
        } else {
          return [[
            'takeTheHealthCheck' => 'Check your eligibilty in only 2 minutes',
            'startNow' => 'Start health check',
          ]];
        }
      case 'vi':
        return [[
          'takeTheHealthCheck' => 'Kiểm tra tính đủ điều kiện của bạn chỉ trong 2 phút',
          'startNow' => 'Bắt đầu kiểm tra sức khỏe',
        ]];
      case 'ar':
        return [[
          'takeTheHealthCheck' => 'تحقق من أهليتك في 2 دقائق فقط',
          'startNow' => 'ابدأ الفحص الصحي',
        ]];
      case 'zh':
        return [
          [
            'precise' => 'zh-Hans',
            'takeTheHealthCheck' => '只需 2 分钟即可检查您的资格',
            'startNow' => '开始健康检查',
          ],
          [
            'precise' => 'zh-Hant',
            'takeTheHealthCheck' => '只需 2 分鐘即可檢查您的資格',
            'startNow' => '開始健康檢查',
          ],
        ];
    }
  }
}




function pageLang()
{
  static $pageLang;
  if ($pageLang === null) {
    $pageLang = new PageLang;
  }
  return $pageLang;
}
