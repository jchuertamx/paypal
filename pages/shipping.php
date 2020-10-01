<?php
/*
    * Shipping details page -  Mark Flow.
    * Buyer can enter shipping address information and choose shipping option on this page.
*/
    $rootPath = "../";
    include_once('../api/Config/Config.php');
    include_once('../api/Config/Sample.php');
    include('../templates/header.php');

    $baseUrl = str_replace("pages/shipping.php", "", URL['current']);
?>

<!-- HTML Content -->
<div class="row-fluid">
    <div class="col-md-offset-4 col-md-4">
        <h3 class="text-center">Carrito de Compra</h3>
        <hr>
        <form class="form-horizontal">
            <!-- Shipping Information -->
            <div class="form-group">
                <label for="product_name" class="col-sm-5 control-label">Product Name</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="product_name"
                           name="product_name"
                           value="Black Camera - Digital SLR"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="recipient_name" class="col-sm-5 control-label">Recipient Name</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="recipient_name"
                           name="recipient_name"
                           value="Juan Dunas"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="line1" class="col-sm-5 control-label">Address Line 1</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="line1"
                           name="line1"
                           value="Calle 5"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="line2" class="col-sm-5 control-label">Address Line 1</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="line2"
                           name="line2"
                           value="Piso 21"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-sm-5 control-label">City</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="city"
                           name="city"
                           value="New York"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-sm-5 control-label">State</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="state"
                           name="state"
                           value="NY"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="zip" class="col-sm-5 control-label">Postal Code</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="zip"
                           name="zip"
                           value="10022"
                           readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="item_amt" class="col-sm-5 control-label">Total Amount</label>
                <div class="col-sm-7">
                    <input class="form-control"
                           type="text"
                           id="item_amt"
                           name="item_amt"
                           value="<?= SampleCart['total_amt'] ?>"
                           >
                </div>
            </div>
            <div class="form-group">
                <label for="countrySelect" class="col-sm-5 control-label">Country</label>
                <div class="col-sm-7">
                    <select class="form-control" name="countrySelect" id="countrySelect">
                        <option value="MX">Mexico</option>
                        <option value="ZW">Zimbabwe</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="shippingMethod" class="col-sm-5 control-label">Shipping Type</label>
                <div class="col-sm-7">
                    <select class="form-control" name="shippingMethod" id="shippingMethod">
                        <optgroup label="United Parcel Service" style="font-style:normal;">
                            <option value="8.00">
                                Muy Lejos - $8.00</option>
                            <option value="4.00">
                                Lejos - $4.00</option>
                        </optgroup>
                        <optgroup label="Flat Rate" style="font-style:normal;">
                            <option value="2.00" selected>
                                Cerca - $2.00</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <!-- Checkout Options -->
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-7">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-7">
                    <!-- Container for PayPal Mark Checkout -->
                    <div id="paypalCheckoutContainer"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Javascript Import -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AWT-qIJ8KJ_Mg9_da1U3tbkZGAyC10sdYqH47JwSoHcLhN0TOCHlnB-bUES_hBZfgzhaIK2Fq_3Av-Xc"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script>

<script src="<?= $rootPath ?>js/config.js"></script>

<!-- PayPal In-Context Checkout script -->
<script type="text/javascript">

    paypal.Buttons({

        // Set your environment
        env: '<?= PAYPAL_ENVIRONMENT ?>',

        // Set style of button
        style: {
            layout: 'horizontal',   // horizontal | vertical
            size:   'responsive',    // medium | large | responsive
            shape:  'pill',      // pill | rect
            color:  'gold'       // gold | blue | silver | black
        },

        // Execute payment on authorize
        commit: true,

        // Wait for the PayPal button to be clicked
        createOrder: function() {

            let shippingMethodSelect = document.getElementById("shippingMethod"),
                updatedShipping = shippingMethodSelect.options[shippingMethodSelect.selectedIndex].value,
                countrySelect = document.getElementById("countrySelect"),
                total_amt = parseFloat(document.getElementById("item_amt").value) +
                        parseFloat(<?= SampleCart['tax_amt'] ?>) +
                        parseFloat(<?= SampleCart['handling_fee'] ?>) +
                        parseFloat(<?= SampleCart['insurance_fee'] ?>) +
                        parseFloat(updatedShipping) -
                        parseFloat(<?= SampleCart['shipping_discount'] ?>),
                postData = new FormData();
                postData.append('item_amt',document.getElementById("item_amt").value);
                postData.append('tax_amt','<?= SampleCart['tax_amt'] ?>');
                postData.append('handling_fee','<?= SampleCart['handling_fee'] ?>');
                postData.append('insurance_fee','<?= SampleCart['insurance_fee'] ?>');
                postData.append('shipping_amt',updatedShipping);
                postData.append('shipping_discount','<?= SampleCart['shipping_discount'] ?>');
                postData.append('total_amt',total_amt);
                postData.append('currency','<?= SampleCart['currency'] ?>');
                postData.append('return_url','<?= $baseUrl.URL["redirectUrls"]["returnUrl"]?>' + '?commit=true');
                postData.append('cancel_url','<?= $baseUrl.URL["redirectUrls"]["cancelUrl"]?>');
                postData.append('shipping_recipient_name',document.getElementById("recipient_name").value);
                postData.append('shipping_line1',document.getElementById("line1").value);
                postData.append('shipping_line2',document.getElementById("line2").value);
                postData.append('shipping_city',document.getElementById("city").value);
                postData.append('shipping_state',document.getElementById("state").value);
                postData.append('shipping_postal_code',document.getElementById("zip").value);
                postData.append('shipping_country_code',countrySelect.options[countrySelect.selectedIndex].value);

            return fetch(
                '<?= $rootPath.URL['services']['orderCreate']?>',
                {
                    method: 'POST',
                    body: postData
                }
            ).then(function(response) {
                return response.json();
            }).then(function(resJson) {
                return resJson.data.id;
            });
        },

        // Wait for the payment to be authorized by the customer
        onApprove: function(data, actions) {
            // Capture Order
            let postData = new FormData();
            return fetch(
                '<?= $rootPath.URL['services']['orderCapture'] ?>',
                {
                    method: 'POST',
                    body: postData
                }
            ).then(function(res) {
                return res.json();
            }).then(function() {
                window.location.href = 'success.php?commit=true';
            });
        }

    }).render('#paypalCheckoutContainer');

</script>
<?php
    include('../templates/footer.php');
?>