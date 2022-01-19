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
	$editingIndex = 0;
	$teams = {!! $teams !!}
	$table = $('#table')
	$data = [];

	//Team filter op basis van de geselecteerde dienst bij het wijzigen van een gebruikersprofiel. BV select DIOR -> ict, secretariaat, communicatie
	$("#form select[name=dienst]").change(function(){
		var selectedVal = $(this).find("option:selected").val();
		$firstselect = false;
		$("#form select[name=team] option").each(function() {
			if($teams[$(this).val()]){
				if(searchById($teams,$(this).val())["dienst_id"] != selectedVal){
					$(this).attr("disabled", "disabled");
				}else{
					$(this).prop("disabled", false);
					if(!$firstselect){
						$("#form select[name=team]").val($(this).val());
						$firstselect = true;
					}
				}
			}
		})
	})

	//trigger bij het aanvinken van de wijzigenknop van een gebruikersprofiel
	$("#check-edit").change(function (e) {
		$('.alert-danger').hide();
		if($("#check-edit").is(":checked")){
			$editingIndex = $('input[name="btSelectItem"]:checked').data('index');
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
			$('#form select[name=dienst]').each(function(){
				$(this).prop('selectedIndex', 0).change();
			})
			$table.bootstrapTable('uncheckAll');
		}else{
			$("#check-edit").prop("disabled", false);
			$isWijziging = false;
			$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})
			SaveEdit();
		}
	});

	//De promt sluiten zonder op te slaan
	$('#wijzigingenModal').on('hidden.bs.modal', function () {
		$isWijziging = false;
		//Vul de velden van de nieuwe selectie in
		fillData($table.bootstrapTable("getSelections")[0]);
		//Toggle edit switch zonder event te triggeren
		$('#check-edit, #check-nieuw').data('bs.toggle').off(true);
		$('#check-edit').data('bs.toggle').off(true);
		$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})

	})
	//De promt sluiten met opslaan
	$('#modalButtonSave').on("click", function(){
		$('#check-edit, #check-nieuw').data('bs.toggle').off(true);
		$('#check-edit').data('bs.toggle').off(true);
		$isWijziging = false;
		SaveEdit();
		$('#wijzigingenModal').modal('hide');
		fillData($table.bootstrapTable("getSelections")[0]);
		$('#form input, #form select').each(function(){
				$(this).attr("disabled", "disabled");
			})
	})

	//Opslaan van gewijzigde gebruikersprofiel
	function SaveEdit(){
		$model = {}
		if($editingIndex != null){
			$model["id"] = $("#form input[name=id]").val();
		}
		$model["teamid"] = $("#form select[name=team]").val();
		$model["naam"] = $("#form input[name=naam]").val();
		$model["organogram_naam"] = $("#form input[name=organogram_naam]").val();
		$.post("gebruikersprofielen",$model).done(function($res) {
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

	//Data refreshen van de bewerkte rij in de tabel gebruikersprofielen
	function updateCurrentRow($res){
		$currentRow = $table.bootstrapTable('getData')[$editingIndex];
		if($editingIndex == null){
			$currentRow = {}
		}
		$currentRow['id'] = $res['id'];
		$currentRow['naam'] = $res['naam'];
		$currentRow['organogram_naam'] = $res['organogram_naam'];
		$currentRow['team.naam'] = $res['team'].naam;
		$currentRow['team_id'] = $res['team'].id;
		$currentRow['team.dienst_id'] = $res['team'].dienst_id
		$currentRow['team.dienst.naam'] = $res['team'].dienst.naam;
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

	function refreshData(){
		$tempdata = [];
		$.getJSON('gebruikersprofielen/',function(data){
			$.each(data, function(i, element) { 
				$tempdata.push(JSON.flatten(element));
			});
			$table.bootstrapTable('load', $tempdata);
		})
	}
	//initialisatie van de tables
	$('#toepassingTable').bootstrapTable();
	$('#gebruikersTable').bootstrapTable();
	$('#toepassingToevoegenTable').bootstrapTable();
	
	$table.bootstrapTable();
	refreshData();

	function fillData(data){
		if($isWijziging){
			$('#wijzigingenModal').modal('show');
		}else{
			$("#form input[name=id]").val(data["id"])
			$("#form input[name=naam]").val(data["naam"])
			$("#form input[name=organogram_naam]").val(data["organogram_naam"])
			$("#form select[name=dienst]").val(data["team.dienst_id"]);
			$("#form select[name=dienst]").trigger("change");
			$("#form select[name=team]").val(data["team_id"]);
			$("#check-edit").prop("disabled", false);
			$('#toepassingTable').bootstrapTable('refresh', {url: 'gebruikersprofielen/'+data["id"]+'/toepassingen'})
			$('#gebruikersTable').bootstrapTable('refresh', {url: 'gebruikersprofielen/'+data["id"]+'/gebruikers'})
		}
	}
	//Event bij het aanklikken van een gebruikersprofiel. Deze vult gegevens eronder in. 
	$table.on('check.bs.table', function (e, row, $element) {
		fillData(row);
		$('#collapseToepassingToevoegen').collapse('hide');
		$("#content").scrollToMe();
	})
	//Events van gegenereerde tabellen.
	window.operateEvents = {
		//Toepassing verwijderen inline
		'click .removeToep': function (e, value, row, index) {
			$.getJSON('gebruikersprofielen/'+row.pivot["gebruikersprofiel_id"]+'/gebruikers',function(data){
				$antw = "";
				if(data.length >0){
					$antw = "Dit gebruikersprofiel is gekoppeld aan deze person(en): "
					$.each( data, function( key, val ) {
						$antw = $antw +"<b>"+ val["naam"] + "</b> "
					});
					$antw = $antw + ". Voor deze personen zal een taak aangemaakt worden bij de toepassingsverantwoordelijke."
				}
				spawnModal("Toepassing verwijderen uit gebruikersprofiel",
					"Weet u zeker dat u deze toepassing wilt verwijderen uit dit profiel? <br><br>"+$antw,
					"Annuleren",
					"ja",
					function(){
						console.log("Toch niet verwijderen.")
					},
					function(){
						$model={};
						$model["id"] = row.pivot["gebruikersprofiel_id"]
						$model["toepassingid"] = row['id']
						$model["removeToepassing"] = true
						$.post("gebruikersprofielen",$model).done(function() {
							$("#toepassingTable").bootstrapTable('remove', {field: 'id', values: [row['id']]})
							notify("success",'Toepassing verwijderd');
  						}).fail(function($msg) {
    						notify("danger",$msg["responseJSON"]);
  						}); 
					}
				)
			});
		},
		//Toepassing toevoegen
		'click .addToep': function (e, value, row, index) {
			if(!$table.bootstrapTable("getSelections")[0]){
				notify("danger",'Geen gebruikersprofiel geselecteerd!');
			}else{
				row["pivot.meerInfo"] = $(e.target.parentElement.parentElement.parentElement.querySelector('textarea')).val();

				$model = {}
				$model["id"] = $table.bootstrapTable("getSelections")[0]["id"]
				$model["toepassingid"] = row['id']
				$model["pivot_meerInfo"] = row["pivot.meerInfo"]
				$.post("gebruikersprofielen",$model).done(function() {
					$appendRow = row;
					$appendRow.pivot = {};
					$appendRow.pivot['meerInfo'] = row["pivot.meerInfo"];
					$appendRow.pivot['gebruikersprofiel_id'] = $model["id"];
					$i = getRowByNameField(row["naam"])
					if($i != null){
						$("#toepassingTable").bootstrapTable('updateRow', {index: $i, row: $appendRow})

					}else{
						$("#toepassingTable").bootstrapTable('append', $appendRow)
					}
					
					notify("success",'Toepassing toegevoegd');
  				}).fail(function($msg) {
    				notify("danger",$msg["responseJSON"]);
  				}); 
			}
		}
	}
	function isString (obj) {
  		return (Object.prototype.toString.call(obj) === '[object String]');
	}
	function getRowByNameField(name){
		$tableRow = $("#toepassingTable td").filter(function() {
    		return $(this).text() == name;
		}).closest("tr");
		return $tableRow.data('index')
	}
	
})
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Selecteer een gebruikersprofiel</div>
					<table id="table" class="table table-condensed" 
						data-filter-control="true"
						data-click-to-select="true"
						data-single-select="true"
						data-maintain-meta-data="true"
						data-toggle="table"
						data-height="360">
						<thead>
							<tr>
								<th data-sortable="false" data-radio="true" ></th>
								<th data-field="team.dienst.naam" data-sortable="true" data-filter-control="select" >Dienst</th>
								<th data-field="team.naam" data-sortable="true" data-filter-control="select" >team</th>
								<th data-field="naam" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="filter op naam">naam</th>
								<th data-field="organogram_naam" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="filter op organogramnaam">Organogramnaam</th>
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
							Gebruikersprofiel
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
								<label for="dienst" class="font-weight-normal">Dienst</label>
								<select name="dienst"  class="form-control" disabled>
									@foreach($diensten as $dienst)
										<option value="{{ $dienst->id }}">{{ $dienst->naam }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="team" class="font-weight-normal">Team</label>
								<select name="team" class="form-control" disabled>
									@foreach($teams as $team)
										<option value="{{ $team->id }}">{{ $team->naam }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="naam" class="font-weight-normal">Naam</label>
								<input type="text" class="form-control" name="naam" disabled>
							</div>
							<div class="form-group col-md-3">
								<label for="organogram_naam" class="font-weight-normal" >Organogram naam</label>
								<input type="text" class="form-control" name="organogram_naam" disabled>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
		<div class="col-md-12">
            <div class="card">
				<div class="card-header">
					Toegewezen toepassingen voor dit gebruikersprofiel
				</div>
				<div class="card-body" id="content">
					<table id="toepassingTable" class="table table-condensed" 
						data-virtual-scroll="true"
						data-click-to-select="true"
						data-single-select="false"
						>
						<thead>
							<tr>
								<th data-sortable="false" data-checkbox="true" ></th>
								<th data-field="naam" data-sortable="true">Naam</th>
								<th data-field="beschrijving" data-sortable="true" >Beschrijving</th>
								<th data-field="toepassingsoort.naam" data-sortable="true" >Toepassingsoort</th>
								<th data-field="pivot.meerInfo" >Meer Info</th>
								<th data-field="id" data-events="operateEvents" data-formatter="<a class='removeToep' href='#%s' title='verwijder van dit gebruikersprofiel'><i class='fa fa-trash-alt'></i></a>">Acties</th>
							</tr>
						</thead>
					</table>
					<div class="card mt-3">
						<div class="card-header">
							<button class="btn btn-link font-weight-bold" data-toggle="collapse" data-target="#collapseToepassingToevoegen" aria-expanded="false" aria-controls="collapseToepassingToevoegen">
								Toepassingen toevoegen
							</button>
						</div>
						<div class="collapse" id="collapseToepassingToevoegen">
							<table id="toepassingToevoegenTable" class="table table-condensed" style="overflow-x: auto; overflow-y: auto; height: auto; /\*  before 100%*/" 
								data-click-to-select="false"
								data-url="toepassingen"
								data-filter-control="true"
								data-toggle="table"
								data-height="400"
								>
								<thead>
									<tr>
										<th data-field="naam" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="zoek op naam">Naam</th>
										<th data-field="beschrijving" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="zoek op beschrijving" >Beschrijving</th>
										<th data-field="toepassingsoort.naam" data-sortable="true" data-filter-control="input" data-filter-control-placeholder="zoek op soort" >Toepassingsoort</th>
										<th data-field="pivot.meerInfo" data-formatter="<textarea rows='1' cols='20'></textarea>">Meer Info</th>
										<th data-field="id" data-events="operateEvents" data-formatter="<a class='addToep' href='#%s' title='Deze Toepassing Toevoegen'><i class='fa fa-plus'></i></a>">Acties</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
            </div>
        </div>
		<div class="col-md-12">
            <div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-md-5 text-block ">
							Toegewezen gebruikers
						</div>
						<div class="col-md-7 text-primary float-right">
							<span class="float-right">
								(
								<i class="fas fa-exclamation-circle"></i>
								Het wijzigen van toegewezen gebruikers verloopt via de personeelsdienstmenu)
							</span>
						</div>
					</div>
				</div>
			
				<table id="gebruikersTable" class="table table-condensed" 
					data-virtual-scroll="true"
					data-click-to-select="true"
					data-single-select="true"
					>
					<thead>
						<tr>
							<th data-field="naam" data-sortable="true">Naam</th>
							<th data-field="beschrijving" data-sortable="true" >In dienst</th>
							<th data-field="toepassingsoort" data-sortable="true" >Uit dienst</th>
							<th data-field="id" data-formatter="gebruikersTableActies">Acties</th>
						</tr>
					</thead>
				</table>
				
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
