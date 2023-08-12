@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'balance'])

<div class="grey-bg container-fluid">
@extends('templates/wrapper', [
'css' => ['body' => 'bg-neutral-800'],
])
@section('container')


<div class="row pt-5">
  <div class="col-xl-12 order-xl-2">
	<div class="card card-profile">
		
		<div class="row justify-content-center">
			<div class="col-lg-3 order-lg-2">
				<div class="card-profile-image">
					<a href="#">
						
					</a>
				</div>
			</div>
		</div>
		
		<div class="card-body pt-0">
			<div class="row">
				<div class="col">
					<div class="card-profile-stats d-flex justify-content-center">
						<div>
              <h1>Bitcoin Payments</h1>
              <hr>
							<!-- <span class="heading">$ 5.9 USD</span>
							<span class="description">Balance</span> -->
						</div>
					</div>
				</div>
			</div>
        <div class="tab-pane fade show" id="tabs-icons-text-giftcards" role="tabpanel" aria-labelledby="tabs-icons-text-giftcards-tab">
          <form action="{{ route('bitpave.checkout') }}" target="_blank" method="GET">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="balance">Enter the amount you want to add</label>
                  <input class="form-control" id="gift-card-code-input" name="amount" placeholder="10">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%"><strong>{!! Bill::lang()->get('confirm') !!}</strong></button>
          </form>
        </div>
		</div>
	</div>
</div>
</div>

@endsection

@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
