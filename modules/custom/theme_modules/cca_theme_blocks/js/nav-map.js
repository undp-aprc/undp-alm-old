
var map = L.map('map', {
    center:[35.10418, 0],
    zoom:1.5
});

map.dragging.disable();
map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();

function style(feature) {
	return {
		weight: 2,
		opacity: 1,
		color: '#1E427E',
		fillOpacity: 1,
		fillColor: '#1E427E'
	};
}

function highlightFeature(e) {
    var layer = e.target;
    
    layer.setStyle({
        weight: 2,
        color: '#0055AA',
        dashArray: '',
        fillColor: '#0055AA'
    });
    
    info.update(layer.feature.properties);
}

function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

function navigateToFeature(e) {
    var region = e.target.feature.properties.continent;
    console.log(region);
    switch(region) {
        case 'Africa':
            window.location = '/project-maps/95+337+356+363+369';
        break;
        case 'Asia':
            window.location = '/project-maps/471+477+495+485+507';
        break;
        case 'Europe':
            window.location = '/project-maps/386+397+416';
        break;
        case 'Oceania':
            window.location = '/project-maps/453+447+461';
        break;
        case 'South America':
            window.location = '/project-maps/139';
        break;
        case 'North America':
            window.location = '/project-maps/137+138';
        break;
        default:
            alert('Another continent');
    }
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: navigateToFeature
    });
}

geojson = L.geoJson(WorldMap, {
	style: style,
    onEachFeature: onEachFeature
}).addTo(map);

var info = L.control();

info.onAdd = function(map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
}

info.update = function (properties) {
    this._div.innerHTML = "<h4>Select a region to explore UNDP's programs on Climate Change</h4>";
}

info.addTo(map);