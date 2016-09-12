 <div  class="map">
    <div id="map_canvas" ></div>
    <div class="table">
        <div class="dir_gm">
            <label for="address" class="etiqueta">Direcci&oacute;n</label>
            <input type="text" id="address" name="direccion" class="text" />
            <button onclick="calcRouteInverse()">Ruta inversa</button>
            <input type="hidden" id="latitude" name="latitude" class="text" />
            <input type="hidden" id="longitude" name="longitude" class="text" />
        </div>
        <div id="dirs"></div>
    </div>
</div>