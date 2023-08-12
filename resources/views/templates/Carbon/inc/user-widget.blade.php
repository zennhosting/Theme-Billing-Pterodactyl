<div class="col-xl-4 order-xl-2">
	<div class="card card-profile">
		<img src="@if(isset($settings['profile_img_url'])){{ $settings['profile_img_url'] }}@else /billing-src/img/profile-background.jpg @endif" alt="Image placeholder" class="card-img-top">
		<div class="row justify-content-center">
			<div class="col-lg-3 order-lg-2">
				<div class="card-profile-image">
					<a href="#">
						<img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="rounded-circle">
					</a>
				</div>
			</div>
		</div>
		<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
			<div class="d-flex justify-content-between">
				<a href="/account" class="btn btn-sm btn-info  mr-9 ">{!! Bill::lang()->get('edit_account') !!}</a>
				<a href="/account/api" class="btn btn-sm btn-default float-right">{!! Bill::lang()->get('account_api') !!}</a>
			</div>
		</div>
		<div class="card-body pt-0">
			<div class="row">
				<div class="col">
					<div class="card-profile-stats d-flex justify-content-center">
						<div>
							<span class="heading">@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif{{ $billding_user->balance }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</span>
							<span class="description">{!! Bill::lang()->get('balance_page') !!}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center">
				<h5 class="h3">
						{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}<span class="font-weight-light"></span>
				</h5>
				<div class="h5 font-weight-300">
					<i class="ni location_pin mr-2"></i><strong>{{ Auth::user()->email }}</strong>
				</div>
				<div class="h5 mt-4">
					<i class="ni business_briefcase-24 mr-2"></i><strong>{{ Auth::user()->created_at }}</strong>
				</div>
				<div>
				</div>
			</div>
		</div>
	</div>
</div>