<?php include '../../include/include_billDetails.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mautrechnung</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../../images/logo-big.png">
      </div>
      <h1>Rechnung #<?php echo $bill_id ?></h1>
      <div id="company" class="clearfix">
        <div>Gruppe 6 security corporation</div>
        <div>GG Street 42,<br /> 1337 Berlin </div>
      </div>

      <div id="briefkopf">
        <div><span>Kennzeichen</span> <?php echo $licensePlate ?></div>
        <div><span>Zeitpunkt</span> <?php echo $exitTime ?></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">Art</th>
            <th class="desc">Beschreibung</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Start</td>
            <td class="desc">Autobahn <?php echo $entryTollgateHighway ?> Auffahrt <?php echo $entryTollgateInterchange ?><br>Am <?php echo $entryTime ?></td>
            <td class="unit">Mautstellen Code <?php echo $entryTollgateCode ?></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td class="service">Strecke</td>
            <td class="desc"><?php echo $distance ?> Kilometer.</td>
            <td class="unit"></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td class="service">Ende</td>
            <td class="desc">Autobahn <?php echo $exitTollgateHighway ?> Ausfahrt <?php echo $exitTollgateInterchange ?><br>Am <?php echo $exitTime ?></td>
            <td class="unit">Mautstellen Code <?php echo $exitTollgateCode ?></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td class="total">400€</td>
          </tr>
          <tr>
            <td colspan="4"> </td>
            <td class="total">-5%</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">Summe</td>
            <td class="grand total"><?php echo $costs ?> €</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>Zahlungsbedingungen:</div>
        <div class="notice">Zahlbar innerhalb von 14 Tagen ohne Abzug</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
