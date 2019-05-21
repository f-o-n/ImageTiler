# ImageTiler

ImageTiler is a [ProcessWire](https://processwire.com/) Module to split large images into tiles which can be used with interactive maps like [Leaflet](https://leafletjs.com/). It uses PHPs [GD library](https://www.php.net/manual/en/book.image.php) for image processing.

## Installation
This module's files should be placed in /site/modules/ImageTiler/
[How to install or uninstall modules](https://modules.processwire.com/install-uninstall/)

## Example usage with Leaflet

[Download](https://leafletjs.com/download.html) and add Leaflet to your project.
The data object is a Json object returned from the call to $image->tile.

```javascript
var map = L.map('map', {
    crs: L.CRS.Simple,
    noWrap: true,
    maxBoundsViscosity:   1,
    attributionControl: false
});

var sw = zoom.map.unproject([0, data.imageHeight], data.maxZoom);
var ne = zoom.map.unproject([data.imageWidth, 0], data.maxZoom);
var bounds = new L.LatLngBounds(sw, ne);

var layer = L.tileLayer(data.url + '/{z}/{x}/{y}.jpg', {
  tileSize: data.tileSize,
  center: [0,0],
  minZoom: data.minZoom,
  maxZoom: data.maxZoom,
  bounds: bounds,
  noWrap: true
}).addTo(map);

map.setMaxBounds(bounds);
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
