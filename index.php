<?php
// inclua antes do código que utilizará o SDK
// require_once('./vendor/autoload.php');
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Inclua os links para os arquivos CSS e JavaScript do Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <br><br><br><br>
            <div class="col s12 m6 offset-m3">
                <!-- O card centralizado -->
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Fenix Participações</span>
                        <p>Sistema de integração com D4Sigin.</p>
                    </div>
                </div>

                <div class="card-panel grey lighten-5 z-depth-1">
                    <div class="row valign-wrapper">
                        <div class="col s6">
                            <img src="images/fenix.png" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s6">
                            <span class="black-text">
                                Fenix DTVM.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-panel grey lighten-5 z-depth-1">
                    <div class="row valign-wrapper">
                        <div class="col s6">
                            <img src="images/d4sigin.png" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s6">
                            <span class="black-text">
                                D4Sigin Assinatura Eletronica.
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
