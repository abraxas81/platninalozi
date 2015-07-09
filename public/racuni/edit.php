<?php require_once('../../includes/initialize.php');

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$racun = new Racun();
if (isset($_POST['submit'])) {
    $racun->id = $_POST['id'];
    $racun->naziv = trim($_POST['naziv']);
    $racun->iban = $_POST['iban_prefix'] . $_POST['iban'];
    /*$racun->created_at = date('YMd hms');
    $racun->updated_at = date('YMd hms');*/
    $racun->korisnik_id = $_SESSION['user_id'];
    if ($racun->save()) {
        $session->message = ("Račun je uspješno promjenjen !!!");
        redirect_to('create.php');
    } else {
        //Neuspješno
        $message = join("<div class=alert alert-error>$racun->errors</div><br>");
    }
}

if (empty($_GET['id'])) {
    $session->message("Nije zaprimljen id računa");
    redirect_to('index.php');
}
$racun = Racun::find_by_id($_GET['id']);

include_layout_template('admin_header.php');

include_layout_template('sidebar.php');

?>
<div class="span12">
    <form name="postForm" id="racunForm" method="POST">
        <div class="form-horizontal">
            <table>
                <tr>
                    <th>Uredi račun</th>
                </tr>
                <tbody>
                <?php include('form.php'); ?>
                <tr>
                    <td><input type="submit" name="submit" id="dodaj" value="Uredi račun"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('form#racunForm').submit(function (event) {
            var iban = $('#iban_prefix').val() + $('#iban').val();
            console.log(iban)
            if (IBAN.isValid(iban)) {
                return true;
            } else {
                event.preventDefault(); //Prevent the default submit
                $("#errmsg").html("Ispravite").show();
            }
        });
    });
</script>
