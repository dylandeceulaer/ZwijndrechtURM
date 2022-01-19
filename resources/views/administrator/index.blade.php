@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Instellingen URM</div>
                
                <div class="card-body">
                    <a href="administrator/gebruikers" class="btn btn-lg btn-primary"><span class="fas fa-fw fa-users-cog"></span> Gebruikers & Rollen</a>
                    <a href="administrator/gebruikersprofielen" class="btn btn-lg btn-primary"><span class="fas fa-fw fa-id-badge"></span> Gebruikersprofielen</a>
                    <a href="administrator/toepassingen" class="btn btn-lg btn-primary"><span class="fas fa-fw fa-boxes"></span> Toepassingen</a>
                    <a href="administrator/diensten" class="btn btn-lg btn-primary"><span class="fas fa-fw fa-users"></span> Diensten & Teams</a>
                    <a href="administrator/rapporten" class="btn btn-lg btn-primary"><span class="fas fa-fw fa-chart-bar"></span> Rapporten</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
