{{-- @dd($products->data->metadata) --}}
<style>
.card-wrapper {
  background-color: #fff;
  border-radius: 25px;
  padding: 30px 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  position: relative;
  color: #281F48;
}

.card-wrapper h4,
.card-wrapper p,
.card-wrapper li {
  color: #281F48 !important;
}

.highlight-card {
  background-color: #281F48 !important;
  color: white !important;
}

.highlight-card h4,
.highlight-card p,
.highlight-card li {
  color: white !important;
}

.highlight-card .custom-btn-2 {
  background-color: #FD5631;
  color: white;
  font-weight: bold;
  border: none;
}
.highlight-card .custom-btn-2 {
    background-color: #FD5631;
    color: white;
    font-weight: bold;
    border: none;
    margin-top: 39px;
}
.highlight-card .custom-btn-2:hover {
  background-color: #d84727;
}
.highlight-card {
    background-color: #281F48 !important;
    color: white !important;
    bottom: 87px;

}
.highlight-card::before {
  content: "MOST POPULAR";
  position: absolute;
  top: -10px;
  right: 20px;
  background: red;
  color: white;
  padding: 3px 10px;
  font-size: 12px;
  font-weight: bold;
  border-radius: 3px;
  z-index: 1;
}
.bg-image {
 background-image: url('/web/images/finalbackground.png') !important;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50px;
}
</style>

<div class="container-fluid section-bg py-4">
  <div class="container">
    <h2 class="sec">1: Plans & Pricing</h2>

    <div class="row bg-image pt-lg-4  p-3 mt-lg-4 mt-xl-5 mt-2">
      @foreach ($products as $product)
        @php
          $isQuarterly = strtolower($product->name) == 'quarterly';
          $isCurrent = isset($subscription->current_subscription) && $subscription->current_subscription == $product->id;
          $isFree = $product->id == 'prod_RTgB3KyZygKo2I' && Auth::user()->free_package_availed == '0';
        @endphp

        <div class="col-lg-4 p-lg-4 p-3 {{ $product->metadata->hide == 'true' ? 'd-none' : '' }}">
          <div id="plan{{ $product->id }}-container" 
               class="card-wrapper {{ $isQuarterly ? 'highlight-card' : '' }} {{ $isCurrent ? 'card-price' : '' }}">
            
            {{-- Show price or fallback --}}
            @if (!empty($product->prices) && count($product->prices) > 0)
              @foreach ($product->prices as $price) @endforeach
            @else
              <h4 class="sec">Price not available</h4>
            @endif

            <h4 class="sec" style="font-size:27px !important;color: #FD5631 !important;">
              <strong>{{ $product->name }} {{ $product->metadata?->freemium == 'true' ? '' : '/ ' . $product->metadata?->price }}</strong>
            </h4>

            <p style="font-weight:600;">Enjoy your 
              <span style="color: #FD5631;">{{ $product->name }}</span> and explore marketplace options.</p>

            @if (!empty($product->marketing_features))
              <ul class="list-unstyled">
                @foreach ($product->marketing_features as $feature)
                  <li><img src="{{ asset('web/images/check-circle-11.png') }}" class="img-fluid" alt="..."> {{ $feature['name'] }}</li>
                @endforeach
              </ul>
            @else
              <p>No features available</p>
            @endif

            <input type="hidden" name="amount" class="amountInput" value="{{ $product->metadata->price }}">
            <input type="hidden" name="price_id" class="price_id_input" value="{{ $product->default_price }}">

            <a class="btn custom-btn-2 w-100"
               id="choose-plan-{{ $product->id }}"
               onclick="selectPlan('plan{{ $product->id }}', 'plan{{ $product->id }}-container', {{$product->metadata->price}}, '{{$product->default_price}}'); changeText(this); return false;">
               Choose plan
            </a>

            <input type="radio" id="plan{{ $product->id }}" name="plan" style="display: none;"
                   value="{{ $product->id }}" class="btn custom-btn-2" required>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<script>
function selectPlan(radioId, containerId, priceAmount, priceId) {
  var plan = radioId.replace("plan", "");
  var free_package_availed = {{ json_encode(Auth::user()->free_package_availed) }};
  var ads_count = {{ json_encode(Auth::user()->ads_count) }};

  if (plan == 'prod_RTgB3KyZygKo2I' && free_package_availed == 1) {
    toastr.error('You have already availed the free package. Please select another plan.');
    return;
  }

  if (plan == 'prod_RTgB3KyZygKo2I' && ads_count <= 5) {
    window.location = 'signupwithfreeplan';
    return;
  }

  document.querySelectorAll('input[name="plan"]').forEach((radio) => radio.checked = false);
  document.querySelectorAll('.card-wrapper').forEach((div) => div.classList.remove('card-price'));

  document.getElementById(radioId).checked = true;
  document.getElementById(containerId).classList.add('card-price');

  document.querySelectorAll('.amountInput').forEach((input) => input.value = priceAmount);
  document.querySelectorAll('.price_id_input').forEach((input) => input.value = priceId);
}

function changeText(element) {
  document.querySelectorAll('.btn.custom-btn-2.w-100').forEach(anchor => {
    anchor.innerText = "Choose plan";
  });

  element.innerText = "Selected";
}
</script>
