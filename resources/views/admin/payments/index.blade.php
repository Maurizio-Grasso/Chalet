@extends('layouts.dashboard-no-js')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="tab-title">Sponsorizza il tuo Appartamento</h1>
    </div>
  </div>


  <div class="row">
    <div class="col-12">
      {{-- FORM PAGAMENTO --}}
      <form action="">
        <div class="form-group col-md-4">
          <label for="apartmentChoice">Scegli un appartamento</label>
          <select id="apartmentChoice" class="form-control form-control-lg" onchange="valApt()">
            <option selected>Scegli un'opzione</option>
            @foreach ($apartments as $apartment)
                <option value="{{$apartment->id}}">{{$apartment->title}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="sponsorshipChoice">Scegli quanto sponsorizzare</label>
          <select id="sponsorshipChoice" class="form-control form-control-lg" onchange="valSpn()">
            <option selected>Scegli un'opzione</option>
            @foreach ($sponsorships as $sponsorship)
                <option value="{{$sponsorship->id}}">{{$sponsorship->name}} ( {{$sponsorship->hours}} ore - {{$sponsorship->amount}} €)</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-md-4" >
          <label for="status">Inserisci dati pagamento</label>
          <div id="dropin-container"></div>
        </div>
      </form>
      <button type="submit" id="submit-button" class="btn btn-success ml-4">Paga ora</button>
    </div>
  </div>
</div>
@endsection



{{-- SCRIPT PER FAR FUNZIONARE PAGAMENTO
dovuto togliere app.js perchè in conflitto --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>
<script>
      var apt_id;
      var spons_id;
      function valApt(){
        apt_id= document.getElementById('apartmentChoice').value;
        console.log(apt_id);
      }
      function valSpn(){
        spons_id= document.getElementById('sponsorshipChoice').value;
        console.log(spons_id);
      }
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: "{{ Braintree\ClientToken::generate() }}",
            container: '#dropin-container'
            }, function (createErr, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    $.get('{{ route('admin.payments.make') }}', {payload}, function (response) {
                        console.log(response);

                        // se non vuoi usare alert ma altro messaggio, ricorda che puoi utilizzare setTimeout
                        if (response.success) {
                            alert('Payment successfull!');
                            $(window.location).attr('href', "create-sponsorship/"+ apt_id+ "/"+spons_id+ "/"+1);
                      
                        } else {
                            alert('Payment failed'); 
                            $(window.location).attr('href', "create-sponsorship/"+ apt_id+ "/"+spons_id+ "/"+0);
                        }
                    }, 'json');
                });
            });
        });
        </script>
</body>
</html>