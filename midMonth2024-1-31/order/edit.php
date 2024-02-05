<?php
// require __DIR__ . '/admin-required.php';

// require __DIR__ . '/parts/db connect2.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
$pageName = "edit";
$title = "編輯";

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$sql = "SELECT
o.order_id,
cus.custom_name,
o.order_date,
o.payment_method,
pd.product_name,
pd.product_id,
pd.price,
pd.stock_quantity,
od.order_quantity,
od.detail_id,
pd.price * od.order_quantity AS subtotal,
o.order_amount,
o.discount,
o.total_amount
FROM
order_details AS od
JOIN
orders AS o ON od.order_id = o.order_id
JOIN
products AS pd ON od.product_id = pd.product_id
JOIN
custom AS cus ON o.custom_Id = cus.custom_Id
WHERE
o.order_id=$order_id
GROUP BY
o.order_id,
cus.custom_name,
o.order_date,
o.payment_method,
pd.product_name,
pd.product_id,
pd.price,
od.order_quantity,
od.detail_id,
o.order_amount,
o.discount,
o.total_amount
ORDER BY
od.detail_id ASC";

//$pdo->query($sql)->fetch();//不要用fetchAll
$row = $pdo->query($sql)->fetch();

$orderDetails = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
#如果sid頁碼是空值就跳轉到list最開始
if (empty($row)) {
  header("Location: list.php");
  exit(); #結束PHP程式
}




?>

<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include __DIR__ . '/parts/html-head.php';


// include __DIR__ . '/parts/navbar.php' ；
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[name^="order_quantity[]"]');
    const priceInputs = document.querySelectorAll('input[name^="price[]"]');
    const subtotalInputs = document.querySelectorAll('input[name^="subtotal[]"]');
    const totalAmountInput = document.getElementById('total_amount');

    // 更新小計的函數
    function updateSubtotal(index) {
      const quantity = parseFloat(quantityInputs[index].value);
      const price = parseFloat(priceInputs[index].value);
      const subtotal = isNaN(quantity) || isNaN(price) ? 0 : quantity * price;
      subtotalInputs[index].value = subtotal.toFixed(0);

      // 更新總金額
      updateTotalAmount();
    }

    // 更新總金額的函數
    function updateTotalAmount() {
      let totalAmount = 0;
      subtotalInputs.forEach((input) => {
        totalAmount += parseFloat(input.value) || 0;
      });

      totalAmountInput.value = totalAmount.toFixed(0);
    }

    // 監聽每個數量欄位的變更事件
    quantityInputs.forEach((input, index) => {
      input.addEventListener('input', function() {
        updateSubtotal(index);
      });
    });

    // 初始化計算一次總金額
    updateTotalAmount();
  });
</script>
<style>
  /* 新增 */
  form .mb-3 .form-text {
    color: red;
  }

  .table {
    --bs-table-striped-bg: rgba(221, 235, 255, 0.5) !important;
    --bs-table-hover-bg: rgba(93, 135, 255, 0.3) !important;
  }

  /* .toptable {
    font-weight: 600;
    color: #2A3547;
  } */
