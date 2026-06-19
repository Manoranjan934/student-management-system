<?php
session_start();
if(isset($_SESSION['isAdminLogin']) == 1){
    ?>
        <script type="text/javascript">
            alert("can't be logout")
            window.open("http://localhost/SMS/Admin/Admin_login.php","_self")
        </script>
    <?php
}else{
    unset($_SESSION['email']);
    ?>
    <script type="text/javascript">
        alert('Logout successfully')
        window.open("http://localhost/SMS/Admin/Admin_login.php","_self")
    </script>
<?php
}
?>