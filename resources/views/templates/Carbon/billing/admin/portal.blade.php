@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'portal'])

@section('title')
Portal
@endsection

@section('content-header')
<h1>Portal</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Portal</li>
</ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
  <div class="col-xs-6 col-sm-6 text-center">
      <button onclick="openTeb('faq_content')" class="btn btn-warning" style="width:100%;"><i class="fa fa-fw fa-support"></i> FAQ</button>
  </div>
  <div class="col-xs-6 col-sm-6 text-center">
      <button onclick="openTeb('team_content')" class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-users"></i> Team</button>
  </div>
</div>

<br>

{{-- FAQ --}}
<div class="row" id="faq_content">
  <div class="col-xs-12">
      <form action="{{ route('admin.billing.portal.update') }}" method="POST">
        @csrf

        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title">Portal FAQ Configuration</h3>
          </div>

          <div class="box-body">
            <div class="box box-primary"></div>
            @php
              $faq_key = 0;
            @endphp
            @if(($faqs = Bill::settings()->getFaqs()) != null)
              @foreach($faqs as $key => $value)
                <div id="faq_{{ $key }}">
                  <div class="form-group col-md-12">
                    <button type="button" onclick="removeElement('faq_{{ $key }}')" class="btn btn-sm btn-danger pull-right">X</button>
                  </div>

                  <div class="form-group col-md-12">
                    
                    <label class="control-label">Title</label>
                    <input class="form-control" type="text" name="faq_content[{{ $key }}][title]" value="{{ $value['title'] }}">
                    <br>
                    <label class="control-label">Content</label>
                    <textarea class="form-control" name="faq_content[{{ $key }}][content]" cols="3" rows="3">{{ $value['content'] }}</textarea>
                    
                  </div>
                  <div class="col-md-12 box box-primary"></div>
                </div>
                @php
                  $faq_key = $key + 1;
                @endphp
              @endforeach
            @endif
            <div id="faq_{{ $faq_key }}">
              <div class="form-group col-md-12">
                <button type="button" onclick="removeElement('team_ @isset($records){{ $key }}')@endisset" class="btn btn-sm btn-danger pull-right">X</button>
                <h3 class="box-title">Add new FAQ <small>(Leave empty to not add)</small></h3>
              </div>

              <div class="form-group col-md-12">
                <label class="control-label">Title</label>
                <input class="form-control" type="text" name="faq_content[{{ $faq_key }}][title]">
                <br>
                <label class="control-label">Content</label>
                <textarea class="form-control" name="faq_content[{{ $faq_key }}][content]" cols="3" rows="3"></textarea>
              </div>
              <div class="col-md-12 box box-primary"></div>
              
            </div>

          </div>
        </div>

        <div class="box box-primary">
          <div class="box-footer">
            <button type="submit" name="faq_save" class="btn btn-sm btn-primary">Save</button>
          </div>
        </div>
      </form>
  </div>
</div>


