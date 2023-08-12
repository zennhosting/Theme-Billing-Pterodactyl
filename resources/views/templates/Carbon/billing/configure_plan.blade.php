@include('templates.Carbon.inc.header')
  @include('templates.Carbon.inc.navbar', ['active_nav' => 'billing'])
  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])
  @section('container')


  <div class="bg-neutral-800">
    <div class="py-md pt-5">
        <div class="row">
            <div class="col-xl-4 order-xl-2">
                <div class="card card-profile">
                    <img src="/billing-src/img/profile-background.jpg" alt="Image placeholder" class="card-img-top" />
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="https://www.gravatar.com/avatar/d3b80e0a1bb7b228b5928e8dcccc2b4c?s=160" class="rounded-circle" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="/account" class="btn btn-sm btn-info mr-9">Edit Account</a>
                            <a href="/account/api" class="btn btn-sm btn-default float-right">Account API</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center">
                                    <div>
                                        <span class="heading">$ 5.9 USD</span>
                                        <span class="description">Balance</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="h3">laptop user<span class="font-weight-light"></span></h5>
                            <div class="h5 font-weight-300"><i class="ni location_pin mr-2"></i><strong>example@xample.com</strong></div>
                            <div class="h5 mt-4"><i class="ni business_briefcase-24 mr-2"></i><strong>2022-07-02 22:20:16</strong></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mb-0">Configure Custom Plan for Minecraft</h3>
                            </div>
                            <div class="col-4 text-right"></div>
                        </div>
                    </div>
                    <div class="card-body">

                      <div class="slider mb-4">
                        <input type="range" id="memory" min="1" max="25" value="4" oninput="slider('memory', 'memory-value')" style="width: 75%;">
                        <a class="btn btn-icon btn-2 btn-primary" style="border-radius: 20px;" type="button"><span class="btn-inner--icon"><i class='bx bx-memory-card'></i></span> <span id="memory-value">2</span> GB Memory</a>
                      </div>

                      <div class="slider mb-4">
                        <input type="range" id="disk" min="2" max="50" value="8" oninput="slider('disk', 'disk-value')" style="width: 75%;">
                        <a class="btn btn-icon btn-2 btn-primary" style="border-radius: 20px;" type="button"><span class="btn-inner--icon"><i class='bx bx-hdd'></i></span> <span id="disk-value">8</span> GB Storage</a>
                      </div>
                      
                      <div class="slider mb-4">
                        <input type="range" id="cpu" min="1" max="5" value="2" oninput="slider('cpu', 'cpu-value')" style="width: 75%;">
                        <a class="btn btn-icon btn-2 btn-primary" style="border-radius: 20px;" type="button"><span class="btn-inner--icon"><i class='bx bx-chip'></i></span> <span id="cpu-value">1</span> CPU Cores</a>
                      </div>

                    </div>
                </div>
            </div>
        </div>

        <div style="width: 100%; margin-block-start: 100px;" class="modal" id="orderAll" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header card-header">
                        <h5 class="modal-title">Are you sure?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <strong>After hitting "Confirm Order", your order will be placed and the amount will be reducted from your current balance.</strong>
                        <p>Total Order: 0 USD</p>

                        <div class="form-group">
                            <label class="form-control-label" for="input-affiliate">Affiliate Code</label>
                            <input type="text" id="input-affiliate-code" class="form-control" placeholder="affiliate" />
                        </div>
                        <a onclick="Apply()" class="btn btn-primary btn-icon btn-sm mb-2"> Apply </a>
                        <a href="/affiliate/remove/apply" class="btn btn-danger btn-icon btn-sm mb-2">Remove</a><br />
                    </div>
                    <div class="modal-footer card-body">
                        <button type="button" class="btn btn-secondary btn-icon btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="https://demo.wemx.net/billing/cart/order/all" class="btn btn-success btn-icon btn-sm">Confirm</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/bundle.51fe1b5c.js" crossorigin="anonymous"></script>
    </div>
</div>

    <!-- Script -->
    <script type="text/javascript">
function slider(element, output){
  const mySlider = document.getElementById(element);
  const sliderValue = document.getElementById(output);

    valPercent = (mySlider.value / mySlider.max)*100;
    mySlider.style.background = `linear-gradient(to right, #3264fe ${valPercent}%, #d5d5d5 ${valPercent}%)`;
    sliderValue.textContent = mySlider.value;
}
slider();
    </script>

<style>
.slider {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
</style>
  @endsection
  </div>
  @include('templates.Carbon.inc.style')
  @include('templates.Carbon.inc.script')