<div class="container">
    <form class="frm-prescription" method="POST">
        <h3 class=" text-center mt-3 text-info w-75">ĐƠN THUỐC</h3>

        <?php
        include_once("model/mHoaDonThanhToan.php");
        $p = new mHoaDonThanhToan();
        if (isset($_REQUEST["toathuoc"])) {
            $tblThuoc = $p->selectBenhNhanByIDToaThuoc($_REQUEST['toathuoc']);
            if ($tblThuoc == "error") {
                echo "ERROR";
            } else if (!$tblThuoc) {
                echo "0 result";
            } else {
                while ($r = $tblThuoc->fetch_assoc()) {
                    echo '
                        <h4 class="info-title h5">Thông tin bệnh nhân:</h4>
                        <div class="ms-4">
                            <p class="info-item">
                                Họ và tên: <span class="info-value">' . $r['HoTen'] . '</span>
                            </p>
                            <p class="info-item">
                                Mã hồ sơ: <span class="info-value">HS-2107' . $r['maBenhNhan'] . '</span>
                            </p>
                            <p class="info-item">
                                Địa chỉ:
                                <span class="info-value">' . $r['diaChi'] . '</span>
                            </p>
                            <p class="info-item">
                                Hình thức thanh toán:
                                <span class="info-value">
                                    ' . $_POST['slTien'] . '
                                </span>
                            </p>
                            <p class="info-item">
                                Mã BHYT: <span class="info-value">BHXH' . $r['maBHYT'] . '</span>
                            </p>
                        </div>';
                }
            }
        }
        ?>



        <?php
        if (isset($_REQUEST["toathuoc"])) {
            $tblThuoc = $p->selectToaThuocByIDToaThuoc($_REQUEST['toathuoc']);
            if ($tblThuoc == "error") {
                echo "ERROR";
            } else if (!$tblThuoc) {
                echo "0 result";
            } else {
                echo '
                    <h4 class="section-title h5">Chuẩn đoán:</h4>
                    <table class="table table-striped table-bordered w-75">
                        <tr>
                            <th>Mã</th>
                            <th>Chuẩn đoán</th>
                            <th>Kết luận</th>
                        </tr>
                    ';
                $tongtien = 0;
                while ($r = $tblThuoc->fetch_assoc()) {
                    echo '
                        <tr>
                            <td>CD0' . $r['maToaThuoc'] . '</td>
                            <td>' . $r['chuanDoan'] . '</td>
                            <td>' . $r['ketLuan'] . '</td>
                        </tr>
        
                        ';
                }
                echo '</table>';
            }
        }
        ?>



        <div class="treatment-section">
            <h4 class="h5">Thuốc điều trị:</h4>
            <table class="table table-striped table-bordered w-75">
                <table class="table table-striped table-bordered w-75">
                    <?php
                    if (isset($_REQUEST["toathuoc"])) {
                        $tblThuoc = $p->selectThuocDieuTriByIDToaThuoc($_REQUEST['toathuoc']);
                        if ($tblThuoc == "error") {
                            echo "ERROR";
                        } else if (!$tblThuoc) {
                            echo "0 result";
                        } else {
                            echo '<tr>
                                <th>Mã thuốc</th>
                                <th>Tên thuốc</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Giảm BHYT</th>
                                <th>Thành tiền</th>
                            </tr>';
                            $tongtien = 0;
                            while ($r = $tblThuoc->fetch_assoc()) {

                                $thanhtien = $r['soLuongCapPhat'] * $r['Gia'] - $r['soLuongCapPhat'] * $r['Gia'] * ($r['mucBHYT'] / 100);
                                echo '
                            
                            <tr>
                                <td>' . $r['maThuoc'] . '</td>
                                <td>' . $r['tenThuoc'] . '</td>
                                <td>' . $r['soLuongCapPhat'] . '</td>
                                <td>' . number_format($r['Gia'], 0, ',', ',') . ' VND</td>
                                <td>' . $r['mucBHYT'] . '%</td>
                                <td>' . number_format($thanhtien, 0, ',', ',') . ' VND</td>
                            </tr>';
                                $tongtien += $thanhtien;
                            }
                        }
                    }
                    ?>


                </table>
                <h5 class="total-amount">
                    Tổng tiền: <span class="total-value" name="tongTien"><?php echo number_format($tongtien, 0, ',', ',') ?> VND</span>
                </h5>
        </div>

        <div class="instructions-section">
            <label for="instructions" class="instructions-label">Lời dặn:</label>
            <span><?php echo $_POST['loiDan'] ?></span>
        </div>

        <button class="btn btn-primary text-white mt-4 ps-4 pe-4" name="btnIn">In</button>
    </form>
</div>

<?php
if (isset($_REQUEST['btnIn'])) {
    $idtoa = $_REQUEST['toathuoc'];
    $tblThuoc = $p->updateToaThuocByMaToa(4);
    echo $tblThuoc;
    if (!$tblThuoc) {
        echo "<script>alert(\"0 result\")";
    } else {
        echo '<script>alert("In thành công");';
        echo 'window.location.href = "index-staff.php?page-sub=DanhSachDonThuoc";</script>';
    }
}
?>