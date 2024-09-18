@extends('layouts.admin')
@section('content')


     
       <div id="map" style="width: 50%;
        height: 100px;"></div>
   



@endsection
@section('scripts')
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script>
        let data = JSON.parse('{!! json_encode($sales) !!}');
       
        const map = L.map('map', {
                    center: [1.3733, 32.2903],
                    zoom: 8
                    });
                   
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' }).addTo(map);

const basicBeachIcon = L.icon({
  iconUrl: 'https://cdn-icons-png.flaticon.com/512/891/891462.png',
  iconSize: [20, 20],
});

data.forEach((item)=>{
  const marker1 = L.marker([item.latitude, item.longitude], {icon: basicBeachIcon})
    .bindPopup(item.customer.name)
    .addTo(map);
        })



const basemaps = {
  StreetView: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',   {attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}),
  Topography: L.tileLayer.wms('http://ows.mundialis.de/services/service?',   {layers: 'TOPO-WMS'}),
  Places: L.tileLayer.wms('http://ows.mundialis.de/services/service?', {layers: 'OSM-Overlay-WMS'})
};
L.control.layers(basemaps).addTo(map);
basemaps.Topography.addTo(map);
        </script>




@endsection
