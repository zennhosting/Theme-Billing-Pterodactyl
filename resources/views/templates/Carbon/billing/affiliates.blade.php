@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'affiliates'])
<div class="grey-bg container-fluid">
   @extends('templates/wrapper', [
   'css' => ['body' => 'bg-neutral-800'],
   ])
   @section('container')
   <div class=" py-md pt-5">
      <div class="row" style="display: flex;flex-direction: row-reverse;">
         <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
               <div class="card-body pt-0">
                  <div class="row">
                     <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center">
                           <div>
                              <span class="heading">{{$settings['currency_symbol']}}@if(isset($affiliate['total_earned'])) {{$affiliate['total_earned']}} @else 0 @endif {{$settings['paypal_currency']}}</span>
                              <span class="description">Total Earnings</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="text-center">
                     <h5 class="h3">
                     {{ Auth::user()->username }}<span class="font-weight-light"></span>
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
                  @if(isset($affiliate['total_earned']))
                   <a href="{{ route('billing.affiliate.cashout') }}" class="btn btn-success btn-sm" style="width: 100%">Cash Out</a>
                  @endif
               </div>
            </div>
            <div class="alert alert-info" role="alert">
              You need a minimun of {{$settings['currency_symbol']}}10.00 {{$settings['paypal_currency']}} to cashout.
            </div>

            <div class="card-body pt-4">
               <h3>Leaderbords</h3>
               <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                     <thead class="thead-light">
                           <tr>
                              <th scope="col" class="sort" data-sort="username" style="background:transparent !important;">Username / Code</th>
                              <th scope="col" class="sort" data-sort="clicks" style="background:transparent !important;">Clicks</th>
                              <th scope="col" class="sort" data-sort="purchases" style="background:transparent !important;">Purchases</th>
                           </tr>
                     </thead>
                     <tbody class="list">
                        @php use Pterodactyl\Models\User; @endphp
                        @foreach(Bill::affiliates()->orderByRaw('purchases DESC')->paginate(5) as $affiliate)
                           @if(User::where('id', $affiliate->user_id)->exists())
                           <tr>
                              <th scope="row">
                                 <div class="media align-items-center">
                                       <a href="#" class="avatar rounded-circle mr-3">
                                          <img alt="Image placeholder" src="https://www.gravatar.com/avatar/{{ md5(strtolower(User::find($affiliate->user_id)->email)) }}?s=160" />
                                       </a>
                                       <div class="media-body">
                                          <span class="username mb-0 text-sm">{{ User::find($affiliate->user_id)->username }} ({{ $affiliate->code }})</span>
                                       </div>
                                 </div>
                              </th>
                              <td class="clicks">
                                 {{ $affiliate->clicks }} clicks
                              </td>
                              <td>
                                 {{ $affiliate->purchases }} purchases
                              </td>
                           </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               </div>

            </div>
         </div>
         <div class="col-xl-8 order-xl-1">
            <div class="row">
            @if(!is_null($affiliate))
               <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                  <div class="card">
                     <div class="card-body p-3">
                        <div class="row">
                           <div class="col-8">
                              <div class="numbers">
                                 <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Clicks</p>
                                 <h5 class="font-weight-bolder" id="domain_text"><span class="text-success text-sm font-weight-bolder">@if(isset($affiliate['clicks'])) {{$affiliate['clicks']}} @else 0 @endif Clicks</span></h5>
                              </div>
                           </div>
                           <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                 <i class='bx bx-mouse-alt' style="color: white;"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                  <div class="card">
                     <div class="card-body p-3">
                        <div class="row">
                           <div class="col-8">
                              <div class="numbers">
                                 <p class="text-sm mb-0 text-uppercase font-weight-bold">Affiliate Code</p>
                                 <h5 class="font-weight-bolder">
                                    <span class="text-success text-sm font-weight-bolder">{{ $affiliate['code'] }}</span>
                                 </h5>
                              </div>
                           </div>
                           <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                 <i class='bx bx-fingerprint' style="color: white;"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                  <div class="card">
                     <div class="card-body p-3">
                        <div class="row">
                           <div class="col-8">
                              <div class="numbers">
                                 <p class="text-sm mb-0 text-uppercase font-weight-bold">Purchases / Commision</p>
                                 <h5 class="font-weight-bolder">
                                    <span class="text-success text-sm font-weight-bolder"> @if(isset($affiliate['purchases'])) {{$affiliate['purchases']}} @else 5 @endif purchases @if(isset($affiliate['creator_commision'])) {{$affiliate['creator_commision']}}% @else 5% @endif commision</span>
                                 </h5>
                              </div>
                           </div>
                           <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                 <i class="bx bx-cart" style="color: white;"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            @endif
            </div>
              <div class="card">
               <div class="card-header">
                  <div class="row align-items-center">
                     <div class="col-12">
                        <h3 class="mb-0">Affiliates Program</h3>
                     </div>
                     <div class="col-4 text-right">
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                  </div>
                  <p>
                     Join the Affiliate program to earn money by inviting other users to us. If you invite a friend and they make a purchase, 
                     you will receive a percentage of their purchase which will be added to your affiliates account.
                     <br>
                     <br>
                     If you are a content creator or have a large network, please contact us and we can give you a higher commision rate.
                  </p>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <div class="row">
                  </div>
                  @if(is_null($affiliate))
                   <div class="row" style="display: flex;justify-content: center;">
                     <div class="alert alert-warning" role="alert">
                       To start with affiliates, please activate your affiliates account.
                     </div>
                     <a href="{{ route('billing.affiliate.create') }}" type="button" class="btn btn-primary" style="width: 100%"><i class='bx bx-revision'></i> Activate Affiliates Account</a>
                     </div>
                  @else
                  <div class="input-group">
                     <input type="text" class="form-control" value="{{route('billing.affiliate.invite', ['code' => $affiliate['code']])}}" disabled>
                     <div class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="Copy('{{route('billing.affiliate.invite', ['code' => $affiliate['code']])}}')" type="button" id="copy"><i class='bx bs-copy' ></i> Copy</button>
                     </div>
                  </div>
               </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
function Copy (str) {
   // Create new element
   var el = document.createElement('textarea');
   // Set value (string to be copied)
   el.value = str;
   // Set non-editable to avoid focus and move outside of view
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Select text inside element
   el.select();
   // Copy text to clipboard
   document.execCommand('copy');
   // Remove temporary element
   document.body.removeChild(el);
   document.getElementById("copy").innerHTML = "Copied";
}
</script>
@endsection
@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')