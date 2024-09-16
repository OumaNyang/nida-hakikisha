<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NIDA VERIFICATION</title>
 
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 
  <link rel="stylesheet" href="assets/css/app.styles.css">
  
</head>
<body>
  <div class="container py-5 gy-4">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header">
            <h5>NIDA Verification:</h5>
          </div>
          <div class="card-body p-2">
            <p>This is an unofficial National Identification Number (NIN) issued by the NIDA Verification portal that looks up the NIN number you provided against the government database.</p>
            <form id="nidaForm" action="#" method="post" autocomplete="off">
              <div class="form-group mt-1">
                <label for="nida_number" class="control-label">Enter NIDA Number:</label>
                <input required type="text" class="form-control form-control-sm rounded-pill mt-2"
                  data-toggle="input-mask" data-mask-format="00000000 00000 00000 00" 
                  id="nida_number" name="nida_number" />
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-sm rounded-pill btn-outline-success float-end">Lookup NIN</button>
              </div>
            </form>
          </div>
         
        </div>
        <div class="border border-secodary  bg-white p-2 mt-2 text-primary  rounded-2 ">
   <p>If you need bulk NIN verification for your customers' KYC, contact us for an API endpoint which can be easily integrated into your business website for identity validation.</p>
            <p>Send us an email at support@azacloud.com</p>
        </div>

        <div class="d-block mt-1 py-4 text-center">
          <div id="nida_response"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="assets/js/jquery@3.7.1.min.js"></script>
  <!-- jQuery Mask Plugin -->
  <script src="assets/js/jquery.mask.min.js@1.14.16.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  <!-- Custom JavaScript -->
  <script src="assets/js/app.amplifier.js"></script>
</body>
</html>
