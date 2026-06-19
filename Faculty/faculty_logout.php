<?php
session_start();
if(isset($_SESSION['isFacultyLogin']) == 1){
    ?>
        <script type="text/javascript">
             alert("Logout successfully")
            window.open("http://localhost/SMS/faculty/faculty_login.php","_self")
        </script>
    <?php
}else{
    unset($_SESSION['email']);
    ?>
    <script type="text/javascript">
        alert('Logout successfully')
        window.open("http://localhost/SMS/faculty/faculty_login.php","_self")
    </script>
<?php
}
?>