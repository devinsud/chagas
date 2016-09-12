<style>
	.titulo_form{
		background-color: #3c3;
		height:35px;
		text-align: center;
		padding:10px;
		font-weight: bold;
		color:#fff;
	}
</style>
<div class="titulo_form">
	Carga de Datos
</div>
	<table>
		<tr>
			<td> N° de Ciclo/Muestreo: <input type="text" name="item[ciclo]" /></td>
			<td> N° de Barrio/Sector: <input type="text" name="item[barrio]" /></td>
			<td> Nombre: <input type="text" name="item[nombre]" id="nombre_barrio" /></td>
			<td> N° de Lote: <input type="text" name="item[lote]" /></td>
			<td> N° de Manzana: <input type="text" name="item[manzana]" /></td>
		</tr>
	
	<tr>
		<td>
			Vivienda Recuperada: 
			<select name="item[vivienda_recuperada]"></td>
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
		<td>
			Vivienda Inspeccionada: 
			<select name="item[vivienda_inspeccionada]">
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
		<td>
			Vivienda Cerrada: 
			<select name="item[vivienda_cerrada]">
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Vivienda Renuente: 
			<select name="item[vivienda_renuente]">
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
		<td>
			Vivienda Positiva: 
			<select name="item[vivienda_positiva]">
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
		<td>
			Control Qu&iacute;mico
			<select name="item[control_quimico]">
				<option value=""></option>
				<option value="si">si</option>
				<option value="no">no</option>
			</select>
		</td>
		<td>
			Habitantes: <input type="text" name="item[habitantes]" />
			Gramos Aplicados: <input type="text" name="item[gramos_aplicados]" />
		</td>
	</tr>
	<table>
		<thead>
			<th>&nbsp;</th>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th>
			<th>E</th>
			<th>F</th>
			<th>G</th>
			<th>H</th>
			<th>---</th>
			<th>Total</th>
		</thead>
		<tbody>
			<tr>
				<td>Totales</td>
				<td><input type="text" name="item[totales_A]" /></td>
				<td><input type="text" name="item[totales_B]" /></td>
				<td><input type="text" name="item[totales_C]" /></td>
				<td><input type="text" name="item[totales_D]" /></td>
				<td><input type="text" name="item[totales_E]" /></td>
				<td><input type="text" name="item[totales_F]" /></td>
				<td><input type="text" name="item[totales_G]" /></td>
				<td><input type="text" name="item[totales_H]" /></td>
				<td><input type="text" name="item[totales_sub]" /></td>
				<td><input type="text" name="item[totales_total]" /></td>
			</tr>
			<tr>
				<td>Con Agua</td>
				<td><input type="text" name="item[conagua_A]" /></td>
				<td><input type="text" name="item[conagua_B]" /></td>
				<td><input type="text" name="item[conagua_C]" /></td>
				<td><input type="text" name="item[conagua_D]" /></td>
				<td><input type="text" name="item[conagua_E]" /></td>
				<td><input type="text" name="item[conagua_F]" /></td>
				<td><input type="text" name="item[conagua_G]" /></td>
				<td><input type="text" name="item[conagua_H]" /></td>
				<td><input type="text" name="item[conagua_sub]" /></td>
				<td><input type="text" name="item[conagua_total]" /></td>
			</tr>
			<tr>
				<td>Con Larvas/Pupas</td>
				<td><input type="text" name="item[conlarvas_A]" /></td>
				<td><input type="text" name="item[conlarvas_B]" /></td>
				<td><input type="text" name="item[conlarvas_C]" /></td>
				<td><input type="text" name="item[conlarvas_D]" /></td>
				<td><input type="text" name="item[conlarvas_E]" /></td>
				<td><input type="text" name="item[conlarvas_F]" /></td>
				<td><input type="text" name="item[conlarvas_G]" /></td>
				<td><input type="text" name="item[conlarvas_H]" /></td>
				<td><input type="text" name="item[conlarvas_sub]" /></td>
				<td><input type="text" name="item[conlarvas_total]" /></td>
			</tr>
		</tbody>
	</table>
	
	
	
	

	

	<input type="text" name="item[positivos_A]" />
	<input type="text" name="item[positivos_B]" />
	<input type="text" name="item[positivos_C]" />
	<input type="text" name="item[positivos_D]" />
	<input type="text" name="item[positivos_E]" />
	<input type="text" name="item[positivos_F]" />
	<input type="text" name="item[positivos_G]" />
	<input type="text" name="item[positivos_H]" />
	<input type="text" name="item[positivos_sub]" />
	<input type="text" name="item[positivos_total]" />

	</table>



