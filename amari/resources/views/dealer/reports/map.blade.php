@extends('layouts.dealer')

@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">
      <div class="table-wrapper">
       


      <div id="map"></div>




      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
<script>
  (function() {
   $('#routes').DataTable({
       dom: 'Bfrtip',
   buttons: [
       'colvis',
       'excel',
       'print',
       'copy', 'pdf','csv'
   ],
       responsive: true,
       language: {
         searchPlaceholder: 'Search...',
         sSearch: '',
         lengthMenu: '_MENU_ items/page',
       },
  
     });
})();
   </script>
     <script>
      (function() {
      $('#editroute').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var name = button.data('name') // Extract info from data-* attributes
  document.getElementById('routename').value = name
  document.getElementById('routeid').value = id
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
})
})();
      </script>
      <script>
        let data = JSON.parse('{!! json_encode($sales) !!}');
       
        const map = L.map('map', {
                    center: [1.3733, 32.2903],
                    zoom: 8
                    });
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' }).addTo(map);

const basicBeachIcon = L.icon({
  iconUrl: 'https://cdn-icons-png.flaticon.com/512/891/891462.png',
  iconSize: [40, 40],
});

data.forEach((item)=>{
  const marker1 = L.marker([item.latitude, item.longitude], {icon: basicBeachIcon})
    .bindPopup(item.customer.name || '')
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