@extends('adminlte::page')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="/js/bootstrap-table-filter-control.min.js" defer></script>
<script src="/js/json-flat.js" defer></script>
<script src="/js/model-helpers.js" defer></script>
<script src="/js/spawnModal.js" defer></script>


<script>
window.operateEvents = {}

window.addEventListener('load', function () {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$isWijziging = false;
	$isWijzigingSoorten = false;
	$editingIndex = 0;
	$table = $('#table');
	$tableSoorten = $('#toepassingsoorttable');

	//trigger bij het aanvinken van de wijzigenknop van een gebruikersprofiel
	$("#check-edit").change(function (e) {
		$('.alert-danger').hide();
		if($("#check-edit").is(":checked")){
			$editingIndex = $('#table input:checked').data('index');
			$isWijziging = true;
			$('#form input, #form select').each(function(){
				$(this).prop("disabled", false);
			})
			$("#check-nieuw").prop("disabled", true);
		}else{
			$isWijziging = false;
			$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})
			$("#check-nieuw").prop("disabled", false);
			SaveEdit();
		}
	});
	//trigger bij het aanmaken van een nieuw profiel. 
	$("#check-nieuw").change(function (e) {
		$('.alert-danger').hide();
		if($("#check-nieuw").is(":checked")){
			$("#check-edit").prop("disabled", true);
			$editingIndex = null;
			$isWijziging = true;
			$('#form input, #form select').each(function(){
				$(this).prop("disabled", false);
			})
			$('#form input').each(function(){
				$(this).prop("value", "");
			})
			$('#form select').each(function(){
				$(this).prop('selectedIndex', 0).change();
			})
			$table.bootstrapTable('uncheckAll');
		}else{
			$isWijziging = false;
			$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})
			SaveEdit();
		}
	});
	$("#checkSoorten-edit").change(function (e) {
		if($("#checkSoorten-edit").is(":checked")){
			$('#toepassingsoortform input').each(function(){
				$(this).prop("disabled", false);
			})
			$("#checkSoorten-nieuw").prop("disabled", true);
		}else{
			$('#toepassingsoortform input').each(function(){
				$(this).attr("disabled", "disabled");
			})
			$("#checkSoorten-nieuw").prop("disabled", false);
			SaveSoortenEdit(false);
		}
	});
	//trigger bij het aanmaken van een nieuw toepassingsoort. 
	$("#checkSoorten-nieuw").change(function (e) {
		if($("#checkSoorten-nieuw").is(":checked")){
			$("#checkSoorten-edit").prop("disabled", true);
			$('#toepassingsoortform input').each(function(){
				$(this).prop("disabled", false);
			})
			$('#toepassingsoortform input').each(function(){
				$(this).prop("value", "");
			})
			$tableSoorten.bootstrapTable('uncheckAll');
		}else{
			$('#toepassingsoortform input').each(function(){
				$(this).attr("disabled", "disabled");
			})
			SaveSoortenEdit(true);
		}
	});

	//De promt sluiten zonder op te slaan
	$('#wijzigingenModal').on('hidden.bs.modal', function () {
		$isWijziging = false;
		//Vul de velden van de nieuwe selectie in
		fillData($table.bootstrapTable("getSelections")[0]);
		//Toggle edit switch zonder event te triggeren
		$('#check-nieuw').data('bs.toggle').off(true);
		$('#check-edit').data('bs.toggle').off(true);
		$("#check-nieuw").prop("disabled", false);
		$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})

	})
	//De promt sluiten met opslaan
	$('#modalButtonSave').on("click", function(){
		$('#check-nieuw').data('bs.toggle').off(true);
		$('#check-edit').data('bs.toggle').off(true);
		$isWijziging = false;
		SaveEdit();
		$('#wijzigingenModal').modal('hide');
		$("#check-nieuw").prop("disabled", false);
		fillData($table.bootstrapTable("getSelections")[0]);
		$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})
	})

	function refreshData(){
		$tempdata = [];
		$.getJSON('toepassingen/',function(data){
			$.each(data, function(i, element) { 
				$tempdata.push(JSON.flatten(element));
			});
			$table.bootstrapTable('load', $tempdata);
		})
	}

	//Opslaan van gewijzigde gebruikersprofiel
	function SaveEdit(){
		$model = {}
		if($editingIndex != null){
			$model["id"] = $("#form input[name=id]").val();
		}
		$model["toepassingsverantwoordelijkeid"] = $("#form select[name=toepassingsverantwoordelijke]").val();
		$model["toepassingsoortid"] = $("#form select[name=toepassingsoort]").val();
		$model["naam"] = $("#form input[name=naam]").val();
		$model["beschrijving"] = $("#form input[name=beschrijving]").val();
		$.post("toepassingen",$model).done(function($res) {
					notify("success",'Wijzigingen opgeslagen!');
					updateCurrentRow($res);
				}).fail(function($msg) {
					if(!isString($msg["responseJSON"])){
						//validatie error
						$('.alert-danger').html('');
						$.each($msg["responseJSON"].errors, function(key, value){
							$('.alert-danger').show();
							$('.alert-danger').append('<li>'+value+'</li>');
                  		});
					}else{
						//andere error
						notify("danger",$msg["responseJSON"]);
					}
				}); 
	}
	function SaveSoortenEdit($isNieuw){
		$model = {}
		if(!$isNieuw){
			$model["id"] = $("#toepassingsoortform input[name=id]").val();
		}
		$model["naam"] = $("#toepassingsoortform input[name=naam]").val();
		$.post("toepassingsoorten",$model).done(function($res) {
					notify("success",'Wijzigingen opgeslagen!');
					updateCurrentRowSoorten($res);
				}).fail(function($msg) {
					notify("danger",$msg["responseJSON"]);
				}); 
	}

	//Data refreshen van de bewerkte rij in de tabel gebruikersprofielen
	function updateCurrentRow($res){
		$currentRow = $table.bootstrapTable('getData')[$editingIndex];
		if($editingIndex == null){
			$currentRow = {}
		}
		$currentRow['id'] = $res['id'];
		$currentRow['naam'] = $res['naam'];
		$currentRow['beschrijving'] = $res['beschrijving'];
		$currentRow['toepassingsoort.naam'] = $res['toepassingsoort'].naam;
		$currentRow['toepassingsoort.id'] = $res['toepassingsoort'].id;
		$currentRow['toepassingsverantwoordelijken.id'] = $res['toepassingsverantwoordelijken'].id
		$currentRow['toepassingsverantwoordelijken.naam'] = $res['toepassingsverantwoordelijken'].naam;
		if($editingIndex == null){
			$newRow = $table.bootstrapTable('append',$currentRow);
			$table.bootstrapTable('check',$('#table').bootstrapTable('getOptions').totalRows-1);
		}else{
			$table.bootstrapTable('updateRow', {
				index: $editingIndex,
				row: $currentRow
			});
		}
	}
	function updateCurrentRowSoorten($res){
		$editingIndex = $('#toepassingsoorttable input[name="toepassingSoorten"]:checked').data('index');

		if($editingIndex == null){
			$('select[name="toepassingsoort"]').append($('<option>', {
    			value: $res['id'],
    			text: $res['naam']
			}));
			$tableSoorten.bootstrapTable('append',{
    			id: $res['id'],
    			naam: $res['naam']
			});
		}else{
			$('select[name="toepassingsoort"] option[value='+$res['id']+']').text($res['naam']).change();
			$tableSoorten.bootstrapTable('updateRow', {
				index: $editingIndex,
				row: {
    			id: $res['id'],
    			naam: $res['naam']
			}
			});
		}
		//Enkel de table refreshen als er niet in gewerkt wordt
		if(!$("#check-nieuw").is(":checked") && !$("#check-edit").is(":checked")){
			refreshData();
		}		
	}

	function fillData(data){
		if($isWijziging){
			$('#wijzigingenModal').modal('show');
		}else{
			$("#form input[name=id]").val(data["id"])
			$("#form input[name=naam]").val(data["naam"])
			$("#form input[name=beschrijving]").val(data["beschrijving"])
			$("#form select[name=toepassingsoort]").val(data["toepassingsoort.id"]);
			$("#form select[name=toepassingsverantwoordelijke]").val(data["toepassingsverantwoordelijken.id"]);
			$("#check-edit").prop("disabled", false);
		}
	}
	//Event bij het aanklikken van een gebruikersprofiel. Deze vult gegevens eronder in. 
	$table.on('check.bs.table', function (e, row, $element) {
		fillData(row);
	})
	$tableSoorten.on('check.bs.table', function (e, row, $element) {
			$("#toepassingsoortform input[name=id]").val(row["id"]);
			$("#toepassingsoortform input[name=naam]").val(row["naam"]);
			$("#checkSoorten-edit").prop("disabled", false);
			$('#checkSoorten-nieuw').data('bs.toggle').off(true);
			$('#checkSoorten-edit').data('bs.toggle').off(true);
	});

	
	//initialisatie van de tables
	$table.bootstrapTable();
	$tableSoorten.bootstrapTable();
	refreshData();

	function isString (obj) {
  		return (Object.prototype.toString.call(obj) === '[object String]');
	}
})
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Selecteer een toepassing</div>
					<table id="table" class="table table-condensed" 
						data-filter-control="true"
						data-click-to-select="true"
						data-single-select="true"
						data-maintain-meta-data="true"
						data-toggle="table"
						data-select-item-name="toepassingen"
						data-height="500">
						<thead>
							<tr>
								<th data-sortable="false" data-radio="true" ></th>
								<th data-field="naam" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="filter op naam">Naam</th>
								<th data-field="beschrijving" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="filter op beschrijving">Beschrijving</th>
								<th data-field="toepassingsoort.naam" data-sortable="true" data-filter-control="select" >Toepassingsoort</th>
								<th data-field="toepassingsverantwoordelijken.naam" data-sortable="true" data-filter-control="select" >Toepassingsverantwoordelijke</th>
								</tr>
						</thead>
					</table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					<div class="row align-items-center">
						<div class="col-md-8 text-block ">
							Toepassing
						</div>
						<div class="col-md-4 ">
							<label class='float-right'>
								<input type="checkbox" id="check-nieuw" data-toggle="toggle" data-on="Opslaan" data-off="Nieuw">
								<input type="checkbox" id="check-edit" data-toggle="toggle" data-on="Opslaan" data-off="Wijzigen" disabled="disabled">
							</label>
						</div>
					</div>
				</div>
				<div class="card-body" id="content">
					<div class="alert alert-danger" style="display:none"></div>
					<form action="POST" id="form">
						<div class="form-row">
							<input type="hidden" name="id">
							<div class="form-group col-md-3">
								<label for="naam" class="font-weight-normal">Naam</label>
								<input type="text" class="form-control" name="naam" disabled>
							</div>
							<div class="form-group col-md-3">
								<label for="beschrijving" class="font-weight-normal">Beschrijving</label>
								<input type="text" class="form-control" name="beschrijving" disabled>
							</div>
							<div class="form-group col-md-3">
								<label for="toepassingsoort" class="font-weight-normal">Toepassingsoort</label>
								<select name="toepassingsoort"  class="form-control" disabled>
									@foreach($toepassingsoorten as $toepassingsoort)
										<option value="{{ $toepassingsoort->id }}">{{ $toepassingsoort->naam }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="toepassingsverantwoordelijke" class="font-weight-normal">Toepassingsverantwoordelijke</label>
								<select name="toepassingsverantwoordelijke"  class="form-control" disabled>
									@foreach($toepassingsverantwoordelijken as $toepassingsverantwoordelijke)
										<option value="{{ $toepassingsverantwoordelijke->id }}">{{ $toepassingsverantwoordelijke->naam }}</option>
									@endforeach
								</select>
							</div>		
						</div>
					</form>
				</div>
            </div>
        </div>
		<div class="col-md-12">
            <div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-md-8 text-block ">
							Toepassingsoorten
						</div>
						<div class="col-md-4 ">
							<label class='float-right'>
								<input type="checkbox" id="checkSoorten-nieuw" data-toggle="toggle" data-on="Opslaan" data-off="Nieuw">
								<input type="checkbox" id="checkSoorten-edit" data-toggle="toggle" data-on="Opslaan" data-off="Wijzigen" disabled="disabled">
							</label>
						</div>
					</div>
				</div>
				<div class="card-body row" id="content">
					<div class="col-md-6">
						<table id="toepassingsoorttable" class="table table-condensed" style="overflow-x: auto; overflow-y: auto; height: auto; /\*  before 100%*/" 
									data-click-to-select="true"
									data-url="toepassingsoorten"
									data-filter-control="true"
									data-toggle="table"
									data-select-item-name="toepassingSoorten"
							>
							<thead>
								<tr>
									<th data-sortable="false" data-radio="true" ></th>
									<th data-field="naam" data-sortable="true">Naam</th>
									</tr>
							</thead>
						</table>
					</div>
					<div class="col-md-6">
						<form action="POST" id="toepassingsoortform">
							<input type="hidden" name="id">
							<div class="form-group">
								<label for="naam" class="font-weight-normal">Naam</label>
								<input type="text" class="form-control" name="naam" disabled>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="wijzigingenModal" tabindex="-1" role="dialog" aria-labelledby="wijzigingenModalLabel" aria-hidden="true">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
     			<div class="modal-header">
        			<h5 class="modal-title" id="wijzigingenModalLabel">Wijzigingen opslaan?</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      			</div>
      			<div class="modal-body">
					<p>Je was iets aan het wijzigen, klik op "Sla wijzigingen op" om eventuele wijzigingen op te slaan alvorens door te gaan.
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Ga verder zonder opslaan</button>
        			<button type="button" class="btn btn-primary" id="modalButtonSave">Sla wijzigingen op</button>
				</div>
			</div>
		</div>
	</div>	
	
</div>


@endsection
