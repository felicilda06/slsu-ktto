<!DOCTYPE html>

<head>
    <?php
      include 'dependencies.php';
    ?>

    <link rel="stylesheet" href="./assets/css/main.css">
   
    <title>SOUTHERN LEYTE STATE U - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="hide" id='verify_container'>
        <div class="verify_modal">
            <i class="fa fa-close" id="btn_close"></i>
            <p>Enter the vefication code for <strong>Patent Drafter</strong> users.</p>
           <form>
            <input type="text" id="verificaition_code" class="form-control" placeholder="Verification Code" autocomplete="off" required>
            <button type="submit" id="btn_verify" class="btn btn-block btn-sm btn-primary">Verify</button>
           </form>
        </div>
    </div>

</body>

</html>