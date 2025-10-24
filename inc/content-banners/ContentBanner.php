<?php

class ContentBannerTypeFieldType
{
  public $name;
  public $italizeLife = false;
  
  public function __construct($props)
  {
    $this->name = $props['name'];
    $this->italizeLife = $props['italizeLife'] ?? false;
  }
}

class ContentBannerTypeField
{
  public $valRaw;
  public $valProcessed;
  public $type;
  
  public function __construct($type, $valRaw)
  {
    $this->type = $type;
    $this->valRaw = $valRaw;
  }
}

class ContentBannerType
{
  public $title;
  public $template;
  public $acfOptionName;
  public $fieldTypes = [];
  public $banners = []; // id => ContentBanner`
  
  public function __construct($title, $template, $acfOptionName, $vars)
  {
    $this->title = $title;
    $this->template = $template;
    $this->acfOptionName = $acfOptionName;
    foreach ($vars as $varProps) {
      $this->fieldTypes[] = new ContentBannerTypeFieldType($varProps);
    }
  }
  
  public function fetchBanners()
  {
    while( have_rows($this->acfOptionName, 'option') ) {
      the_row();
      $id = get_sub_field('slug');
      $fields = [];
      foreach ($this->fieldTypes as $fieldType) {
        $fields[] = new ContentBannerTypeField($fieldType, get_sub_field($fieldType->name));
      }
      $this->banners[$id] = new ContentBanner($this, $id, $fields);
    }
    return $this;
  }
}

class ContentBanner
{
  public $type;
  public $id;
  private $fields;

  private $_templated;

  public function __construct($type, $id, $fields)
  {
    $this->type = $type;
    $this->id = $id;
    $this->fields = $fields;
  }

  public function templated()
  {
    if ($this->_templated === null) {
      $data = [];
      foreach ($this->fields as $field) {
        // echo '<pre>';
        // var_dump($field->type);
        // echo '</pre>';
        // echo '<h4>'.$field->valRaw.'</h4>';
        // echo '<br><br>';
        if ($field->valProcessed === null) {
          if ($field->type->italizeLife) {
            $field->valProcessed = italizeLifeText($field->valRaw);
          } else {
            $field->valProcessed = $field->valRaw;
          }
        }
        $data[$field->type->name] = $field->valProcessed;
      }
      // echo '<h1>data</h1>';
      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';
      $this->_templated = incTemplateShortcode($this->templateFile(), $data);
    }
    return $this->_templated;
  }

  private function templateFile() {
    return 'content-banner/'.$this->type->template;
  }
}




