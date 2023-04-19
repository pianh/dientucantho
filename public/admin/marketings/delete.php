<?php

    if (session_id() === '') {
        session_start();
    }

    if (!isset($_SESSION['kh_tendangnhap_logged'])){
        echo '<script>location.href = "/admin/auth/login.php";</script>';
    }
    require_once '../../../bootstrap.php';

    $kh_tendangnhap_logged=htmlspecialchars($_SESSION['kh_tendangnhap_logged']);

    if ($kh_tendangnhap_logged !='admin' ) {
        $message = "Bạn không phải là thành viên quản trị website! Bạn không được phép truy cập vào trang này!!!!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo '<script>location.href = "/index.php";</script>';
    }

    use DientuCT\Project\Marketing;
    $marketing = new Marketing($PDO);

    $mkt_ma = isset($_REQUEST['mkt_ma']) ?
        filter_var($_REQUEST['mkt_ma'], FILTER_SANITIZE_NUMBER_INT) : -1;

        if ($mkt_ma < 0 || !($marketing->find($mkt_ma))) {
            redirect(BASE_URL_PATH .'admin/marketings/index.php');
        }

    $errors = [];

?>

<?php
    // Khi người dùng bấm lưu thì tiến hành xử lý
    if (
        $_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['submit'])
        && isset($_POST['mkt_ma'])
        && ($marketing->find($_POST['mkt_ma'])) !== null
    ) {
        $marketing->delete();
        echo '<script>location.href = "index.php"; </script>';
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa thông tin Marketing sản phẩm</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/bootstrap.min.css" ?>" type="text/css" />
    <!-- Font awesome -->
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/font-awesome.min.css" ?>" type="text/css" />
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/datatables.min.css" ?>" type="text/css" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/animate.css" ?>" type="text/css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/base.css" ?>" type="text/css" />
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/styles.css" ?>" type="text/css" />
    <link rel="stylesheet" href="<?= BASE_URL_PATH . "assets/admin/css/responsive.css" ?>" type="text/css" />

</head>
<body>
    
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);     
    ?>

    <?php include_once __DIR__ . '../../../../partials/admin/header.php'; ?>
    
    <div class="container-fluid">

        <div class="main row">
            <?php include_once __DIR__ . '../../../../partials/admin/sidebar.php'; ?>

            <div class="main__outer">
                <div class="main__inner">
                    <!-- Page Title -->
                    <div class="page-title wow fadeIn" data-wow-delay="0.05s">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading wow fadeIn" data-wow-duration="1s">
                                <div class="page-title-icon"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
                                <div>
                                    Xóa thông tin Marketing sản phẩm
                                    <div class="page-title-subheading wow fadeIn" data-wow-duration="2s">Xóa thông tin Marketing cho sản phẩm của bạn.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Content -->
                    <div class="tabs-animation">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                Table Xóa thông tin Marketing cho Sản phẩm
                            </div>
                            <div class="card-body">
                                <!-- Form xóa sản phẩm -->
                                <form name="frmDelete" id="frmDelete" method="post"  action="">
                                        <div class="form-row">
                                            <div class="col-sm-2 form-group<?= isset($errors['mkt_ma']) ? ' has-error' : '' ?>">
                                                <label for="mkt_ma">Mã/ID Marketing (*)</label>
                                                <input type="text" name="mkt_ma" class="form-control" maxlen="255" readonly id="mkt_ma" placeholder="Mã/ID Marketing" value="<?= $marketing->getMkt_ma() ?>" />
                                            </div>

                                            <div class="col-sm-4 form-group<?= isset($errors['sp_ten']) ? ' has-error' : '' ?>">
                                                <label for="sp_ten">Marketing cho sản phẩm</label>
                                                <input type="text" name="sp_ten" class="form-control" maxlen="255" readonly id="sp_ten" placeholder="Marketing cho sản phẩm" value="<?= htmlspecialchars($marketing->sp_ten) ?>" />
                                            </div>

                                            <div class="col-sm-6 form-group<?= isset($errors['mkt_tinhtrang']) ? ' has-error' : '' ?>">
                                                <label for="mkt_tinhtrang">Thông tin tình trạng</label>
                                                <input type="text" name="mkt_tinhtrang" class="form-control" maxlen="255" readonly id="mkt_tinhtrang" placeholder="Thông tin tình trạng" value="<?= htmlspecialchars($marketing->mkt_tinhtrang) ?>" />
                                            </div>
                                            
                                        </div>

                                    <button name="submit" id="submit" class="btn btn-danger mt-3">
                                        Xóa sản phẩm
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '../../../../partials/admin/footer.php'; ?>
    <!-- jQuery JS -->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/jquery.min.js" ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/bootstrap.min.js" ?>"></script>
    <!-- Wow js -->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/wow.min.js" ?>"></script>
    <!-- SweetAlert JS-->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/sweetalert.js" ?>"></script>
    <script src="<?= BASE_URL_PATH . "assets/admin/js/sweetalert.min.js" ?>"></script>
    <!-- Chart JS-->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/chart.min.js" ?>"></script>
    <!-- DataTable JS -->   
   <script src="<?= BASE_URL_PATH . "assets/admin/js/datatables.min.js" ?>"></script>
   <script src="<?= BASE_URL_PATH . "assets/admin/js/buttons.bootstrap4.min.js" ?>"></script>
   <script src="<?= BASE_URL_PATH . "assets/admin/js/pdfmake.min.js" ?>"></script>
   <script src="<?= BASE_URL_PATH . "assets/admin/js/vfs_fonts.js" ?>"></script>
    <!-- Custom JS -->
    <script src="<?= BASE_URL_PATH . "assets/admin/js/app.js" ?>"></script>

    <script>
        $(document).ready(function() {
            //Gọi wow js
            new WOW().init();

            //Header toggle-mobile click
            $('#header__toggle-mobile').click(function() {
                // alert('ok');
                $('.header__content').slideToggle();
            })
            
        });
    </script>

</body>
</html>