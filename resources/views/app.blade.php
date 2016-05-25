<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Taxpayers' Data</title>
  <meta name="author" content="The TaxPayers Alliance">
  <meta name="description" content="Taxpayers have a right to know how their money is spent and who is spending it. This database allows users to find out how their county and district authorities are spending their money as revealed by TaxPayers' Alliance research">
  <meta name="keywords" content="tax, local council, council tax, spending, taxpayers alliance, taxpayers' alliance, tpa, taxpayers, district council, research, taxpayers data">
  <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
</head>

<body>
  <div class="container">
    <div class="content">

    @yield('content')
        <div class="centered">
        <div>
          <a href="http://www.taxpayersalliance.com/contact_us" target="_blank"> <img class="icons" src="images/Email.png" alt="Email Icon"></a>
          <a href="https://www.facebook.com/taxpayersalliance" target="_blank"><img class="icons" src="images/Facebook.png" alt="Facebook Icon"></a>
          <a href="https://twitter.com/the_tpa" target="_blank"><img class="icons" src="images/Twitter.png" alt="Twitter Icon"></a>
          <a href="https://www.youtube.com/user/TaxpayersallianceUK" target="_blank"><img class="icons" src="images/Youtube.png" alt="Youtube Icon"></a>
          <a href="https://github.com/TaxpayersAlliance" target="_blank"><img class="icons" src="images/GitHub.png" alt="Github logo" /></a>
        </div>
        <p>All source code for these projects is available on <a href="https://github.com/TaxpayersAlliance">GitHub</a></p>
        <div class="disclaimer">
          <a href="http://www.taxpayersalliance.com" target="_blank"><img src="images/logo.png" class="logo" alt="TaxPayers' Alliance white logo" /></a>
          <p> TaxPayers' Alliance is a trading name of The TaxPayers' Alliance Limited, a company incorporated in England & Wales under company registration no. 04873888 and whose registered office is at 55 Tufton Street, London SW1P 3QL</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>