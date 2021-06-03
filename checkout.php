<?php 
  session_start();
  $totalAmount = $_SESSION['totalamt'];
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<input type="hidden" value="<?php echo $totalAmount; ?>" id ="totalAmount"> 

<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>

var tamount = $('#totalAmount').val();
    console.log(tamount);

  paypal.Button.render({
    env: 'sandbox',
    client: {
      sandbox: 'AaXdhgghusfpK6kdDomS-PJprmNGxLsRv77N-C1qr2zE37qz4nINKP9XNwOEdGGnXXit-PvNCBjn5DMv'
    },
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
            total: tamount,
            currency: 'INR'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
        window.alert('Thank you for your purchase!');
      });
    }
  }, '#paypal-button');

</script>