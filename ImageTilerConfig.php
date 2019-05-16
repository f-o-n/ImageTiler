<?php namespace ProcessWire;

class ImageTilerConfig extends ModuleConfig {
  public function getDefaults() {
    return array(
        "tileSize" => 128,
        "storeStructure" => "%d/%d/%d",
        "tms" => false,
        "fillColor" => "white",
        "zoomMin" => 0,
        "zoomMax" => 8,
        "scalingUp" => 0,
        "format" => "jpeg",
        "qualityJpeg" => "80"
    );
  }
  public function getInputfields() {
    $inputfields = parent::getInputfields();

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'tileSize');
    $f->attr('size', 10);
    $f->label = __('Tile Size');
    $f->description = __('The tile size');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'storeStructure');
    $f->attr('size', 10);
    $f->label = __('Store Structure');
    $f->description = __('The tile name, can contain / for split zoom, x , y by folder');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldCheckbox");
    $f->attr('name', 'tms');
    $f->label = __('TMS');
    $f->description = __('Use TMS tile addressing, which is used in open-source projects like OpenLayers or TileCache');
    $f->columnWidth = 34;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'fillColor');
    $f->attr('size', 10);
    $f->label = __('Fill Color');
    $f->description = __('Color for fill free space if tile is not a square');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'zoomMin');
    $f->attr('size', 10);
    $f->label = __('Min Zoom');
    $f->description = __('Minimum zoom level when making tiles');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'zoomMax');
    $f->attr('size', 10);
    $f->label = __('Max Zoom');
    $f->description = __('Maximum zoom level when making tiles');
    $f->columnWidth = 34;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'scalingUp');
    $f->attr('size', 10);
    $f->label = __('Scaling Up');
    $f->description = __('Zoom level when scalling up still allowed, when the base image have less size than need for a curent zoom level');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldSelect");
    $f->attr('name', 'format');
    $f->label = __('Image Format');
    $f->description = __('The image format');
    $f->addOption('jpeg');
    $f->addOption('jp2');
    $f->addOption('jpc');
    $f->addOption('jxr');
    $f->addOption('png');
    $f->addOption('png8');
    $f->addOption('png24');
    $f->addOption('png32');
    $f->addOption('png64');
    $f->columnWidth = 33;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->showIf = "format=jpeg";
    $f->attr('name', 'qualityJpeg');
    $f->attr('size', 10);
    $f->label = __('Jpeg Quality');
    $f->description = __('Quality for jpeg format ');
    $f->columnWidth = 34;
    $inputfields->add($f);

    return $inputfields;
  }
}