{{-- Teams --}}
<div class="row" id="team_content" style="display: none">
  <div class="col-xs-12">
      <form action="{{ route('admin.billing.portal.update') }}" method="POST">
        @csrf

        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title">Portal Teams Configuration</h3>
          </div>

          <div class="box-body">
            <div class="box box-primary"></div>
            @php
              $team_key = 0;
            @endphp
            @if(($teams = Bill::settings()->getTeams()) != null)
              @foreach($teams as $key => $value)
                <div id="team_{{ $key }}">
                  <div class="form-group col-md-12">
                    <button type="button" onclick="removeElement('team_{{ $key }}')" class="btn btn-sm btn-danger pull-right">X</button>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label class="control-label">Name</label>
                    <input class="form-control" type="text" name="team_content[{{ $key }}][name]" value="{{ $value['name'] }}">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label">Role</label>
                    <input class="form-control" type="text" name="team_content[{{ $key }}][role]" value="{{ $value['role'] }}">
                  </div>
    
                  <div class="form-group col-md-12">
                    <label class="control-label">Avatar</label>
                    <input class="form-control" list="teams-icon-list" name="team_content[{{ $key }}][icon]" value="{{ $value['icon'] }}">
                    <datalist id="teams-icon-list">
                        <option value="/themes/carbon/portal/img/team/team-1.jpg">
                        <option value="/themes/carbon/portal/img/team/team-2.jpg">
                        <option value="/themes/carbon/portal/img/team/team-3.jpg">
                        <option value="/themes/carbon/portal/img/team/team-4.jpg">
                    </datalist>
                  </div>
    
                  <div class="form-group col-md-3">
                    <label class="control-label">Twitter</label>
                    <input class="form-control" name="team_content[{{ $key }}][twitter]" value="{{ $value['twitter'] }}">
                  </div>
                  
                  <div class="form-group col-md-3">
                    <label class="control-label">Twitch</label>
                    <input class="form-control" name="team_content[{{ $key }}][twitch]" value="{{ $value['twitch'] }}">
                  </div>
                  
                  <div class="form-group col-md-3">
                    <label class="control-label">Instagram</label>
                    <input class="form-control" name="team_content[{{ $key }}][instagram]" value="{{ $value['instagram'] }}">
                  </div>
                  
                  <div class="form-group col-md-3">
                    <label class="control-label">Discord</label>
                    <input class="form-control" name="team_content[{{ $key }}][discord]" value="{{ $value['discord'] }}">
                  </div>
    
                  <div class="col-md-12 box box-primary"></div>
                </div>
                @php
                  $team_key = $key + 1;
                @endphp
              @endforeach
            @endif

            <div id="team_{{ $team_key }}">
              <div class="form-group col-md-12">
                <button type="button" onclick="removeElement('team_ @isset($records){{ $key }}')@endisset')" class="btn btn-sm btn-danger pull-right">X</button>
                <h3 class="box-title">Add new Team user <small>(Leave empty to not add)</small></h3>
              </div>

              <div class="form-group col-md-6">
                <label class="control-label">Name</label>
                <input class="form-control" type="text" name="team_content[{{ $team_key }}][name]">
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Role</label>
                <input class="form-control" type="text" name="team_content[{{ $team_key }}][role]">
              </div>

              <div class="form-group col-md-12">
                <label class="control-label">Avatar</label>
                <input class="form-control" list="teams-icon-list" name="team_content[{{ $team_key }}][icon]"/>
                <datalist id="teams-icon-list">
                    <option value="/themes/carbon/portal/img/team/team-1.jpg">
                    <option value="/themes/carbon/portal/img/team/team-2.jpg">
                    <option value="/themes/carbon/portal/img/team/team-3.jpg">
                    <option value="/themes/carbon/portal/img/team/team-4.jpg">
                </datalist>
              </div>

              <div class="form-group col-md-3">
                <label class="control-label">Twitter</label>
                <input class="form-control" name="team_content[{{ $team_key }}][twitter]"/>
              </div>
              
              <div class="form-group col-md-3">
                <label class="control-label">Twitch</label>
                <input class="form-control" name="team_content[{{ $team_key }}][twitch]"/>
              </div>
              
              <div class="form-group col-md-3">
                <label class="control-label">Instagram</label>
                <input class="form-control" name="team_content[{{ $team_key }}][instagram]"/>
              </div>
              
              <div class="form-group col-md-3">
                <label class="control-label">Discord</label>
                <input class="form-control" name="team_content[{{ $team_key }}][discord]"/>
              </div>

              <div class="col-md-12 box box-primary"></div>
            </div>

          </div>
        </div>

        <div class="box box-primary">
          <div class="box-footer">
            <button type="submit" name="team_save" class="btn btn-sm btn-primary">Save</button>
          </div>
        </div>
      </form>
  </div>
</div>


@endsection

<style>

.game-img-card {
  display: flex;
  justify-content: center;
}

.game-img {
  width: 75px;
}

</style>

<script>

  function removeElement(id){
    document.getElementById(id).remove();
  }

  function hiddenAll(){
    document.getElementById("faq_content").style.cssText = "display: none";
    document.getElementById("team_content").style.cssText = "display: none";
    
  }

  function openTeb(id){
    hiddenAll();
    document.getElementById(id).style.cssText = "display: block";
  }
  openTeb('faq_content');

</script>