</style>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card mt-5 mb-3">
        <div class="card-body col-10 mx-auto ">
          <h2 class=" my-4 text-center">訂單資料</h2>
          <table class="table table-bordered table-striped table-hover text-center">
            <thead>
              <tr>
                <!-- 追加刪除與新增 -->

                <th>#</th>
                <th>訂單日期</th>
                <th>訂單編號</th>
                <th>顧客姓名</th>
                <th>付款方式</th>
              </tr>
            </thead>
            <tbody>

              <?php
              // 組合流水編號和日期生成訂單編號
              $orderIDString = strval($row['order_id']);
              $currentDate = date("Ymd", strtotime($row['order_date']));
              $orderNumber = $currentDate . $orderIDString;
              ?>
              <tr class="toptable">
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td><?= $orderNumber ?></td>
                <td><?= $row['custom_name'] ?></td>
                <td><?= $row['payment_method'] ?></td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="clo-6">
      <div class="card mb-5">
        <div class="card-body col-10 mx-auto">
          <h2 class=" my-4 text-center">訂購商品</h2>
          <!-- 表單 -->
          <form name="form1" method="post" onsubmit="sendForm(event)">
            <!-- 新增編號顯示(不會傳值) -->

            <?php foreach ($orderDetails as $p) : ?>
              <input type="text" value="<?= $p['order_id'] ?>" hidden name="order_id">
              <input type="text" value="<?= $p['detail_id'] ?>" hidden name="detail_id[]">
              <table class="table table-bordered table-striped table-hover mt-3 text-center">
                <thead>
                  <tr>
                    <th>商品ID</th>
                    <th>商品名稱</th>
                    <th>商品單價</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <!-- 商品ID -->
                    <td><label class=""><?= $p['product_id'] ?></label></td>
                    <!-- 傳編號值 -->
                    <input type="hidden" name="product_id[]" value="<?= $p['product_id'] ?>">
                    <!-- 商品名稱數值 -->
                    <td><label class=""><?= $p['product_name'] ?></label></td>
                    <!-- 傳編號值 -->
                    <input type="hidden" name="product_name[]" value="<?= $p['product_name'] ?>">

                    <!-- 單價數值 -->
                    <td><label class=""><?= $p['price'] ?></label></td>
                    <!-- 傳編號值 -->
                    <input type="hidden" name="price[]" value="<?= $p['price'] ?>">
                  </tr>
                </tbody>
              </table>

              <div class="mb-1">
                <label class="form-label">購買數量</label>
                <input type="number" class="form-control" name="order_quantity[]" value="<?= $p['order_quantity'] ?>">
                <div class="form-text"></div>
              </div>

              <div class="mb-5">
                <label class="form-label">小計</label>
                <input type="text" class="form-control" name="subtotal[]" readonly value="<?= $p['subtotal'] ?>">
                <div class="form-text"></div>
              </div>
              <hr>

            <?php endforeach ?>

            <div class=" mt-5 mb-5">
              <label for="total_amount" class="form-label">總金額</label>
              <input type="text" class="form-control mb-1" id="total_amount" name="total_amount" readonly value="<?= $row['total_amount'] ?>">
              <!-- <div class="fs-5 warning-message mt-3"></div> -->
            </div>


            <div class="d-flex justify-content-between my-3">
              <div class="align-self-center fs-5 warning-message"></div>
              <button type="submit" class="btn btn-primary px-5 btn-lg">修改訂單</button>
            </div>

          </form>
        </div><!-- class card-body -->
      </div><!-- class card -->

    </div><!-- class clo6 -->
  </div><!-- class row -->

</div> <!-- container END -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        修改成功
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
        <a type="button" class="btn btn-primary" href="./list.php">回到列表</a>
      </div>
    </div>
  </div>
</div><!-- Modal  END-->


<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
// include __DIR__ . '/parts/scripts.php';
// include __DIR__ . '/parts/html-foot.php'; 


?>
<script>
  const sendForm = e => {
    e.preventDefault();


    let isPass = true;


    if (isPass) {
      // "沒有外觀"的表單
      const fd = new FormData(document.form1);

      /*編輯的api連結*/
      fetch('edit-api.php', {
          method: 'POST',
          body: fd, //表單會自動是content-type: multipart/form-data
        }).then(r => r.json()) //改為json
        .then(result => {
          console.log({
            result
          });
          const warningElement = document.querySelector('.warning-message');
          if (result.success) {
            warningElement.innerHTML = '';
            warningElement.style.color = '';

            myModal1.show();
          } else {
            // success為false時，顯示警告
            warningElement.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> 尚未修改';
            warningElement.style.color = '#FA896B';
          }
        }).catch(ex => console.log(ex)) //除錯用
    }

  }

  // bootstrap modal Via JavaScript
  const myModal1 = new bootstrap.Modal(document.getElementById('exampleModal'));
</script>
