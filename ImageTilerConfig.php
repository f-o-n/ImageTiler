<?php namespace ProcessWire;

class ImageTilerConfig extends ModuleConfig {
  public function getDefaults() {
    return array(
        "format" => "jpg",
        "quality" => "80",
		"tileSize" => 256,
		"fillColor" => "#FFFFF"
    );
  }
      //tileImage($sourceImagePath, $destination, $this->format, $this->quality, $this->tileSize, $this->fillColor);

  public function getInputfields() {
    $inputfields = parent::getInputfields();

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'tileSize');
    $f->attr('size', 10);
    $f->label = __('Tile Size');
    $f->description = __('The hight and width of a single tile');
    $f->columnWidth = 20;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'fillColor');
    $f->attr('size', 10);
    $f->label = __('Fill Color');
    $f->description = __('Color to fill the free space if tile is not square');
    $f->columnWidth = 20;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldSelect");
    $f->attr('name', 'format');
    $f->label = __('Image Format');
    $f->description = __('The image format for the tiles. Transparancy is enabled if PNG is chosen');
    $f->addOption('jpg');
    $f->addOption('png');
    $f->columnWidth = 20;
    $inputfields->add($f);

    $f = $this->modules->get("InputfieldText");
    $f->attr('name', 'quality');
    $f->attr('size', 10);
    $f->label = __('Quality');
    $f->description = __('Possible quality values for the jpg format are 0 (worst quality) - 100 (best quality). For the png format possible values are 0 (low compression) - 9 (high compresseion)');
    $f->columnWidth = 40;
    $inputfields->add($f);

    return $inputfields;
  }
}
